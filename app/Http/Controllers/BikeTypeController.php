<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DataTables;
use App\BikeType;

class BikeTypeController extends Controller
{
    public function index()
    {
        return view('bike-type');
    }

    public function get(BikeType $bikeType)
    {
        return response()->json([
            'status'  => 'success',
            'message' => 'Fetch data success',
            'data'    => $bikeType,
        ]);
    }

    public function datatable()
    {
        $models = BikeType::select('id', 'name')->get();

        return DataTables::of($models)
            ->addColumn('action', 'datatable.bike-type')
            ->toJson();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation error',
                'data'    => $validator->errors()->all(),
            ], 400);
        }

        try {
            $bikeType = new BikeType;
            $bikeType->name = request('name');
            $bikeType->save();
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data is inserted successfully'
        ]);
    }

    public function update(BikeType $bikeType)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation error',
                'data'    => $validator->errors()->all(),
            ], 400);
        }

        try {
            $bikeType->name = request('name');
            $bikeType->save();
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data is updated successfully'
        ]);
    }

    public function destroy(BikeType $bikeType)
    {
        try {
            $bikeType->delete();
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data is deleted successfully'
        ]);
    }
}
