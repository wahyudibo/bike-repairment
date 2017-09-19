<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Repairment;

class RepairmentController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required',
            'phone'  => 'required',
            'remark' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation error',
                'data'    => $validator->errors()->all(),
            ]);
        }

        $name = $request->input('name');
        $phone = $request->input('phone');
        $firstName =  strtoupper(explode(' ', $name)[0]);
        $sixDigitFromPhone = substr($phone, -6);
        $reportNumber = "{$firstName}-{$sixDigitFromPhone}";

        try {
            $repairment = new Repairment;
            $repairment->report_number   = $reportNumber;
            $repairment->name            = $request->input('name');
            $repairment->identity_number = $request->input('identityNumber');
            $repairment->phone           = $request->input('phone');
            $repairment->work_unit_id    = $request->input('workUnit');
            $repairment->remark          = $request->input('remark');
            $repairment->bike_type_id    = $request->input('bikeType');
            $repairment->latitude        = $request->input('latitude');
            $repairment->longitude       = $request->input('longitude');
            $repairment->status          = 'WAITING';
            $repairment->save();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }

        $waitingReports = Repairment::whereIn('status', [
            'WAITING',
            'ON_PROGRESS'
        ])
            ->count();

        return response()->json([
            'status'  => 'success',
            'message' => 'Repairment report is sucessfully saved',
            'data'    => [
                'reportNumber'   => $repairment->report_number,
                'waitingReports' => $waitingReports,
            ]
        ]);
    }

    public function showMap(Request $request)
    {
        $googleMapApiKey = env('GOOGLE_MAPS_API_KEY');
        $repairmentId = $request->repairmentId;

        $repairment = Repairment::find($repairmentId);

        if (!$repairment) {
            abort(404);
        }

        return view('user-location', compact('googleMapApiKey', 'repairment'));
    }
}
