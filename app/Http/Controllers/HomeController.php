<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use App\Models\Leads;
use App\Models\Newsletter;
use App\Models\AppraiseRequest;
use App\Models\ListingRequest;
use App\Models\Career;
use App\Models\Contact;
use App\Models\PropertyInquiry;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:dashboard-permission', ['only' => ['index']]);
        $this->middleware('permission:requests', ['only' => ['FrontLeadsRequests', 'FrontBrochureLeads', 'Career', 'CareerShow', 'Contact', 'ContactShow']]);
        $this->middleware('permission:newsletter-subscriber', ['only' => ['NewsletterSubscribers']]);
    }

    public function FrontLeadsRequests(Request $request)
    {
        if ($request->has('type') && $request->type == 'appraise') {
            $data = AppraiseRequest::latest()->paginate(20);
            return view('management.property-request.index', compact('data'));
        }
        if ($request->has('type') && $request->type == 'listing') {
            $data = ListingRequest::latest()->paginate(20);
            return view('management.property-request.index', compact('data'));
        }
        return abort(404);
    }

    public function FrontBrochureLeads(Request $request)
    {
        $data = PropertyInquiry::with(['property', 'assignedAgent'])->latest()->paginate(20);
        return view('management.brochure-leads', compact('data'));
    }

    public function Career(Request $request)
    {
        $data = Career::latest()->paginate(20);
        return view('management.career.index', compact('data'));
    }

    public function CareerShow($id)
    {
        $data = Career::findOrFail($id);
        return view('management.career.show', compact('data'));
    }

    public function Contact(Request $request)
    {
        $data = Contact::latest()->paginate(20);
        return view('management.contact.index', compact('data'));
    }

    public function ContactShow($id)
    {
        $data = Contact::findOrFail($id);
        return view('management.contact.show', compact('data'));
    }

    public function index()
    {
        $metrics = [
            'total_properties' => Property::count(),
            'active_properties' => Property::where('status', 1)->count(),
            'pending_properties' => Property::where('status', '!=', 1)->count(),
            'sale_properties' => Property::where('type', 'sale')->count(),
            'rent_properties' => Property::where('type', 'rent')->count(),
            'total_agents' => User::agents()->count(),
            'total_leads' => Leads::count(),
            'total_inquiries' => PropertyInquiry::count(),
            'total_subscribers' => Newsletter::count(),
        ];

        $recent_leads = Leads::with(['property', 'assignedAgent'])->latest()->take(8)->get();
        $recent_inquiries = PropertyInquiry::with(['property'])->latest()->take(8)->get();
        $recent_properties = Property::with(['user'])->latest()->take(6)->get();

        return view('management.home.index', compact('metrics', 'recent_leads', 'recent_inquiries', 'recent_properties'));
    }

    public function NewsletterSubscribers()
    {
        $data = Newsletter::latest()->paginate(20);
        return view('management.newsletter.index', compact('data'));
    }
}
