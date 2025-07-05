<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShelterApplication;

class ApplicationController extends Controller
{
    // ✅ Show Shelter Application Form
    public function showShelterForm()
    {
        return view('applications.shelter-form');
    }

    // ✅ Handle Shelter Form Submission
    public function submitShelter(Request $request)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'required|string|max:255',
            'message' => 'nullable|string',
            'proof_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('proof_document')->store('shelter_documents', 'public');

        ShelterApplication::create([
            'organization_name' => $request->organization_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'message' => $request->message,
            'proof_document' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('applications.shelter-form')->with('success', 'Application submitted successfully!');
    }

    // ✅ Show Adoption Application Form
    public function showAdoptionForm()
    {
        return view('applications.adoption-form');
    }

    // ✅ Handle Adoption Form Submission
    public function submitAdoption(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'pet_name' => 'required|string|max:255',
            'reason' => 'required|string',
        ]);

        // Here you can add logic to store in DB if you have a model for it
        return redirect()->route('applications.adoption-form')->with('success', 'Adoption application submitted!');
    }
}
