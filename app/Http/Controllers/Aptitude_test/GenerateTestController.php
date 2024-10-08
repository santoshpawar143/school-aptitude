<?php

namespace App\Http\Controllers\Aptitude_test;

use App\Http\Controllers\Controller;
use App\Models\GenerateTestModel;

use App\Models\MediumModel;
use App\Models\StandardModel;
use App\Models\SubjectModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use LDAP\Result;
use Illuminate\Support\Facades\Log;
class GenerateTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            $schoolId = auth()->user()->school_id;

            // Fetch GenerateTestModel records
            $tests = GenerateTestModel::where('school_id', $schoolId)->get();

            // Collect IDs for medium, standard, and subject
            $mediumIds = $tests->pluck('medium')->unique();
            $standardIds = $tests->pluck('standard')->unique();
            $subjectIds = $tests->pluck('subject')->unique();

            // Fetch related models based on the collected IDs
            $mediums = MediumModel::whereIn('id', $mediumIds)->pluck('name', 'id');
            $standards = StandardModel::whereIn('id', $standardIds)->pluck('name', 'id');
            $subjects = SubjectModel::whereIn('id', $subjectIds)->pluck('subject_name', 'id');

            return DataTables::of($tests)
                ->addIndexColumn()
                ->addColumn('medium_name', function ($row) use ($mediums) {
                    return $mediums->get($row->medium, 'N/A');
                })
                ->addColumn('standard_name', function ($row) use ($standards) {
                    return $standards->get($row->standard, 'N/A');
                })
                ->addColumn('subject_name', function ($row) use ($subjects) {
                    return $subjects->get($row->subject, 'N/A');
                })
                ->addColumn('action', function ($row) {
                    $btn= '<a href="javascript:void(0)" class="btn btn-danger btn-sm g-delete" data-id="' . $row->id . '">
                <i class="bi bi-trash" style="font-size: 0.75rem;"></i></a>';
               
                return $btn;
                })
                ->addColumn('status', function ($row) {

                $btn = '<div class="form-check form-switch">
            <input class="form-check-input status_switchbox" 
                   type="checkbox" 
                   value="' . $row->status . '" 
                   data-id="' . $row->id . '" 
                   id="test' . $row->id . '" 
                   ' . ($row->status == 1 ? 'checked' : '') . ' />
        </div>';
                    return $btn;
                })
                ->rawColumns(['action','status'])
               
                ->make(true);
        }
     
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

        $schoolId = auth()->user()->school_id; // Default to the authenticated user's school_id
        $rules = [
            'test_name' => 'required',
            'questions' => 'required',
            'subject'=>'required',
            'medium'=>'required',
            'standard'=>'required',
            'id'=>'nullable'
        ];

        if (isset($request->id) && $request->id) {
            $test = GenerateTestModel::find($request->id);
            if ($test) {
                $schoolId = $test->school_id; // Use the school's ID from the test if it exists
            }
        } else {
            $validatedData = $request->validate($rules);
        }
      

        // Add the school_id to the validated data array
        $validatedData['school_id'] = $schoolId;
       
        try {
            // Create or update the record
            $standard = GenerateTestModel::updateOrCreate(
                ['id' => $validatedData['id']], // Criteria for update or create
                [
                    'test_name' => $validatedData['test_name'],
                    'questions' => json_encode($validatedData['questions']),
                    'test_code' => uniqid('test_', true),
                    'school_id' => $schoolId,
                    'subject'=>$validatedData['subject'],
                    'medium' => $validatedData['medium'],
                    'standard' => $validatedData['standard']
                ]
            );

            // Determine if the record was created or updated
            $message = $standard->wasRecentlyCreated
                ? 'Test created successfully!'
                : 'Test updated successfully!';

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $standard = GenerateTestModel::findOrFail($id);
            $standard->delete();

            return response()->json(['success' => 'Record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Record not found.'], 404);
        }
    }
  
    public function status_update(Request $request){
        if (\request()->ajax()) {
            $rules = [
                'id' => 'required'
            ];
            $validatedData = $request->validate($rules);
            try {
                // Find the GenerateTestModel record by ID
                $generateTest = GenerateTestModel::find($validatedData['id']);

                // Check if the record exists
                if (!$generateTest) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Record not found'
                    ], 404);
                }

                // Toggle the status between 0 and 1
                $generateTest->status = ($generateTest->status == 0) ? 1 : 0;
                $generateTest->save();

                // Return a success response
                return response()->json([
                    'success' => true,
                    'message' => 'Status updated successfully',
                    'status' => $generateTest->status // Return the updated status
                ], 200);
            } catch (\Exception $e) {
                // Handle exceptions and return a JSON response with error details
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        
        }
    }
}
