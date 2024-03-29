<?php

namespace App\Http\Controllers;


use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class ListingController extends Controller
{
    // Show all listings
    public function index() {

       return view('listings.index', [
	'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)                                              
	
	]);
    }

    //Show single listing
    public function show(Listing $listing) {
        return view('listings.show' , [
	'listing' => $listing
	]);
		
		
    }
	
	
	//Show create form
	 public function create() {
        return view('listings.create');
	 }
	 
	 // Store Listing Data
   public function store(Request $request) {
    $formFields = $request->validate([
        'title' => 'required',
        'company' => ['required', Rule::unique('listings', 'company')],
        'location' => 'required',
        'website' => 'required',
        'email' => ['required', 'email'],
        'tags' => 'required',
        'description' => 'required'
    ]);

    if ($request->input('logo_input_option') === 'camera') {
        $imageData = $request->input('logo_base64');
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $fileNameToStore = 'logos/' . time() . '.png';
        Storage::disk('public')->put($fileNameToStore, base64_decode($imageData));
        $formFields['logo'] = $fileNameToStore;
    } else if ($request->hasFile('logo')) {
        $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }

    $formFields['user_id'] = auth()->id();

    Listing::create($formFields);

    return redirect('/')->with('message', 'Job created successfully!');
}


    // Show Edit Form
    public function edit(Listing $listing) {
        return view('listings.edit', ['listing' => $listing]);
    }
	
	// Update Listing Data
    public function update(Request $request, Listing $listing) {
		
		
       // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully!');
    }
	
	 // Delete Listing
    public function destroy(Listing $listing) {
		
     //   Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        if($listing->logo && Storage::disk('public')->exists($listing->logo)) {
            Storage::disk('public')->delete($listing->logo);
        }
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully');
    }
	
	// Manage Listings
    public function manage() {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
	
	
	// Manage Listings
    public function map() { 
        return view('listings.map', [
	'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)                                              
	
	]);
    }


		
}


