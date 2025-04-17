<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Activitylog\Models\Activity;

class LogActivityController extends Controller
{
    public function activeLogPage()
    {
        return view("backend.pages.log.log-activity-page");
    }

    public function activeLogList(Request $request)
    {
        if ($request->ajax()) {
            $data = Activity::orderBy('created_at', 'DESC')->with('causer')->get();
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('log_description', function ($row) {
                    return $row->description; // Activity Log description
                })
                ->addColumn('log_time', function ($row) {
                    return $row->created_at->format('Y-m-d H:i:s'); // Format Date
                })
                ->addColumn('log_user', function ($row) {
                    return $row->causer ? $row->causer->name : 'System'; // Get user name
                })
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-info btn-sm view-btn" data-id="' . $row->id . '" data-toggle="modal" data-target="#logViewModal">View</button>';
                })
                
                ->rawColumns(['action']) // Render HTML for the action column
                ->make(true);
        }
    }

    public function logView($id)
    {
        $log = Activity::with('causer')->findOrFail($id);
        
        return response()->json([
            'status' => 'success',
            'data' => [
                'log_name'   => $log->log_name,
                'description' => $log->description,
                'created_at'  => $log->created_at->format('Y-m-d H:i:s'),
                'causer'      => $log->causer ? ['name' => $log->causer->name] : null,
                'attributes'  => $log->properties ? json_decode($log->properties, true) : []
            ]
        ]);
    }


}
