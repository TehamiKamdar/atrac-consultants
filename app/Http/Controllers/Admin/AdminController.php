<?php
namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\hero;
use App\Models\country;
use App\Models\consults;
use App\Models\services;
use Illuminate\Http\Request;
use App\Mail\InquiryHoldMail;
use App\Models\inquiry_holds;
use App\Models\countrydetails;
use App\Mail\InquiryActiveMail;
use App\Mail\InquiryRejectMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\program_level;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    private function fetchInquiries(array $statuses)
    {
        return DB::table('consults')
            ->join('countries', 'consults.country_id', '=', 'countries.id')
            ->select(
                'consults.id',
                'consults.name',
                'consults.phone',
                'consults.email',
                'countries.name as country_name',
                'consults.qualification',
                'consults.field',
                'consults.message',
                'consults.percentage',
                'consults.date',
                'consults.time',
                'consults.office_location',
                'consults.status',
                'consults.created_at',
                'consults.reason',
                'consults.is_seen',
            )
            ->whereIn('consults.status', $statuses)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('status'); // Grouping by status
    }



    public function consultAllIndex()
    {

        $inquiries = $this->fetchInquiries(['active', 'pending', 'hold', 'reject']);

        return view('admin.consult.index', [
            'activeinquiries' => $inquiries->get('active', collect()),
            'pendinginquiries' => $inquiries->get('pending', collect()),
            'holdinquiries' => $inquiries->get('hold', collect()),
            'rejectinquiries' => $inquiries->get('reject', collect())
        ]);
    }

    public function makeconsultsseen(){
        try{
            consults::where('is_seen', false)->update(['is_seen' => true]);
            return response()->json([
                'success' => true,
                'message' => 'Consults Seen',
            ]);
        }catch(\Exception $e){
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function updateStatusOfInquiry(Request $req, $id)
    {
        $req->validate([
            'status' => 'required|in:pending,active,hold,reject',
            'reason' => 'required_if:status,hold,required_if:status,reject|string|nullable',
            'date' => 'nullable|date',
            'time' => 'nullable|time',
        ]);

        $status = $req->status;

        // Step 1: Update main inquiry
        $inquiry = consults::findOrFail($id);
        $inquiry->status = $status;
        $inquiry->save();

        if ($status === 'active') {
            $datetime = $req->datetime; // "2025-08-08T14:30"
            $date = date('Y-m-d', strtotime($datetime)); // "2025-08-08"
            $time = date('H:i:s', strtotime($datetime)); // "14:30:00"
            $inquiry->date = $date;
            $inquiry->time = $time;
            $inquiry->reason = null;
            $inquiry->save();

            // Fetch consult user
            $consult = consults::findOrFail($id);

            // Prepare data for email
            $mailData = [
                'name' => $consult->name,
                'date' => Carbon::parse($date)->format('d M Y'),
                'time' => Carbon::parse($time)->format('h:i A'),
            ];

            $mailData['office_email'] = 'apply@atracconsultants.com';
            // Location-specific overrides
            if ($consult->office_location == 'islamabad') {
                $mailData['office_phone'] = '+92 326 5209992';
            } elseif($consult->office_location == 'lahore') {
                $mailData['office_phone'] = '+92 328 5209992';
            } else {
                $mailData['office_phone'] = '+92 335 3737904';
            }

            // Send the email
            Mail::to($consult->email)->send(new InquiryActiveMail($mailData));
        }


        // Step 2: If hold, insert into inquiry_holds
        if ($status === 'hold') {
            inquiry_holds::updateOrCreate(
                ['consult_id' => $id],
                [
                    'reason' => $req->reason,
                    'revisit_date' => $req->revisit_date,
                ]
            );

            // Fetch consult user
            $consult = consults::findOrFail($id);
            $consult->reason = $req->reason;
            $consult->date = $req->revisit_date;
            $consult->save();

            // Prepare data for email
            if($req->revisit_date == null){
                $mailData = [
                    'name' => $consult->name,
                    'reason' => $req->reason
                ];
            }
            else{
                $mailData = [
                    'name' => $consult->name,
                    'reason' => $req->reason,
                    'revisit_date' => $req->revisit_date,
                ];
            }

            $mailData['office_email'] = 'apply@atracconsultants.com';
            // Location-specific overrides
            if ($consult->office_location == 'islamabad') {
                $mailData['office_phone'] = '+92 326 5209992';
            } elseif($consult->office_location == 'lahore') {
                $mailData['office_phone'] = '+92 328 5209992';
            } else {
                $mailData['office_phone'] = '+92 335 3737904';
            }

            // Send the email
            Mail::to($consult->email)->send(new InquiryHoldMail($mailData));
        }


        // Step 3: If reject, insert into inquiry_rejects (recommended: separate table like inquiry_holds)
        if ($status === 'reject') {
            // Update consult record
            $consult = consults::updateOrCreate(
                ['id' => $id],
                ['reason' => $req->reason]
            );

            // Fetch updated/created consult record
            $consult = consults::find($id);
            $consult->reason = $req->reason;
            $consult->date = null;
            $consult->time = null;
            $consult->save();

            if (inquiry_holds::where('consult_id', $id)->exists()) {
                inquiry_holds::where('consult_id', $id)->delete();
            }


            // Prepare mail data
            $mailData = [
                'name' => $consult->name,
                'reason' => $req->reason,
            ];

            $mailData['office_email'] = 'apply@atracconsultants.com';
            // Add office-specific data
            if ($consult->office_location == 'islamabad') {
                $mailData['office_phone'] = '+92 326 5209992';
            } elseif($consult->office_location == 'lahore') {
                $mailData['office_phone'] = '+92 328 5209992';
            } else {
                $mailData['office_phone'] = '+92 335 3737904';
            }

            // Send mail (assuming you're using Mailable class)
            Mail::to($consult->email)->send(new InquiryRejectMail($mailData));
        }


        return response()->json(['message' => 'Inquiry status updated!']);
    }

    public function deleteInquiry(Request $req)
    {
        try {
            $id = decrypt($req->encrypted_id);
            $inquiry = consults::findOrFail($id);
            $inquiry->delete();

            return response()->json(['message' => 'Deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid or tampered ID.'], 400);
        }
    }


    public function consultDetails($id)
    {
        $consultId = $id;
        $consult = DB::table('consults')
            ->join('countries', 'consults.country_id', '=', 'countries.id')
            ->select('consults.id', 'consults.name', 'consults.phone', 'consults.email', 'countries.name as country_name', 'consults.qualification', 'consults.field', 'consults.message', 'consults.status', 'consults.percentage',  'consults.created_at', 'consults.meeting_datetime')
            ->where('consults.id', $consultId)->first();

        // return $consult;
        return view('admin.details.details', ['consult' => $consult]);
    }

    public function countryIndex()
    {
        $countries = country::orderBy('status', 'asc')->get();
        return view('admin.country.countries', compact('countries'));
    }
    public function countryStore(Request $req)
    {
        $countries = new country();
        $countries->name = $req->country_name;
        if ($req->hasFile('country_image')) {
            $image = $req->file('country_image');
            $imagename = time() . $image->getClientOriginalName();
            $image->move(public_path('images/country'), $imagename);
            $countries->country_image = $imagename; // Save image name in the database
        }
        $countries->save();
        return redirect()->route('admin-country-index')->with('success', 'Country Added');
    }
    public function countryActive($id)
    {
        $country = country::find($id);
        if ($country) {
            $country->status = 'active';
            $country->save(); // Save the changes
            return redirect()->back()->with('active', 'Country Activated');
        } else {
            return redirect()->back()->with('error', 'Country not found');
        }
    }
    public function countryInactive($id)
    {
        $country = country::find($id);
        if ($country) {
            $country->status = 'inactive';
            $country->save(); // Save the changes
            return redirect()->back()->with('inactive', 'Country Inactivated');
        } else {
            return redirect()->back()->with('error', 'Country not found');
        }
    }

    public function countryDetailsIndex()
    {
        $countries = country::all();
        $details = countrydetails::all();

        return view('admin.details.index', compact('countries', 'details'));
    }
    public function countryDetailsStore(Request $req)
    {
        $details = new countrydetails();
        $details->country_id = $req->country;
    }

    public function getCountries($id)
    {
        $country = country::select(['id', 'name', 'country_image'])->find($id);
        return response()->json($country);
    }

    public function activePrograms(){
        $programs = program_level::all();
        return view('admin.programs.index', compact('programs'));
    }

    public function countryProgramLevelsPage() {
        $countries = Country::where('status', 'active')->get(); // collection
        $allProgramLevels = program_level::all();

        return view('admin.program_levels.index', compact('countries', 'allProgramLevels'));

    }

    public function countryProgramLevelsUpdate(Request $request)
    {
        $country_id = $request->country_id;
        $program_id = $request->program_id;
        $checked = filter_var($request->checked, FILTER_VALIDATE_BOOLEAN);

        if ($checked) {
            // Insert if not exists
            DB::table('country_programs')->updateOrInsert([
                'country_id' => $country_id,
                'program_level_id' => $program_id,
            ]);
        } else {
            // Remove if unchecked
            DB::table('country_programs')
                ->where('country_id', $country_id)
                ->where('program_level_id', $program_id)
                ->delete();
        }

        return response()->json(['success' => true]);
    }

    public function countryCitiesEdit(){
        return view('admin.country.cities');
    }

}
