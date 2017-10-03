<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Repairment;
use App\Notifications\RepairmentOnProgress;
use App\Notifications\RepairmentDone;
use DB;

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
        $sixDigitFromPhone = substr($phone, -4);
        $randomNumber = substr(time(), -4);
        $reportNumber = "{$firstName}-{$sixDigitFromPhone}{$randomNumber}";

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

        $subscription = json_decode($request->input('subscription'));
        $repairment->updatePushSubscription(
            $subscription->endpoint,
            $subscription->keys->p256dh,
            $subscription->keys->auth
        );

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

    public function updateStatus(Repairment $repairment)
    {
        if (!request('status')) {
            switch ($repairment->status) {
                case 'WAITING':
                    $status = 'ON_PROGRESS';
                    break;

                case 'ON_PROGRESS':
                    $status = 'DONE';
                    break;
            }

        } else {
            $status = request('status');
        }

        try {
            $repairment->status = $status;
            $repairment->save();
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

        if ($repairment->status === 'ON_PROGRESS') {
            $repairment->notify(new RepairmentOnProgress());
        } elseif ($repairment->status === 'DONE') {
            $repairment->notify(new RepairmentDone());

            $subscription = DB::table('push_subscriptions')
                ->select('endpoint')
                ->where('repairment_id', $repairment->id)
                ->first();

            $repairment->deletePushSubscription($subscription->endpoint);
        }

        return response()->json([
            'status' => 'success',
            'message' => "Report status is successfully changed to {$repairment->status}"
        ]);
    }
}
