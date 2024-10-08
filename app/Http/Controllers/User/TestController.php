<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StandardModel;
use App\Models\SubjectModel;
use App\Models\MediumModel;
use App\Models\SchoolModel;
use App\Models\TestModel;
use PhpParser\PrettyPrinter\Standard;
use Yajra\DataTables\DataTables;
class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            // Get the filter parameters from the request
            $subject = \request('subject');
            $medium = \request('medium');
            $standard = \request('standard'); // You had a typo here, should be standard

            // Build the query with filters
            $query = TestModel::where('is_deleted',0); // Use query() to build the query

            if ($subject) {
                $query->where('subject', $subject); // Apply the subject filter
            }

            if ($medium) {
                $query->where('medium', $medium); // Apply the medium filter
            }

            if ($standard) {
                $query->where('standard', $standard); // Apply the standard filter
            }

            // Return the data as JSON for DataTables
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <input type="checkbox" class="form-check-input generate_test m-2" data-id="' . $row->id . '">';
                $btn .= '<a href="javascript:void(0)" class="btn btn-primary btn-sm edit" data-id="' . $row->id . '">
                    <i class="bi bi-pencil" style="font-size: 0.75rem;"></i></a>';
                $btn .= ' <a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">
                    <i class="bi bi-trash" style="font-size: 0.75rem;"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.test');
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
            'subject'=>'required',
            'standard'=>'required',
            'medium'=>'required',
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_ans' => 'required',
            'id' => 'nullable',
        ];

        if (isset($request->id) && $request->id) {
            $test = TestModel::find($request->id);
            if ($test) {
                
                $schoolId = $test->school_id; // Use the school's ID from the test if it exists
                $rules['standard'] = 'nullable';
                $rules['medium'] = 'nullable';
                $rules['subject'] = 'nullable';
                $validatedData = $request->validate($rules);
                $validatedData['standard'] = $test->standard;
                $validatedData['medium'] = $test->medium;
                $validatedData['subject'] = $test->subject;
            }
        }
        else{
            $validatedData = $request->validate($rules);
        }
        // Validate the request data
       
        // $validatedData = $request->validate([
        //     'standard' => 'required',
        //     'medium' => 'required',
        //     'subject' => 'required',
        //     'question' => 'required',
        //     'option_a' => 'required',
        //     'option_b' => 'required',
        //     'option_c' => 'required',
        //     'option_d' => 'required',
        //     'correct_ans' => 'required',
        //     'id' => 'nullable'
        // ]);

        // Add the school_id to the validated data array
        $validatedData['school_id'] = $schoolId;
        $validatedData['del_status'] = 0;
        try {
            // Create or update the record
            $standard =TestModel::updateOrCreate(
                ['id' => $validatedData['id']], // Criteria for update or create
                $validatedData // Data to be saved
            );

            // Determine if the record was created or updated
            $message = $standard->wasRecentlyCreated
                ? 'Qxuestion created successfully!'
                : 'Question updated successfully!';

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
    public function show(string $id) {}

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
            $updatedRows = SubjectModel::where('id', $id)->update(['is_deleted' => 1]);


            return response()->json(['success' => 'Record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Record not found.'], 404);
        }
    }
    public function test_medium(Request $request)
    {
        if ($request->ajax()) {
            try {
                // Step 1: Retrieve the authenticated user's school_id
                $schoolId = auth()->user()->school_id;

                // Step 2: Fetch the medium values from the SchoolModel for the given school_id
                $school = SchoolModel::find($schoolId);

                if (!$school) {
                    return response()->json([
                        'success' => false,
                        'message' => 'School not found'
                    ], 404); // 404 Not Found
                }

                // Assuming the medium column is a JSON array
                $mediumIds = json_decode($school->medium, true);

                if (!is_array($mediumIds)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid medium format'
                    ], 400); // 400 Bad Request
                }

                // Step 3: Fetch the records from the MediumModel that match the medium IDs
                $mediums = MediumModel::whereIn('id', $mediumIds)->where('is_deleted',0)->get();

                return response()->json([
                    'success' => true,
                    'message' => 'Data retrieved successfully',
                    'data' => $mediums
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve data: ' . $e->getMessage()
                ], 500); // 500 Internal Server Error
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid request'
        ], 400); // 400 Bad Request
    }
    public function test_standard(Request $request)
    {
        if ($request->ajax()) {
            try {
                // Step 1: Retrieve the authenticated user's school_id
                // $schoolId = auth()->user()->school_id;

                // // Step 2: Fetch the medium values from the SchoolModel for the given school_id
                // $subject = SubjectModel::find($schoolId);

                // if (!$subject) {
                //     return response()->json([
                //         'success' => false,
                //         'message' => 'School not found'
                //     ], 404); // 404 Not Found
                // }

                // // Assuming the medium column is a JSON array
                // $standardIds = json_decode($subject->standard, true);

                // if (!is_array($standardIds)) {
                //     return response()->json([
                //         'success' => false,
                //         'message' => 'Invalid medium format'
                //     ], 400); // 400 Bad Request
                // }

                // // Step 3: Fetch the records from the MediumModel that match the medium IDs
                // $standards = StandardModel::whereIn('id', $standardIds)->get();
                $standards = StandardModel::where('is_deleted',0)->get();

                return response()->json([
                    'success' => true,
                    'message' => 'Data retrieved successfully',
                    'data' => $standards
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve data: ' . $e->getMessage()
                ], 500); // 500 Internal Server Error
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid request'
        ], 400); // 400 Bad Request
    }
    public function test_subject(Request $request)
    {
        if ($request->ajax()) {
            try {
               

                // Step 2: Fetch the medium values from the SchoolModel for the given school_id
                // $subject = SubjectModel::find($schoolId);
                // $data = SubjectModel::all();
                $subject = SubjectModel::where('is_deleted',0)->get();
                if (!$subject) {
                    return response()->json([
                        'success' => false,
                        'message' => 'School not found'
                    ], 404); // 404 Not Found
                }
                // $data = SubjectModel::where('school_id', $schoolId);
               
                return response()->json([
                    'success' => true,
                    'message' => 'Data retrieved successfully',
                    'data' => $subject
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve data: ' . $e->getMessage()
                ], 500); // 500 Internal Server Error
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid request'
        ], 400);
    }
}
