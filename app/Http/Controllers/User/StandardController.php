<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StandardModel;
use Yajra\DataTables\DataTables;
class StandardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            $query = StandardModel::where('is_deleted',0)->get(); // You can modify this query as needed
        
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm edit" data-id="' . $row->id . '">
                    <i class="bi bi-pencil" style="font-size: 0.75rem;"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">
                    <i class="bi bi-trash" style="font-size: 0.75rem;"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.standard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'id' => 'nullable'
        ]);

        try {
            // Create or update the record
            $standard = StandardModel::updateOrCreate(
                ['id' => $validatedData['id']], // Criteria for update or create
                $validatedData // Data to be saved
            );

            // Determine if the record was created or updated
            $message = $standard->wasRecentlyCreated
                ? 'Standard created successfully!'
                : 'Standard updated successfully!';

            // Return a JSON response for success
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $standard // Optionally include the saved record
            ], 200);
        } catch (\Exception $e) {
            // Return a JSON response for errors
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //real
        // try {
        //     $standard = StandardModel::findOrFail($id);
        //     $standard->delete();

        //     return response()->json(['success' => 'Record deleted successfully.']);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Record not found.'], 404);
        // }
        //soft
        try {
            $updatedRows = StandardModel::where('id', $id)->update(['is_deleted' => 1]);


            return response()->json(['success' => 'Record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Record not found.'], 404);
        }
    }
}
