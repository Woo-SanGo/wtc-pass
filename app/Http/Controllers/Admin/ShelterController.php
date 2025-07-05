<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShelterApplication;
use App\Exports\ShelterApplicationsExport;
use Maatwebsite\Excel\Facades\Excel;

class ShelterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->role === 'admin') {
                return $next($request);
            }
            abort(403, 'Unauthorized - Admin access required');
        });
    }

        public function export()
    {
        try {
            // Test if Excel facade is working
            if (!class_exists('Maatwebsite\Excel\Facades\Excel')) {
                throw new \Exception('Excel facade not found');
            }
            
            // Test if export class exists
            if (!class_exists('App\Exports\ShelterApplicationsExport')) {
                throw new \Exception('ShelterApplicationsExport class not found');
            }
            
            $export = new ShelterApplicationsExport();
            $data = $export->collection();
            
            if ($data->isEmpty()) {
                return redirect()->back()->with('error', 'No data to export');
            }
            
            return Excel::download($export, 'shelter.xlsx');
        } catch (\Exception $e) {
            \Log::error('Export error: ' . $e->getMessage());
            \Log::error('Export trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }
    
    public function index(Request $request)
    {
        $status = $request->input('status');
        $query = ShelterApplication::query();

        if (in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $shelters = $query->orderBy('id', 'asc')->get();

        return view('admin.shelters.index', compact('shelters'));
    }

    public function show($id)
    {
        return view('admin.shelters.show', [
            'shelter' => ShelterApplication::findOrFail($id),
        ]);
    }

    public function edit($id)
    {
        return view('admin.shelters.edit', [
            'shelter' => ShelterApplication::findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,approved,rejected',
        ]);

        $shelter = ShelterApplication::findOrFail($id);
        $shelter->status = $request->status;
        $shelter->save();

        return redirect()->route('admin.shelters.index')->with('success', 'Shelter application updated successfully!');
    }

    public function destroy($id)
    {
        ShelterApplication::findOrFail($id)->delete();

        return redirect()->route('admin.shelters.index')->with('success', 'Shelter application deleted successfully!');
    }
}
