<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdoptionApplication;
use App\Models\ShelterApplication;  // Add this

class AdoptionController extends Controller
{
    // Show list of all adoption applications
    public function index()
    {
        $adoptions = AdoptionApplication::all();

        // Load shelter applications too (optional: paginate or all)
        $shelterApplications = ShelterApplication::paginate(10);

        return view('admin.adoptions.index', compact('adoptions', 'shelterApplications'));
    }

    // Show edit form for adoption application
    public function edit($id)
    {
        $adoption = AdoptionApplication::findOrFail($id);
        return view('admin.adoptions.edit', compact('adoption'));
    }

    // Handle update of adoption application status
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected',
        ]);

        $adoption = AdoptionApplication::findOrFail($id);
        $adoption->status = $request->status;
        $adoption->save();

        return redirect()->route('admin.adoptions.index')->with('success', 'Adoption status updated.');
    }

    // Delete adoption application
    public function destroy($id)
    {
        $adoption = AdoptionApplication::findOrFail($id);
        $adoption->delete();

        return redirect()->route('admin.adoptions.index')->with('success', 'Adoption deleted.');
    }

    /**
     * Update shelter application status
     */
    public function updateShelterStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected', // use lowercase or your DB values
        ]);

        $shelterApplication = ShelterApplication::findOrFail($id);
        $shelterApplication->status = $request->input('status');
        $shelterApplication->save();

        return redirect()->back()->with('success', 'Shelter application status updated!');
    }
}
