<?php

namespace App\Http\Controllers\Aptitude_test;

use App\Http\Controllers\Controller;
use App\Models\BoardsModel;
use App\Models\ChapterModel;
use App\Models\MediumModel;
use Illuminate\Http\Request;
use App\Models\ResultsModel;
use App\Models\SchoolModel;
use App\Models\StandardModel;
use App\Models\StudentsModel;
use App\Models\SubjectModel;
use App\Models\TeacherModel;
use App\Models\TeacherSubjectModel;
use Illuminate\Support\Facades\Log;
use LDAP\Result;
use PHPUnit\Framework\Attributes\Medium;
use Yajra\DataTables\DataTables;
class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            $user = auth()->user();
            $teacher=TeacherModel::where('user_id',$user->id)->first();
            $chapter_ids=ChapterModel::where('teacher_id', $user->id)->pluck('id');
            $query = ResultsModel::join('student', 'result.student_id', '=', 'student.user_id')
            ->join('chapters', 'result.chapter_id', '=', 'chapters.id')
            ->where('result.school_id', $teacher->school_id)
            ->where('result.is_deleted', 0)
            ->where('student.del_status', 0)
            ->select('result.*', 'student.student_name','student.roll_no','chapters.chapter_name') // Select necessary fields
            ;
            if (request()->has('chapter_id') && request()->get('chapter_id') != '') {

                $query->where('chapters.id', request()->get('chapter_id'));
            }
            else{
                $query->whereIn('chapters.id', $chapter_ids)->get();
            }
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
        return view('pages.result');
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
        //
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|integer',
            'marks_obtained' => 'required|integer',
            'total_marks' => 'required|integer',
            
        ]);
        try {
            $standard = ResultsModel::where('id', $id)->update($validatedData);
            $message =  'Result updated successfully!';
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $updatedRows = ResultsModel::where('id', $id)->update(['is_deleted' => 1]);
           

            return response()->json(['success' => 'Record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Record not found.'], 404);
        }
    }




    public function result_getChapters(Request $request)
    {
        $userId = auth()->user()->id;
        $validatedData = $request->validate([
            'board_id' => 'required',
            'medium_id' => 'required',
            'standard_id' => 'required',
            'subject_id' => 'required'
        ]);
        try {
            // Fetch chapters based on the teacher_id
            $chapters = ChapterModel::where('teacher_id', $userId)->where('board_id', $validatedData['board_id'])->where('medium_id', $validatedData['medium_id'])->where('standard_id', $validatedData['standard_id'])->where('subject_id', $validatedData['subject_id'])->where('is_deleted', 0)->get();
            $teacher = TeacherModel::where('user_id', $userId)->where('del_status', 0)->first();
           
            // Return a JSON response with the data
            return response()->json([
                'success' => true,
                'message' => 'Successfully retrieved chapters',
                'data' => $chapters,
             

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
    public function result_board(Request $request)
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
    public function result_medium(Request $request)
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
                $boardMediums = MediumModel::whereIn('id', $boardMediumIds)->where('is_deleted', 0)->pluck('id')->toArray();

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

                $commonMediumIds = array_intersect($commonMediumIds, $allMediumIds);
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
    public function result_standard(Request $request)
    {
        if ($request->ajax()) {
            $validatedData = $request->validate([
                'board_id' => 'required',
                'medium_id' => 'required',
            ]);
            try {
                $userId = auth()->user()->id;
                $schoolId = auth()->user()->school_id;
                $school = SchoolModel::where('id', $schoolId)->first();
                $schoolStandardIds = json_decode($school->standard_array, true);
                $schoolStandard = StandardModel::whereIn('id', $schoolStandardIds)->where('is_deleted', 0)->pluck('id')->toArray();
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
                $board = BoardsModel::where('id', $validatedData['board_id'])->first();
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
    public function result_subject(Request $request)
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
                $teacherStandard = TeacherSubjectModel::where('teacher_id', $userId)->whereJsonContains('board_array', $validatedData['board_id'])->whereJsonContains('medium_array', $validatedData['medium_id'])->whereJsonContains('standard_array', $validatedData['standard_id'])->where('is_deleted', 0)->get();
                $allStandardIds = [];
                foreach ($teacherStandard as $standard) {
                    $standardArray = json_decode($standard->subject_array, true);
                    if (is_array($standardArray)) {
                        $allStandardIds = array_merge($allStandardIds, $standardArray);
                    }
                }
                $allStandardIds = array_unique($allStandardIds);
                $finalStandards = SubjectModel::whereIn('id', $allStandardIds)->where('is_deleted', 0)->get();
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
