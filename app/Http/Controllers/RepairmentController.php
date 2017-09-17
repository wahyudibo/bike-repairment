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

        try {
            $repairment = new Repairment;
            $repairment->name            = $request->input('name');
            $repairment->identity_number = $request->input('identityNumber');
            $repairment->phone           = $request->input('phone');
            $repairment->unit_id         = $request->input('unit');
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

        return response()->json([
            'status' => 'success',
            'message' => 'Repairment report is sucessfully saved',
        ]);
    }
}
