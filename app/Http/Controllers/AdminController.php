<?php

namespace App\Http\Controllers;

use App\Models\hero;
use App\Models\fields;
use App\Models\country;
use App\Mail\RejectMail;
use App\Models\consults;
use App\Models\services;
use App\Mail\ApproveMail;
use App\Mail\RequestMail;
use Illuminate\Http\Request;
use App\Models\countrydetails;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function detailsShow($name)
    {

        // return $name;
        $details = DB::table('countrydetails')
            ->join('countries', 'countrydetails.country_id', '=', 'countries.id')
            ->where('countries.iso2', $name)
            ->select('countrydetails.*', 'countries.name', 'countries.id as country_id')
            ->first();
        if (!$details) {
            return view('coming_soon');
        }
        $fields = fields::orderBy('field', 'asc')->get();


        $countryName = $details->name;

        $country_id = $details->country_id;

        $universities = DB::table('universities')->where('country_id', '=', $country_id)->get();

        return view('web.details', compact('details', 'name', 'countryName', 'fields', 'universities'));
        // return $universities;

    }

    public function uniDetails($name)
    {
        $university = DB::table('universities')
            ->where('slug', '=', $name)
            ->first();
        if (!$university) {
            return view('coming_soon');
        }
        $uni_id = $university->id;
        $uniName = $university->university_name;

        $asscdepartments = DB::table('unideptprogcourses')
            ->join('departments', 'departments.id', '=', 'unideptprogcourses.depart_id')
            ->join('courses', 'courses.id', '=', 'unideptprogcourses.course_id')
            ->join('universities', 'universities.id', '=', 'unideptprogcourses.university_id')
            ->where('unideptprogcourses.university_id', $uni_id)
            ->where('unideptprogcourses.program_level', 1)
            ->select(
                'unideptprogcourses.*',
                'departments.department_name as department_name',
                'courses.course_title as course_title',
                'universities.university_name as university_name',
                'universities.slug',
                'universities.country_id'
            )
            ->get()
            ->groupBy('department_name'); // <-- GROUPING here

        $bachelordepartments = DB::table('unideptprogcourses')
            ->join('departments', 'departments.id', '=', 'unideptprogcourses.depart_id')
            ->join('courses', 'courses.id', '=', 'unideptprogcourses.course_id')
            ->join('universities', 'universities.id', '=', 'unideptprogcourses.university_id')
            ->where('unideptprogcourses.university_id', $uni_id)
            ->where('unideptprogcourses.program_level', 2)
            ->select(
                'unideptprogcourses.*',
                'departments.department_name as department_name',
                'courses.course_title as course_title',
                'universities.university_name as university_name',
                'universities.slug',
                'universities.country_id'
            )
            ->get()
            ->groupBy('department_name');
        $mastersdepartments = DB::table('unideptprogcourses')
            ->join('departments', 'departments.id', '=', 'unideptprogcourses.depart_id')
            ->join('courses', 'courses.id', '=', 'unideptprogcourses.course_id')
            ->join('universities', 'universities.id', '=', 'unideptprogcourses.university_id')
            ->where('unideptprogcourses.university_id', $uni_id)
            ->where('unideptprogcourses.program_level', 3)
            ->select(
                'unideptprogcourses.*',
                'departments.department_name as department_name',
                'courses.course_title as course_title',
                'universities.university_name as university_name',
                'universities.slug',
                'universities.country_id'
            )
            ->get()
            ->groupBy('department_name');
        $phddepartments = DB::table('unideptprogcourses')
            ->join('departments', 'departments.id', '=', 'unideptprogcourses.depart_id')
            ->join('courses', 'courses.id', '=', 'unideptprogcourses.course_id')
            ->join('universities', 'universities.id', '=', 'unideptprogcourses.university_id')
            ->where('unideptprogcourses.university_id', $uni_id)
            ->where('unideptprogcourses.program_level', 4)
            ->select(
                'unideptprogcourses.*',
                'departments.department_name as department_name',
                'courses.course_title as course_title',
                'universities.university_name as university_name',
                'universities.slug',
                'universities.country_id'
            )
            ->get()
            ->groupBy('department_name');


        return view('web.uni_details', compact('uniName', 'university','asscdepartments','bachelordepartments','mastersdepartments','phddepartments'));
    }


    public function consultAllIndex()
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                $consults = DB::table('consults')
                    ->join('countries', 'consults.country_id', '=', 'countries.id')
                    ->select('consults.id', 'consults.name', 'consults.phone', 'consults.email', 'countries.name as country_name', 'consults.qualification', 'consults.field', 'consults.message', 'consults.meeting_datetime')
                    ->get();
                return view('admin.consult.consult', compact('consults'));
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function consultPendingIndex()
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                $consults = DB::table('consults')
                    ->join('countries', 'consults.country_id', '=', 'countries.id')
                    ->select('consults.id', 'consults.name', 'consults.phone', 'consults.email', 'countries.name as country_name', 'consults.qualification', 'consults.field', 'consults.message', 'consults.status')
                    ->where('consults.status', '=', 'pending')
                    ->get();
                return view('admin.consult.pending', compact('consults'));
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function consultApprovedIndex()
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                // Data fetch on page
                $consults = DB::table('consults')
                    ->join('countries', 'consults.country_id', '=', 'countries.id')
                    ->select('consults.id', 'consults.name', 'consults.phone', 'consults.email', 'countries.name as country_name', 'consults.qualification', 'consults.field', 'consults.message', 'consults.status')
                    ->where('consults.status', '=', 'approved')
                    ->get();

                //email sending for rejection

                return view('admin.consult.approved', compact('consults'));
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function consultRejectedIndex()
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                $consults = DB::table('consults')
                    ->join('countries', 'consults.country_id', '=', 'countries.id')
                    ->select('consults.id', 'consults.name', 'consults.phone', 'consults.email', 'countries.name as country_name', 'consults.qualification', 'consults.field', 'consults.message', 'consults.status')
                    ->where('consults.status', '=', 'rejected')
                    ->get();
                return view('admin.consult.rejected', compact('consults'));
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function consultRequest(Request $req)
    {
        // return view('web.index');

        $consult = new consults();
        $consult->name = $req->name;
        $consult->phone = $req->phone;
        $consult->email = $req->email;
        $consult->message = $req->message;
        $consult->qualification = $req->qualification;
        $consult->country_id = $req->country;
        $consult->percentage = $req->percentage;
        $consult->field = $req->field;

        $consultRequest = [
            'name' => $req->name,
            'email' => $req->email,
            'message' => $req->message,
            'qualification' => $req->qualification,
            'country_id' => $req->country,
            'percentage' => $req->percentage,
            'field' => $req->field
        ];
        Mail::to($req->email)->send(new RequestMail($consultRequest));

        $consult->save();
        return redirect()->back()->with('success', "Your query has been passed to us. We'll get back to you shortly");
    }

    public function consultDetails($id)
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                $consultId = $id;
                $consult = DB::table('consults')
                    ->join('countries', 'consults.country_id', '=', 'countries.id')
                    ->select('consults.id', 'consults.name', 'consults.phone', 'consults.email', 'countries.name as country_name', 'consults.qualification', 'consults.field', 'consults.message', 'consults.status', 'consults.percentage',  'consults.created_at', 'consults.meeting_datetime')
                    ->where('consults.id', $consultId)->first();

                // return $consult;
                return view('admin.details.details', ['consult' => $consult]);
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }

        // return $consultId;
    }
    public function consultSchedule($id, Request $req)
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                $consultId = $id;

                $meeting_datetime = $req->meeting_datetime;
                DB::table('consults')->where('id', $consultId)->update([
                    'meeting_datetime' => $meeting_datetime,
                    'status' => 'approved'
                ]);

                $consult = DB::table('consults')->where('id', $consultId)->first(); // Fetch the updated record

                Mail::to($consult->email)->send(new ApproveMail($consult));

                return redirect()->route('approved-consults');
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }

        // return $consultId;
    }

    public function consultApprove($id)
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                // Retrieve the consult using Eloquent and update its status
                $consult = consults::find($id);

                if ($consult) {
                    $consult->status = 'approved';
                    $consult->save(); // Save the changes

                    $consultApprove = [
                        'name' => $consult->name,
                        'email' => $consult->email
                    ];
                    Mail::to($consult->email)->send(new ApproveMail($consultApprove));

                    return redirect()->back()->with('success', 'Appointment Approved');
                } else {
                    return redirect()->back()->with('error', 'Consult not found');
                }
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }

        // return $consultId;
    }


    public function consultReject($id)
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                // Retrieve the consult using Eloquent and update its status
                $consult = consults::find($id);

                if ($consult) {
                    $consult->status = 'rejected';
                    $consult->save(); // Save the changes
                    $consultReject = [
                        'name' => $consult->name,
                        'email' => $consult->email
                    ];
                    Mail::to($consult->email)->send(new RejectMail($consultReject));

                    return redirect()->back()->with('reject', 'Appointment Rejected');
                } else {
                    return redirect()->back()->with('error', 'Consult not found');
                }
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }

        // return $consultId;
    }


    public function index()
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                return view('admin.index');
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function countryIndex()
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                $countries = country::orderBy('status', 'asc')->get();
                return view('admin.country.countries', compact('countries'));
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function countryStore(Request $req)
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                $countries = new country();
                $countries->name = $req->country_name;
                if ($req->hasFile('country_image')) {
                    $image = $req->file('country_image');
                    $imagename = time() . $image->getClientOriginalName();
                    $image->move(public_path('images/country'), $imagename);
                    $countries->country_image = $imagename; // Save image name in the database
                }
                $countries->save();
                return redirect()->route('admin-countries')->with('success', 'Country Added');
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function countryUpdate(Request $req)
    {
        $id = $req->id;

        $country = country::find($id);
        $country->name = $req->name_;
        if ($req->hasFile('image_')) {
            $image = $req->file('image_');
            $imagename = time() . $image->getClientOriginalName();
            $image->move(public_path('images/country'), $imagename);
            $country->country_image = $imagename; // Save image name in the database
        }
        $country->save();
        return redirect()->route('admin-countries')->with('update', 'Country Data Updated');
    }
    public function countryActive($id)
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                $country = country::find($id);
                if ($country) {
                    $country->status = 'active';
                    $country->save(); // Save the changes
                    return redirect()->back()->with('active', 'Country Activated');
                } else {
                    return redirect()->back()->with('error', 'Country not found');
                }
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function countryInactive($id)
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                $country = country::find($id);
                if ($country) {
                    $country->status = 'inactive';
                    $country->save(); // Save the changes
                    return redirect()->back()->with('inactive', 'Country Inactivated');
                } else {
                    return redirect()->back()->with('error', 'Country not found');
                }
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function serviceIndex()
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                $services = services::all();
                return view('admin.services.index', compact('services'));
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function serviceStore(Request $req)
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                $service = new services();
                $service->service_icon = $req->service_icon;
                $service->service_heading = $req->service_heading;
                $service->service_details = $req->service_details;

                $service->save();
                return redirect()->route('admin-services')->with('success', 'Service Added');
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function serviceActive($id)
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                $service = services::find($id);
                if ($service) {
                    $service->status = 'active';
                    $service->save(); // Save the changes
                    return redirect()->back()->with('active', 'Service Activated');
                } else {
                    return redirect()->back()->with('error', 'Service not found');
                }
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function serviceInactive($id)
    {
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                $service = services::find($id);
                if ($service) {
                    $service->status = 'inactive';
                    $service->save(); // Save the changes
                    return redirect()->back()->with('inactive', 'Service Inactivated');
                } else {
                    return redirect()->back()->with('error', 'Service not found');
                }
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
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
        if (Auth::check()) {
            if (Auth::User()->role == 1) {
                $details = new countrydetails();
                $details->country_id = $req->country;
            } else {
                abort(403, "Why don't you go back and try again when you're feeling more heroic?");
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function getCountries($id)
    {
        $country = country::select(['id', 'name', 'country_image'])->find($id);
        return response()->json($country);
    }


    public function heroIndex()
    {
        return view('admin.hero.index');
    }

    public function heroAdd(Request $req)
    {
        $hero = new hero();
        $hero->heading = $req->heading;
        $hero->desc = $req->desc;


        $image = $req->heroimage;
        $imagename = time() . '.' . $image->getClientOriginalName();
        $req->heroimage->move('heroImages', $imagename);
        $hero->image = $imagename;

        $hero->save();
        return redirect()->back();
    }
}
