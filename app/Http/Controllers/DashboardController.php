<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use App\Repairment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = Repairment::stats();

        return view('dashboard', compact('stats'));
    }

    public function datatable()
    {
        $status = request('status');

        $models = Repairment::select(
            'repairments.id',
            'repairments.report_number',
            'repairments.name',
            'repairments.identity_number',
            'repairments.phone',
            'work_units.name AS unit',
            'repairments.status'
        )
            ->join('work_units', 'repairments.work_unit_id', '=', 'work_units.id');

        // only select reports which created today or has WAITING or ON_PROGRESS status
        if ($status) {
            $status = strtoupper($status);

            $models = $models->where('status', $status);

            if (!in_array($status, ['WAITING', 'ON_PROGRESS'])) {
                $models = $models->where(
                    DB::raw('DATE(repairments.created_at) = CURDATE()')
                );
            }
        } else {
            $models = $models->whereIn('status', ['WAITING', 'ON_PROGRESS'])
                             ->orWhere(
                                 DB::raw('DATE(repairments.created_at) = CURDATE()')
                             );
        }

        $models = $models->orderBy('repairments.created_at');

        return DataTables::of($models->get())
            ->addColumn('action', 'datatable.dashboard')
            ->toJson();
    }

    public function showStats()
    {
        $stats = Repairment::stats();

        return response()->json([
            'status'  => 'success',
            'message' => 'Fetch data success',
            'data'    => compact('stats'),
        ]);
    }
}
