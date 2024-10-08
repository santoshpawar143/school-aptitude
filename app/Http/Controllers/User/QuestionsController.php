<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\BoardsModel;
use App\Models\ChapterModel;
use App\Models\MediumModel;
use App\Models\QuestionsModel;
use App\Models\SchoolModel;
use App\Models\StandardModel;
use App\Models\SubjectModel;
use App\Models\TeacherModel;
use App\Models\TeacherSubjectModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Medium;
use Yajra\DataTables\DataTables;
class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            $userId = auth()->user()->id;
            $chapterId = \request()->get('chapter_id'); // Use get() to retrieve the chapter_id
            $query = QuestionsModel::join('chapters', 'questions.chapter_id', '=', 'chapters.id')
                ->where('questions.chapter_id', $chapterId)
                ->where('questions.is_deleted', 0) // Adjust join condition as necessary
            ->where('chapters.is_deleted', 0)
            ->select('questions.*', 'chapters.board_id', 'chapters.medium_id', 'chapters.standard_id', 'chapters.subject_id') // Select necessary fields
            ->get();
            // Return data as JSON for DataTables
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" class="btn btn-primary btn-sm edit" data-id="' . $row->id . '">
                    <i class="bi bi-pencil" style="font-size: 0.75rem;"></i></a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">
                    <i class="bi bi-trash" style="font-size: 0.75rem;"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.questions');
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
        $schoolId = auth()->user()->school_id;

        // Validate request data
        $validatedData = $request->validate([
            'chapter_id' => 'required|integer',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_ans' => 'required|string',
        ]);

        try {
            // Create the question
            $question = QuestionsModel::create([
                'school_id' => $schoolId,
                'teacher_id' => auth()->user()->id,
                'chapter_id' => $validatedData['chapter_id'],
                'question' => $validatedData['question'],
                'option_a' => $validatedData['option_a'],
                'option_b' => $validatedData['option_b'],
                'option_c' => $validatedData['option_c'],
                'option_d' => $validatedData['option_d'],
                'correct_ans' => $validatedData['correct_ans'],
            ]);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Question created successfully',
                'data' => $question // Optionally return the created question
            ], 201); // 201 Created status code

        } catch (\Exception $e) {
            // Log the exception (optional)
            Log::error('Error creating question: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to create question',
                'error' => $e->getMessage()
            ], 500); // 500 Internal Server Error status code
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
        $validatedData = $request->validate([
            'id'=>'required|integer',
            'chapter_id' => 'required|integer',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_ans' => 'required|string',
        ]);

        try {
            // Create the question
            $question=QuestionsModel::find($id);
            $question->update([
                'chapter_id' => $validatedData['chapter_id'],
                'question' => $validatedData['question'],
                'option_a' => $validatedData['option_a'],
                'option_b' => $validatedData['option_b'],
                'option_c' => $validatedData['option_c'],
                'option_d' => $validatedData['option_d'],
                'correct_ans' => $validatedData['correct_ans'],
            ]);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Question updated successfully',
                'data' => $question // Optionally return the created question
            ], 201); // 201 Created status code

        } catch (\Exception $e) {
            // Log the exception (optional)
            Log::error('Error updating question: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to update question',
                'error' => $e->getMessage()
            ], 500); // 500 Internal Server Error status code
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deleteQuestion = QuestionsModel::where('id', $id)->update(['is_deleted' => 1]);
            return response()->json(['success' => 'Record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Record not found.'], 404);
        }
    }
    public function questions_getChapters(Request $request)
    {
        $userId = auth()->user()->id;
        $validatedData = $request->validate([
            'board_id' => 'required',
            'medium_id' => 'required',
            'standard_id' => 'required',
            'subject_id'=>'required'
        ]);
        try {
            // Fetch chapters based on the teacher_id
            $chapters = ChapterModel::where('teacher_id', $userId)->where('board_id',$validatedData['board_id'])->where('medium_id', $validatedData['medium_id'])->where('standard_id', $validatedData['standard_id'])->where('subject_id', $validatedData['subject_id'])->where('is_deleted',0)->get();
            $teacher= TeacherModel::where('user_id',$userId)->where('del_status',0)->first();
            // $board=BoardsModel::where('id',$teacher->board_id)->first();
            // $medium = MediumModel::where('id', $teacher->medium_id)->first();
            // $standard = StandardModel::where('id', $teacher->standard_id)->first();
            // $subject = SubjectModel::where('id', $teacher->subject_id)->first();

            // Return a JSON response with the data
            return response()->json([
                'success' => true,
                'message' => 'Successfully retrieved chapters',
                'data' => $chapters,
                // 'board'=>  $board,
                // 'medium' => $medium,
                // 'standard' => $standard,
                // 'subject' => $subject,

            ], 200); // Use status code 200 for a successful response

        } catch (\Exception $e) {
            // Log the error for debugging (optional)
            Log::error('Error fetching chapters: ' . $e->getMessage());

            // Return a JSON response with an error message
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500); // Use status code 500 for a server error
        }
    }
    public function questions_board(Request $request)
    {
        if ($request->ajax()) {
            try {
                $schoolId = auth()->user()->school_id;
                $userId = auth()->user()->id;
                $school_board = SchoolModel::where('id', $schoolId)->value('board_array');
                $data = BoardsModel::whereIn('id', json_decode($school_board))->where('is_deleted', 0)->get();
                $teachers = TeacherSubjectModel::where('teacher_id', $userId)->where('is_deleted', 0)->get();
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
    public function questions_medium(Request $request)
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
                $schoolMediums = MediumModel::whereIn('id', $schoolMediumIds)->pluck('id')->toArray();

                // Fetch board and associated mediums
                $board = BoardsModel::where('id', $validatedData['board_id'])->first();
                $boardMediumIds = json_decode($board->medium, true);
                $boardMediums = MediumModel::whereIn('id', $boardMediumIds)->pluck('id')->toArray();

                // Find common mediums between school and board
                $commonMediumIds = array_intersect($schoolMediums, $boardMediums);

                // Fetch teachers and their associated mediums
                $teachers = TeacherSubjectModel::where('teacher_id', $userId)->where('is_deleted', 0)->get();
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
                $commonMediums = MediumModel::whereIn('id', $commonMediumIds)->where('is_deleted', 0)->get();

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
    public function questions_standard(Request $request)
    {
        if ($request->ajax()) {
            $validatedData = $request->validate([
                'board_id' => 'required',
                'medium_id' => 'required',
            ]);
            try {
                $userId = auth()->user()->id;
                $schoolId = auth()->user()->school_id;

                // Fetch school and associated mediums
                $school = SchoolModel::where('id', $schoolId)->first();
                $schoolStandardIds = json_decode($school->standard_array, true);
                $schoolStandard = StandardModel::whereIn('id', $schoolStandardIds)->pluck('id')->toArray();
                $teacherStandard = TeacherSubjectModel::where('teacher_id', $userId)->whereJsonContains('board_array', $validatedData['board_id'])->whereJsonContains('medium_array', $validatedData['medium_id'])->where('is_deleted', 0)->get();
                $allStandardIds = [];
                foreach ($teacherStandard as $standard) {
                    $standardArray = json_decode($standard->standard_array, true);
                    if (is_array($standardArray)) {
                        $allStandardIds = array_merge($allStandardIds, $standardArray);
                    }
                }
                $allStandardIds = array_unique($allStandardIds);
                $finalStandards = StandardModel::whereIn('id', $allStandardIds)->where('is_deleted', 0)->get();
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
                    'data' => $finalStandards

                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve data: ' . $e->getMessage()
                ], 500); // 500 Internal Server Error
            }
        }
    }
    public function questions_subject(Request $request)
    {
        if ($request->ajax()) {
            $validatedData = $request->validate([
                'board_id' => 'required',
                'medium_id' => 'required',
                'standard_id' => 'required'
            ]);
            try {
                $userId = auth()->user()->id;
                $schoolId = auth()->user()->school_id;


                $teacherStandard = TeacherSubjectModel::where('teacher_id', $userId)->whereJsonContains('board_array', $validatedData['board_id'])->whereJsonContains('medium_array', $validatedData['medium_id'])->whereJsonContains('standard_array', $validatedData['standard_id'])->get();

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
                    'data' => $finalStandards
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
