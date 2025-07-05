<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShelterApplication;

class ShelterApplicationController extends Controller
{
    
        public function export()
    {
        return Excel::download(new ShelterApplicationsExport, 'shelter.xlsx');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_name' => 'required|string|max:255',
            'email' => 'required|email|unique:shelter_applications,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string',
            'proof_document' => 'nullable|file|mimes:pdf,jpg,png',
        ]);

        if ($request->hasFile('proof_document')) {
            $path = $request->file('proof_document')->store('proof_documents', 'public');
            $validated['proof_document'] = $path;
        }

        ShelterApplication::create($validated);

        return redirect()->route('applications.shelter-form')->with('success', 'Application submitted successfully!');
    }
}
