<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BoardsModel;
use App\Models\ChapterModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\StandardModel;
use App\Models\SubjectModel;
use App\Models\MediumModel;
use App\Models\SchoolModel;
use App\Models\TeacherModel;
use App\Models\TeacherSubjectModel;
use App\Models\TestModel;
use Illuminate\Validation\Rules\Unique;
use PHPUnit\Framework\Attributes\Medium;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            $userId = auth()->user()->id;

            // Initialize the query
            $query = ChapterModel::where('teacher_id', $userId)->where('is_deleted', 0);

            // Apply filters if they exist in the request
            if (request()->has('board_id') && request()->get('board_id') != '') {
                $query->where('board_id', request()->get('board_id'));
            }

            if (request()->has('medium_id') && request()->get('medium_id') != '') {
                $query->where('medium_id', request()->get('medium_id'));
            }

            if (request()->has('standard_id') && request()->get('standard_id') != '') {
                $query->where('standard_id', request()->get('standard_id'));
            }

            if (request()->has('subject_id') && request()->get('subject_id') != '') {
                $query->where('subject_id', request()->get('subject_id'));
            }

            // Get the filtered data
            $chapters = $query->get();

            // Return the data as JSON for DataTables
            return DataTables::of($chapters)
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

        return view('pages.chapters');
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
            'chapter_name' => 'required|string|max:255',
            'board_id' => 'required|string|max:255',
            'medium_id' => 'required|string|max:255',
            'standard_id' => 'required|string|max:255',
            'subject_id' => 'required|string|max:255',
        ]);

        try {
            // Create or update the record
            $userId = auth()->user()->id;
            $questionsArray = [];
            $teacher=TeacherModel::where('user_id',$userId)->first();
            $chapter = ChapterModel::Create(
                [
                    'chapter_name'=>$validatedData['chapter_name'],
                    'school_id'=>$teacher->school_id,
                    'teacher_id'=>$userId,
                  'questions_array'=>json_encode($questionsArray),
                    'subject_id'=> $validatedData['subject_id'],
                    'medium_id'=> $validatedData['medium_id'],
                    'standard_id'=> $validatedData['standard_id'],
                    'board_id'=> $validatedData['board_id'],
                    'is_deleted'=>0
                ]
            );

            // Determine if the record was created or updated
            $message = 'Standard created successfully!';

            // Return a JSON response for success
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $chapter // Optionally include the saved record
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
    // Validate the incoming request data
    $validatedData = $request->validate([
            'chapter_name' => 'required|string|max:255',
            'board_id' => 'required|string|max:255',
            'medium_id' => 'required|string|max:255',
            'standard_id' => 'required|string|max:255',
            'subject_id' => 'required|string|max:255',
    ]);

    try {
        // Find the ChapterModel instance by its primary key ($id)
        $chapter = ChapterModel::findOrFail($id);

        // Update the instance with the validated data
        $chapter->update([
            'chapter_name' => $validatedData['chapter_name'],
                'board_id' => $validatedData['board_id'],
                'medium_id' => $validatedData['medium_id'],
                'standard_id' => $validatedData['standard_id'],
                'subject_id' => $validatedData['subject_id']
        ]);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Chapter updated successfully',
            'data' => $chapter
        ]);

    } catch (\Exception $e) {
        // Handle any exceptions
        return response()->json([
            'success' => false,
            'message' => 'An error occurred: ' . $e->getMessage()
        ], 500);
    }
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deleteChapter = ChapterModel::where('id', $id)->update(['is_deleted' => 1]);

            return response()->json(['success' => 'Record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Record not found.'], 404);
        }
    }
    public function chapter_board(Request $request){
        if ($request->ajax()) {
            try {
                $schoolId = auth()->user()->school_id;
                $userId = auth()->user()->id;
                $school_board = SchoolModel::where('id', $schoolId)->value('board_array');
                $data = BoardsModel::whereIn('id', json_decode($school_board))->where('is_deleted', 0)->get();
                $teachers=TeacherSubjectModel::where('teacher_id',$userId)->where('is_deleted', 0)->get();
                $allBoardIds = [];

                // Loop through each teacher record
                foreach ($teachers as $teacher) {
                    // Decode the JSON array from the board_array column
                    $boardArray = json_decode($teacher->board_array, true);

                    // Ensure $boardArray is an array (it could be null or not an array)
                    if (is_array($boardArray)) {
                        // Merge the decoded array into the allBoardIds array
                        $allBoardIds = array_merge($allBoardIds, $boardArray);
                    }
                }

                // Optionally, remove duplicate IDs
                $allBoardIds = array_unique($allBoardIds);
                $data2 = BoardsModel::whereIn('id', $allBoardIds)->where('is_deleted', 0)->get();
                $dataArray = $data->pluck('id')->toArray();
                $data2Array = $data2->pluck('id')->toArray();
                $commonBoardIds = array_intersect($dataArray, $data2Array);

                $commonData = $data->filter(function ($item) use ($commonBoardIds) {
                    return in_array($item->id, $commonBoardIds);
                });
                return response()->json([
                    'success' => true,
                    'message' => 'Data retrieved successfully',
                    'data' =>
                    $commonData
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
    public function chapter_medium(Request $request)
    {
        if ($request->ajax()) {
            $validatedData = $request->validate([
                'board_id' => 'required',
            ]);
            try {
                $userId = auth()->user()->id;
                $schoolId = auth()->user()->school_id;

                // Fetch school and associated mediums
                $school = SchoolModel::where('id', $schoolId)->first();
                $schoolMediumIds = json_decode($school->medium_array, true);
                $schoolMediums = MediumModel::whereIn('id', $schoolMediumIds)->where('is_deleted',0)->pluck('id')->toArray();

                // Fetch board and associated mediums
                $board = BoardsModel::where('id', $validatedData['board_id'])->first();
                $boardMediumIds = json_decode($board->medium, true);
                $boardMediums = MediumModel::whereIn('id', $boardMediumIds)->pluck('id')->toArray();

                // Find common mediums between school and board
                $commonMediumIds = array_intersect($schoolMediums, $boardMediums);

                // Fetch teachers and their associated mediums
                $teachers = TeacherSubjectModel::where('teacher_id', $userId)->where('is_deleted',0)->get();
                $allMediumIds = [];

                foreach ($teachers as $teacher) {
                    $mediumArray = json_decode($teacher->medium_array, true);
                    if (is_array($mediumArray)) {
                        $allMediumIds = array_merge($allMediumIds, $mediumArray);
                    }
                }
                $allMediumIds = array_unique($allMediumIds);

                // Find common mediums between the filtered mediums and teacher mediums
                $commonMediumIds = array_intersect($commonMediumIds, $allMediumIds);

                // Retrieve the actual MediumModel records for common IDs
                $commonMediums = MediumModel::whereIn('id', $commonMediumIds)->get();

                return response()->json([
                    'success' => true,
                    'message' => 'Data retrieved successfully',
                    'data' => $commonMediums
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve data: ' . $e->getMessage()
                ], 500); // 500 Internal Server Error
            }
        }
    }
    public function chapter_standard(Request $request)
    {
        if ($request->ajax()) {
            $validatedData = $request->validate([
                'board_id' => 'required',
                'medium_id'=>'required',
            ]);
            try {
                $userId = auth()->user()->id;
                $schoolId = auth()->user()->school_id;

                // Fetch school and associated mediums
                $school = SchoolModel::where('id', $schoolId)->first();
                $schoolStandardIds = json_decode($school->standard_array, true);
                $schoolStandard = StandardModel::whereIn('id',$schoolStandardIds)->pluck('id')->toArray();
                $teacherStandard = TeacherSubjectModel::where('teacher_id', $userId)->whereJsonContains('board_array',$validatedData['board_id'])->whereJsonContains('medium_array', $validatedData['medium_id'])->where('is_deleted', 0)->get();
                $allStandardIds = [];
                foreach
                ($teacherStandard as $standard) {
                    $standardArray = json_decode($standard->standard_array, true);
                    if (is_array($standardArray)) {
                        $allStandardIds = array_merge($allStandardIds,$standardArray);
                    }
                }
                $allStandardIds= array_unique($allStandardIds);
                $finalStandards=StandardModel::whereIn('id',$allStandardIds)->where('is_deleted', 0)->get();
                // Fetch board and associated mediums
                $board = BoardsModel::where('id', $validatedData['board_id'])->first();
             
                // $boardMediumIds = json_decode($board->medium, true);
                // $boardMediums = MediumModel::whereIn('id', $boardMediumIds)->pluck('id')->toArray();

                // // Find common mediums between school and board
                // $commonMediumIds = array_intersect($schoolMediums, $boardMediums);

                // // Fetch teachers and their associated mediums
                // $teachers = TeacherSubjectModel::where('teacher_id', $userId)->get();
                

                // foreach ($teachers as $teacher) {
                //     $mediumArray = json_decode($teacher->medium_array, true);
                //     if (is_array($mediumArray)) {
                //         $allMediumIds = array_merge($allMediumIds, $mediumArray);
                //     }
                // }
                // $allMediumIds = array_unique($allMediumIds);

                // // Find common mediums between the filtered mediums and teacher mediums
                // $commonMediumIds = array_intersect($commonMediumIds, $allMediumIds);

                // // Retrieve the actual MediumModel records for common IDs
                // $commonMediums = MediumModel::whereIn('id', $commonMediumIds)->get();

                return response()->json([
                    'success' => true,
                    'message' => 'Data retrieved successfully',
                    'data' =>$finalStandards

                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve data: ' . $e->getMessage()
                ], 500); // 500 Internal Server Error
            }
        }
    }
    public function chapter_subject(Request $request)
    {
        if ($request->ajax()) {
            $validatedData = $request->validate([
                'board_id' => 'required',
                'medium_id' => 'required',
                'standard_id'=>'required'
            ]);
            try {
                $userId = auth()->user()->id;
                $schoolId = auth()->user()->school_id;

             
                $teacherStandard = TeacherSubjectModel::where('teacher_id', $userId)->whereJsonContains('board_array', $validatedData['board_id'])->whereJsonContains('medium_array', $validatedData['medium_id'])->whereJsonContains('standard_array', $validatedData['standard_id'])->where('is_deleted', 0)->get();
                
                $allStandardIds = [];
                foreach ($teacherStandard as $standard) {
                    $standardArray = json_decode($standard->subject_array, true);
                    if (is_array($standardArray)) {
                        $allStandardIds = array_merge($allStandardIds, $standardArray);
                    }
                }
                $allStandardIds = array_unique($allStandardIds);
                $finalStandards = SubjectModel::whereIn('id', $allStandardIds)->get();
                return response()->json([
                    'success' => true,
                    'message' => 'Data retrieved successfully',
                    'data' =>$finalStandards
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve data: ' . $e->getMessage()
                ], 500); // 500 Internal Server Error
            }
        }
    }
   
}
