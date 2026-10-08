<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Career;
use App\Models\AppraiseRequest;
use App\Models\ListingRequest;
use App\Models\Leads;
use Illuminate\Http\Request;

class FrontPagesController extends Controller
{
    public function Sell()
    {
        return view('frontend.pages.sell');
    }

    public function SellPost(Request $request)
    {
        // Anti-spam honeypot
        if ($request->filled('hp_company_field')) {
            return redirect()->route('thankYou');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'type' => 'nullable|string',
        ]);

        $data = $request->except(['hp_company_field']);
        ListingRequest::create($data);

        // Record in CRM
        Leads::create([
            'firstname' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'type' => $request->type ?? 'sale',
            'source' => 'Sell Your Property Form',
            'status' => 'new',
        ]);

        return redirect()->route('thankYou')->with('success', 'Your listing request has been submitted successfully.');
    }

    public function Appraise()
    {
        return view('frontend.pages.appraise');
    }

    public function AppraisePost(Request $request)
    {
        // Anti-spam honeypot
        if ($request->filled('hp_check_field')) {
            return redirect()->route('thankYou');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'nullable|string',
        ]);

        $data = $request->except(['hp_check_field']);
        AppraiseRequest::create($data);

        // Record in CRM
        Leads::create([
            'firstname' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'source' => 'Property Appraisal Request',
            'status' => 'new',
        ]);

        return redirect()->route('thankYou')->with('success', 'Your appraisal request has been submitted successfully.');
    }

    public function Contact()
    {
        return view('frontend.pages.contact');
    }

    public function ContactPost(Request $request)
    {
        // Anti-spam honeypot
        if ($request->filled('hp_email_confirm')) {
            return redirect()->route('thankYou');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'subject' => 'nullable|string',
            'message' => 'nullable|string',
        ]);

        $data = $request->except(['hp_email_confirm']);
        Contact::create($data);

        // Record in CRM
        Leads::create([
            'firstname' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'source' => 'Website Contact Form',
            'status' => 'new',
        ]);

        return redirect()->route('thankYou');
    }

    public function Career()
    {
        return view('frontend.pages.career');
    }

    public function CareerPost(Request $request)
    {
        // Anti-spam honeypot
        if ($request->filled('hp_career_bot')) {
            return redirect()->route('thankYou');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $main_file = null;
        if ($request->hasFile('resume')) {
            $ext = $request->file('resume')->getClientOriginalExtension();
            $main_file = 'resume_' . time() . '_' . rand(100, 999) . '.' . $ext;
            $request->file('resume')->move(public_path('images/media/resume'), $main_file);
        }

        $data = $request->except(['resume', 'hp_career_bot']);
        $data['resume'] = $main_file;
        Career::create($data);

        return redirect()->route('thankYou');
    }

    public function thankYou()
    {
        return view('frontend.pages.thank-you');
    }
}
