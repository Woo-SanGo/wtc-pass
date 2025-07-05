<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShelterApplication;
use Carbon\Carbon;

class DashboardController extends Controller
{

public function index(Request $request)
{
    $filter = $request->input('filter', 'day');

    switch ($filter) {
        case 'week':
            $from = Carbon::now()->startOfWeek();
            $to = Carbon::now()->endOfWeek();
            break;
        case 'month':
            $from = Carbon::now()->startOfMonth();
            $to = Carbon::now()->endOfMonth();
            break;
        default:
            $from = Carbon::now()->startOfDay();
            $to = Carbon::now()->endOfDay();
    }

    // Filter using updated_at instead of created_at
    $filtered = ShelterApplication::whereBetween('updated_at', [$from, $to])->get();

    $total = $filtered->count();
    $approved = $filtered->where('status', 'approved')->count();
    $rejected = $filtered->where('status', 'rejected')->count();
    $pending = $filtered->where('status', 'pending')->count();

    $percentages = [
        'Approved' => $total ? round(($approved / $total) * 100, 2) : 0,
        'Rejected' => $total ? round(($rejected / $total) * 100, 2) : 0,
        'Pending'  => $total ? round(($pending / $total) * 100, 2) : 0,
    ];

    return view('admin.dashboard.index', compact(
        'percentages',
        'filter',
        'total',
        'pending',
        'rejected'
    ));
}

}