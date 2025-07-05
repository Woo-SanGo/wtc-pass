<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pet;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;

class PetController extends Controller
{
    public function create()
{
    if (Auth::check()) {
        if (Auth::user()->role === 'shelter') {
            return view('pets.create');
        } else {
            return view('pets.apply-shelter');
        }
    }
    return redirect()->route('login')->with('error', 'Please log in first.');
}

    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->role !== 'shelter') {
            return redirect()->back()->with('error', 'Only shelters can add pets.');
        }

        $validated = $request->validate([
            'shelter_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'age' => 'nullable|integer|min:0',
            'behavior' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }

        $validated['shelter_id'] = Auth::id();
        Pet::create($validated);

        return redirect()->route('adopt.index')->with('success', 'Pet added successfully!');
    }

  public function index(Request $request)
{
    $query = Pet::query();

    if ($request->has('search') && $request->search !== null) {
        $query->where('name', 'LIKE', '%' . $request->search . '%');
    }

    $pets = $query->latest()->get();

    return view('adopt.index', compact('pets'));
}


    public function show($id)
    {
        $pet = Pet::findOrFail($id);
        return view('adopt.show', compact('pet'));
    }
}