<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DataTables;
use App\WorkUnit;

class WorkUnitController extends Controller
{
    public function index()
    {
        return view('work-unit');
    }

    public function get(WorkUnit $workUnit)
    {
        return response()->json([
            'status'  => 'success',
            'message' => 'Fetch data success',
            'data'    => $workUnit,
        ]);
    }

    public function datatable()
    {
        $models = WorkUnit::select('id', 'name')->get();

        return DataTables::of($models)
            ->addColumn('action', 'datatable.work-unit')
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
            ]);
        }

        try {
            $workUnit = new WorkUnit;
            $workUnit->name = request('name');
            $workUnit->save();
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data is inserted successfully'
        ]);
    }

    public function update(WorkUnit $workUnit)
    {
        try {
            $workUnit->name = request('name');
            $workUnit->save();
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data is updated successfully'
        ]);
    }

    public function destroy(WorkUnit $workUnit)
    {
        try {
            $workUnit->delete();
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data is deleted successfully'
        ]);
    }
}
