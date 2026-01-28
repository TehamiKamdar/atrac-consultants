<?php

namespace App\Http\Controllers;

use App\Models\fields;
use App\Models\country;
use App\Models\consults;
use App\Models\contacts;
use App\Mail\RequestMail;
use App\Models\sim_codes;
use App\Models\university;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\countrydetails;
use Anhskohbo\NoCaptcha\NoCaptcha;
use Illuminate\Support\Facades\DB;
use App\Mail\AdminInquiryAlertMail;
use App\Models\review;
use App\Services\RecaptchaEnterpriseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class HomeController extends Controller
{
    public function index()
    {
        $countries = country::orderBy('name', 'asc')->where('status', 'active')->get();

        // print_r($countries);
        return view('web.index', compact('countries'));
    }

    public function about()
    {
        return view('web.about');
    }

    public function blog()
    {
        return view('web.blog');
    }

    public function showContactForm()
    {
        $sim_codes = sim_codes::all();

        return view('web.contact', compact('sim_codes'));
    }

    public function contact(Request $request)
    {// RateLimiter key: IP-based
        $key = 'contact-form:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return redirect()->back()->with('error', 'You have submitted too many messages today. Please try again tomorrow.');
        }

        RateLimiter::hit($key, 86400); // 24 hours

        $validated = $request->validate([
            'name' => 'required|string|min:2|max:100|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|max:255',
            'phone_prefix' => 'required|string|max:4',
            'phone_number' => 'required|string|min:7|max:9',
            'subject' => 'required|string|min:3|max:150',
            'city' => 'required|string|min:3|max:150',
            'message' => 'required|string|max:1000',
        ]);

        // Merge prefix + number
        $validated['phone'] = $validated['phone_prefix'].$validated['phone_number'];

        // Remove extra fields before saving
        unset($validated['phone_prefix'], $validated['phone_number']);

        $bannedWords = config('bannedwords');

        if (containsBannedWords($validated, $bannedWords)) {
            return redirect()->back()->with('error', 'Your input contains inappropriate content.');
        }

        if (str_contains($validated['subject'], 'atracconsultants.com')) {
            return redirect()->back()->with('success', 'Thanks for contacting us. We\'ll get back to you ASAP.');
        }

        contacts::create($validated);

        return redirect()->back()->with('success', 'Thanks for contacting us. We\'ll get back to you ASAP.');

    }

    public function detailsShow($slug)
    {

        // return $name;
        $details = countrydetails::join('countries', 'countrydetails.country_id', '=', 'countries.id')
            ->where('countries.slug', $slug)
            ->select('countrydetails.*', 'countries.*', 'countries.id as country_id')
            ->first();
        if (! $details) {
            return view('coming_soon');
        }

        $countryName = $details->name;
        $country_id = $details->country_id;

        return view('web.details', compact('details', 'countryName'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'city' => 'required|in:karachi,islamabad,lahore',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);

        $bannedWords = config('bannedwords');

        if (containsBannedWords($validated, $bannedWords)) {
            return redirect()->route('contact')->with('error', 'Your input contains inappropriate content.');
        }

        review::create($validated);

        return redirect()->route('contact')->with('success', 'Thank you for your review!');
    }

    public function consultRequest(Request $req, RecaptchaEnterpriseService $recaptcha)
    {

        if (! $recaptcha->verify(
            $req->g_recaptcha_token,
            'consultation',
            0.5
        )) {
            return back()->with('error', 'Captcha verification failed.');
        }

        $ip = $req->ip();
        $key = 'consult-form:'.$ip;
        $decaySeconds = 24 * 60 * 60 * 30;

        // // 5 requests per 24 hours
        // if (RateLimiter::tooManyAttempts($key, 1)) {
        //     return back()->with('error', 'You have submitted too many requests today. Please try again after a month.');
        // }

        // // Hit the limiter (increment counter, TTL = 24 hours)
        // RateLimiter::hit($key, $decaySeconds);

        // Validation
        $validated = $req->validate([
            'name' => 'required|string|min:2',
            [
                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
                ],
            ],
            [
                'email.regex' => 'Only @gmail.com email addresses are allowed.',
            ],
            'phone' => 'required',
            'qualification' => 'required',
            'country' => 'required',
            'percentage' => 'required',
            'field' => 'required',
            'date' => 'required',
            'prefix' => 'required',
            'office_location' => 'required|in:islamabad,karachi',
            'message' => 'nullable|string|min:5|max:1000'
        ]);

        // Captcha verification
        $captcha = new NoCaptcha(env('RECAPTCHA_SECRET_KEY'), env('RECAPTCHA_SITE_KEY'));
        $success = $captcha->verifyResponse($req->input('g-recaptcha-response'), $ip);

        if (! $success) {
            return back()->with('error', 'Captcha verification failed. Please try again.');
        }

        $phone = $validated['prefix'].$validated['phone'];

        $offices = [
            'islamabad' => ['+92 326 5209992', 'apply@atracconsultatns.com'],
            'karachi' => ['+92 335 3737904', 'apply@atracconsultatns.com'],
            'lahore' => ['+92 328 5209992', 'apply@atracconsultatns.com'],
        ];

        $officeData = $offices[$validated['office_location']];

        $data = [
            'ip' => $ip,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'qualification' => $validated['qualification'],
            'country_id' => $validated['country'],
            'percentage' => $validated['percentage'],
            'field' => $validated['field'],
            'date' => $validated['date'],
            'phone' => $phone,
            'office_location' => $validated['office_location'],
            'office_phone' => $officeData[0],
            'office_email' => $officeData[1],
        ];


        try {

            $bannedWords = config('bannedwords');
            $fieldsToCheck = Arr::only($validated, ['name','email','phone','percentage','message', 'qualification']);
            if (containsBannedWords($fieldsToCheck, $bannedWords)) {
                return redirect()->back()->with('error', 'Your input contains inappropriate content.');
            }

            // Save to DB
            consults::create($data);
            Mail::to($validated['email'])->send(new RequestMail($data));
            Mail::to(config('mail.from.address'))->send(new AdminInquiryAlertMail($data));
            return back()->with('success', "Your query has been passed to us. We'll get back to you shortly");

        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function getUniversities($slug)
    {

        $country = country::where('slug', '=', $slug)->select('id', 'name')->first();
        $countryName = $country->name;
        $universities = university::where('universities.country_id', '=', $country->id)
            ->join('states', 'states.id', '=', 'universities.state_id')
            ->join('cities', 'cities.id', '=', 'universities.city_id')
            ->join('countries', 'countries.id', '=', 'universities.country_id')
            ->select('cities.name as cityName', 'states.name as stateName', 'countries.slug as countryslug', 'universities.*')
            ->get();

        // return $universities;
        return view('web.uni_list', compact('universities', 'countryName'));
    }

    public function uniDetails($countryslug, $slug)
    {
        $countryId = country::where('slug', '=', $countryslug)->value('id');

        $university = university::with(['programs.departments.courses', 'programs.level'])
            ->where('slug', $slug)
            ->where('country_id', $countryId)
            ->first();

        // Agar university hi nahi mili toh direct return karo
        if (! $university) {
            return view('coming_soon');
        }

        // Safe queries for state & city
        $state = DB::table('states')
            ->where('id', $university->state_id)
            ->value('name'); // direct string return karega

        $city = DB::table('cities')
            ->where('id', $university->city_id)
            ->value('name');
        // return $city;

        $description = $university->description;
        $meta_title = $university->meta_title;
        $meta_description = $university->meta_description;

        $programsByLevel = $university->programs->groupBy(function ($program) {
            return strtolower(str_replace(' ', '_', $program->level->name)); // e.g. "Associate Degree" -> "associate_degree"
        });

        return view('web.uni_details', compact(
            'university',
            'programsByLevel',
            'description',
            'meta_title',
            'meta_description',
            'state',
            'city'
        ));
    }

    public function checkEmail(Request $request)
    {
        $emailExists = consults::where('email', $request->email)->exists();

        return response()->json(['exists' => $emailExists]);
    }
}
