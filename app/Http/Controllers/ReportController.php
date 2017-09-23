<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use DataTables;
use App\Repairment;

class ReportController extends Controller
{
    public function index()
    {
        return view('report');
    }

    public function datatable()
    {
        $status = request('status');
        $startDate = request('startDate'); // dd/mm/yyyy
        $endDate = request('endDate'); // dd/mm/yyyy

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

        if ($status) {
            $status = strtoupper($status);
            $models = $models->where('repairments.status', $status);
        }

        if ($startDate && $endDate) {
            // turn dd/mm/yyyy to yyyy-mm-dd
            $startDateArr = explode('/', $startDate);
            $endDateArr = explode('/', $endDate);

            $startDate = Carbon::createFromDate(
                $startDateArr[2],
                $startDateArr[1],
                $startDateArr[0]
            );

            $endDate = Carbon::createFromDate(
                $endDateArr[2],
                $endDateArr[1],
                $endDateArr[0]
            );
        } else {
            $now = Carbon::now();
            $startDate = $now->startOfMonth()->toDateString();
            $endDate = $now->endOfMonth()->toDateString();
        }

        $models = $models->whereBetween(DB::raw('DATE(repairments.created_at)'), [
            $startDate,
            $endDate,
        ])
            ->orderBy('repairments.created_at')
            ->get();

        return DataTables::of($models)
            ->addColumn('action', 'datatable.report')
            ->toJson();
    }

    public function graph()
    {
        $startDate = request('startDate'); // dd/mm/yyyy
        $endDate = request('endDate'); // dd/mm/yyyy

        $models = Repairment::select(
            DB::raw('COUNT(repairments.id) AS number'),
            'repairments.status'
        );

        if ($startDate && $endDate) {
            // turn dd/mm/yyyy to yyyy-mm-dd
            $startDateArr = explode('/', $startDate);
            $endDateArr = explode('/', $endDate);

            $startDate = Carbon::createFromDate(
                $startDateArr[2],
                $startDateArr[1],
                $startDateArr[0]
            );

            $endDate = Carbon::createFromDate(
                $endDateArr[2],
                $endDateArr[1],
                $endDateArr[0]
            );
        } else {
            $now = Carbon::now();
            $startDate = $now->startOfMonth()->toDateString();
            $endDate = $now->endOfMonth()->toDateString();
        }

        $models = $models->whereBetween(DB::raw('DATE(repairments.created_at)'), [
            $startDate,
            $endDate,
        ])
            ->groupBy('repairments.status')
            ->get();

        // map data from db to chart format data
        $labels = ['Masuk', 'Dikerjakan', 'Selesai', 'Batal'];
        $colors = ['#007bff', '#ffc107', '#28a745', '#dc3545'];
        $numbers = [0, 0, 0, 0];

        foreach ($models as $model) {
            switch ($model->status) {
                case 'WAITING':
                    $numbers[0] = $model->number;
                    break;

                case 'ON_PROGRESS':
                    $numbers[1] = $model->number;
                    break;

                case 'DONE':
                    $numbers[2] = $model->number;
                    break;

                case 'CANCELED':
                    $numbers[3] = $model->number;
                    break;
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Fetch data success',
            'data'    => compact('labels', 'colors', 'numbers'),
        ]);
    }
}
