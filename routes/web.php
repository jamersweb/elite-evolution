<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Elite Evolution Real Estate Web Application Routes
|
*/

// Static Legal Pages
Route::get('terms-and-conditions', function () {
    return view('frontend.pages.terms-and-condition');
});
Route::get('privacy-policy', function () {
    return view('frontend.pages.privacy-policy');
});
Route::get('cookies-policy', function () {
    return view('frontend.pages.privacy-policy');
});
Route::get('thank-you', [App\Http\Controllers\frontend\FrontPagesController::class, 'thankYou'])->name('thankYou');

// Redirection
Route::get('adminpanel', function () {
    return redirect('admin/home');
});

// Public Portal Routes
Route::get('/', [App\Http\Controllers\frontend\FrontHomeController::class, 'index'])->name('welcome');
Route::get('/about-us', [App\Http\Controllers\frontend\FrontHomeController::class, 'About']);
Route::get('/luxury-rentals', [App\Http\Controllers\frontend\FrontHomeController::class, 'LuxuryRentals'])->name('luxury.rentals');
Route::get('/map-view', [App\Http\Controllers\frontend\FrontHomeController::class, 'MapView'])->name('map.view');
Route::get('/view', [App\Http\Controllers\frontend\FrontHomeController::class, 'MapView']);

// Developers
Route::get('developer/{developer}', [App\Http\Controllers\frontend\FrontHomeController::class, 'Developer']);
Route::get('developer/{developer}/{property}', [App\Http\Controllers\frontend\FrontHomeController::class, 'DeveloperProperty']);

// Blogs
Route::get('/blog', [App\Http\Controllers\frontend\FrontHomeController::class, 'post']);
Route::get('/blog/{slug}', [App\Http\Controllers\frontend\FrontHomeController::class, 'SinglePost']);

// Leads & Inquiries
Route::get('/appraise-your-property', [App\Http\Controllers\frontend\FrontPagesController::class, 'Appraise']);
Route::post('/appraise-your-property', [App\Http\Controllers\frontend\FrontPagesController::class, 'AppraisePost']);
Route::get('/sell-your-property', [App\Http\Controllers\frontend\FrontPagesController::class, 'Sell']);
Route::post('/sell-your-property', [App\Http\Controllers\frontend\FrontPagesController::class, 'SellPost']);
Route::get('/career', [App\Http\Controllers\frontend\FrontPagesController::class, 'Career']);
Route::post('/career-submit', [App\Http\Controllers\frontend\FrontPagesController::class, 'CareerPost']);
Route::get('/contact-us', [App\Http\Controllers\frontend\FrontPagesController::class, 'Contact']);
Route::post('/contact-us', [App\Http\Controllers\frontend\FrontPagesController::class, 'ContactPost']);

// Property Listings & Details
Route::get('/listing/{slug}', [App\Http\Controllers\frontend\FrontHomeController::class, 'Listing'])->name('property.listing');
Route::get('/detail/{slug}', [App\Http\Controllers\frontend\FrontHomeController::class, 'PropertyDetail'])->name('property.detail');
Route::post('newsletter', [App\Http\Controllers\frontend\FrontHomeController::class, 'Newsletter']);

// Licensed Agents Directory
Route::get('/agents', [App\Http\Controllers\frontend\FrontHomeController::class, 'AllAgents'])->name('front.agents');
Route::get('/agents/{slug}', [App\Http\Controllers\frontend\FrontHomeController::class, 'AgentsDetail'])->name('front.agent.detail');

// Search & Inquiries
Route::get('location-search', [App\Http\Controllers\Management\PropertyController::class, 'locationSearch']);
Route::get('/country/{slug}', [App\Http\Controllers\Management\PropertyController::class, 'CountrySwitcher']);
Route::post('/inquire-brochure/{id}', [App\Http\Controllers\Management\PropertyController::class, 'InquireBrochure']);
Route::post('/book-viewing/{id}', [App\Http\Controllers\Management\PropertyController::class, 'BookViewing']);

// AI Concierge Assistant API
Route::post('/api/concierge/chat', [App\Http\Controllers\frontend\FrontHomeController::class, 'ConciergeChat'])->name('concierge.chat');

// Authenticated Client & Management Routes
Route::middleware(['auth'])->group(function () {
    // Client Account
    Route::get('/my-account', [App\Http\Controllers\frontend\MyAccountController::class, 'index'])->name('my.account');
    Route::get('/wishlist', [App\Http\Controllers\frontend\MyAccountController::class, 'MyWishlist'])->name('my.wishlist');
    Route::get('/saved-search', [App\Http\Controllers\frontend\MyAccountController::class, 'SavedSearch'])->name('my.saved.search');
    Route::post('/update-password', [App\Http\Controllers\frontend\MyAccountController::class, 'updatePassword'])->name('my.update.password');
    Route::post('post-like', [App\Http\Controllers\frontend\ReactionsController::class, 'LikePost']);
    Route::post('post-dislike', [App\Http\Controllers\frontend\ReactionsController::class, 'DislikePost']);

    // Admin & Agent Dashboard
    Route::get('admin/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('admin/dashboard', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('admin/requests', [App\Http\Controllers\HomeController::class, 'FrontLeadsRequests']);
    Route::get('admin/brochure-leads', [App\Http\Controllers\HomeController::class, 'FrontBrochureLeads']);
    Route::get('admin/subscribers', [App\Http\Controllers\HomeController::class, 'NewsletterSubscribers']);
    Route::get('admin/career', [App\Http\Controllers\HomeController::class, 'Career']);
    Route::get('admin/career/{id}', [App\Http\Controllers\HomeController::class, 'CareerShow']);
    Route::get('admin/contact', [App\Http\Controllers\HomeController::class, 'Contact']);
    Route::get('admin/contact/{id}', [App\Http\Controllers\HomeController::class, 'ContactShow']);

    // Admin Resources
    Route::resource('admin/roles', App\Http\Controllers\RoleController::class);
    Route::resource('admin/permissions', App\Http\Controllers\PermissionsController::class);
    Route::resource('admin/developer', App\Http\Controllers\Management\DeveloperController::class);
    Route::resource('admin/property', App\Http\Controllers\Management\PropertyController::class);
    Route::post('admin/image-delete', [App\Http\Controllers\Management\PropertyController::class, 'imageDelete']);
    Route::resource('admin/lead', App\Http\Controllers\Management\LeadController::class);
    Route::resource('admin/agents', App\Http\Controllers\Management\AgentController::class);
    Route::resource('admin/users', App\Http\Controllers\UserController::class);
    Route::get('admin/myprofile', [App\Http\Controllers\UserController::class, 'Myprofile']);
    Route::post('admin/myprofile', [App\Http\Controllers\UserController::class, 'MyprofilePost']);
    Route::resource('admin/post', App\Http\Controllers\BlogController::class);
});

// Authentication Routes
Auth::routes();

// Fallback Route
Route::fallback(function () {
    return view("404");
});
