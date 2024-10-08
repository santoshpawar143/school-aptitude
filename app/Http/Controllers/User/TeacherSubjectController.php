<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BoardsModel;
use App\Models\MediumModel;
use App\Models\RoleModel;
use App\Models\SchoolModel;
use App\Models\StandardModel;
use App\Models\SubjectModel;
use App\Models\TeacherModel;
use App\Models\TeacherSubjectModel;
use App\Models\User;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Medium;
use Yajra\DataTables\Facades\DataTables;

class TeacherSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            $schoolId = auth()->user()->school_id;

            $query = TeacherSubjectModel::join('users', 'teacher_subject.teacher_id', '=', 'users.id')
            ->where('teacher_subject.school_id', $schoolId)
                ->where('teacher_subject.is_deleted', 0)
                ->where('users.is_deleted', 0)
                ->select('teacher_subject.*', 'users.name as teacher_name');
            if (request()->has('board_id') && request()->get('board_id') != '') {
                $query->whereJsonContains('teacher_subject.board_array', request()->get('board_id'));
            }

            if (request()->has('medium_id') && request()->get('medium_id') != '') {
                $query->whereJsonContains('teacher_subject.medium_array', request()->get('medium_id'));
            }

            if (request()->has('standard_id') && request()->get('standard_id') != '') {
                $query->whereJsonContains('teacher_subject.standard_array', request()->get('standard_id'));
            }

            if (request()->has('subject_id') && request()->get('subject_id') != '') {
                $query->whereJsonContains('teacher_subject.subject_array', request()->get('subject_id'));
            }
            $result = $query->get()->map(function ($row) {
                // Convert JSON arrays into readable strings
                $row->board_array = implode(',', BoardsModel::whereIn('id', json_decode($row->board_array))->pluck('name')->toArray());
                $row->medium_array = implode(',', MediumModel::whereIn('id', json_decode($row->medium_array))->pluck('name')->toArray());
                $row->standard_array = implode(',', StandardModel::whereIn('id', json_decode($row->standard_array))->pluck('name')->toArray());
                $row->subject_array = implode(',', SubjectModel::whereIn('id', json_decode($row->subject_array))->pluck('subject_name')->toArray());
                return $row;
            });

            return DataTables::of($result)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm edit" data-id="' . $row->id . '">
                    // <i class="bi bi-pencil" style="font-size: 0.75rem;"></i></a>';
                    $btn = ' <a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">
                    <i class="bi bi-trash" style="font-size: 0.75rem;"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.teacher_subject');

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
        $validatedData = $request->validate([
            'teacher_id' => ['required'],
            'board_array' => 'required|array',
            'medium_array' => 'required|array',
            'standard_array' => 'required|array',
            'subject_array' => 'required|array',
        ]);

        try {
            $query = TeacherSubjectModel::query();

            // Apply filters
            $boardIds = $validatedData['board_array'];
            $mediumIds = $validatedData['medium_array'];
            $standardIds = $validatedData['standard_array'];
            $subjectIds = $validatedData['subject_array'];
            $query->where('school_id',$schoolId);
             $query->where('is_deleted',0);
            $query->where(function ($q) use ($boardIds) {
                foreach ($boardIds as $boardId) {
                    $q->whereJsonContains('board_array', $boardId);
                }
            });

            $query->where(function ($q) use ($mediumIds) {
                foreach ($mediumIds as $mediumId) {
                    $q->whereJsonContains('medium_array', $mediumId);
                }
            });

           

            // Retrieve records
            $is_exist = $query->get();

            // Initialize $filteredSubjects
            $filteredSubjects = collect(); // Initialize as an empty collection

            if (!$is_exist->isEmpty()) {
                $filteredStandards = $is_exist->filter(function ($item) use ($standardIds) {
                    $itemSubjectArray = json_decode($item->standard_array, true); // Decode the JSON field
                    if (!is_array($itemSubjectArray)) {
                        $itemSubjectArray = [];
                    }
                    return !empty(array_intersect($standardIds, $itemSubjectArray));
                });
                if(! $filteredStandards->isEmpty()){
                     $query->where(function ($q) use ($standardIds) {
                foreach ($standardIds as $standardId) {
                    $q->whereJsonContains('standard_array', $standardId);
                }
            });
            $is_exist=$query->get();
                    $filteredSubjects = $is_exist->filter(function ($item) use ($subjectIds) {
                        $itemSubjectArray = json_decode($item->subject_array, true); // Decode the JSON field
                        if (!is_array($itemSubjectArray)) {
                            $itemSubjectArray = [];
                        }
                        return !empty(array_intersect($subjectIds, $itemSubjectArray));
                    });
                    if (!$filteredSubjects->isEmpty()) {
                        $matchingTeacherId = $filteredSubjects->filter(function ($item) use ($validatedData) {
                            return $item->teacher_id == $validatedData['teacher_id'];
                        });
                        if ($matchingTeacherId->isEmpty()) {
                            return response()->json([
                                'success' => false,
                                'message' => "one of the subject is assigned to Another Teacher",
                                'query' => $is_exist
                            ], 500);
                        } else {
                            return response()->json([
                                'success' => false,
                                'message' => "one of the subject is already Assigned to this teacher",
                                'query' => $is_exist
                            ],500);
                        }
                    }
               
                }
                // Further filter the records based on subject_array
              
            }
          

            // Uncomment and use this part if you want to create a new record
            TeacherSubjectModel::create([
                'teacher_id' => $validatedData['teacher_id'],
                'board_array' => json_encode($validatedData['board_array']),
                'medium_array' => json_encode($validatedData['medium_array']),
                'standard_array' => json_encode($validatedData['standard_array']),
                'subject_array' => json_encode($validatedData['subject_array']),
                'school_id' => $schoolId,
                'is_deleted' => 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Teacher created successfully",
                'query' => $filteredSubjects
            ], 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500); // 500 Internal Server Error
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
           
            $deletedsubject = TeacherSubjectModel::where('id', $id)->update(['is_deleted' => 1]);

            return response()->json(['success' => 'Record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Record not found.'], 404);
        }
    }
    public function teacher_subject_board(Request $request)
    {
        if ($request->ajax()) {
            try {
                $schoolId = auth()->user()->school_id;
                $school_board=SchoolModel::where('id',$schoolId)->value('board_array');
                $data = BoardsModel::whereIn('id',json_decode($school_board))->where('is_deleted', 0)->get();
                return response()->json([
                    'success' => true,
                    'message' => 'Data retrieved successfully',
                    'data' => $data
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
    public function teacher_subject_medium(Request $request)
    {
        if ($request->ajax()) {
            try {
                $schoolId = auth()->user()->school_id;
                $ids = $request->input('board', []);
                $boards = BoardsModel::whereIn('id', $ids)->where('is_deleted', 0)->get();
                $mediumIds = [];
                foreach ($boards as $board) {
                    $mediums = json_decode($board->medium, true);
                    if (is_array($mediums)) {
                        $mediumIds = array_merge($mediumIds, $mediums);
                    }
                }
                // $mediumIds = array_intersect($mediumIds);
                $mediumIdCounts = array_count_values($mediumIds);

                // Find the maximum count value
                if(!empty($mediumIdCounts)){
                    $maxCount = max($mediumIdCounts);
                }
               else{
                $maxCount=0;
               }

                // Find medium IDs that have the maximum count
                $commonMediumIds = array_keys(array_filter($mediumIdCounts, function ($count) use ($maxCount) {
                        return $count === $maxCount;
                    }));
                $finalMediumIds = !empty($commonMediumIds) ?  $commonMediumIds : $mediumIds;
                $data = MediumModel::whereIn('id', $finalMediumIds)->where('is_deleted', 0)->get();
                $school_mediums = SchoolModel::where('id', $schoolId)->value('medium_array');
                // Decode the medium_array if it's a JSON string
                $school_mediums = json_decode($school_mediums, true);
                if (!is_array($school_mediums)) {
                    $school_mediums = [];
                }
                $data2 = MediumModel::whereIn('id', $school_mediums)->where('is_deleted', 0)->get();

                // Get IDs of mediums from the SchoolModel

                // Get common medium IDs
                $dataMediumIds = $data->pluck('id')->toArray();
                $data2MediumIds=$data2->pluck('id')->toArray();
                $commonMediumIds = array_intersect($dataMediumIds, $data2MediumIds);

                // Fetch common mediums
                $commen_mediums = MediumModel::whereIn('id', $commonMediumIds)->get();

                return response()->json([
                    'success' => true,
                    'message' => 'Data retrieved successfully',
                    'data' => $commen_mediums,
                    'common_mediums' => $commen_mediums
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
public function teacher_subject_subjects(Request $request){
        if ($request->ajax()) {
            try {
                // Retrieve input values
                $schoolId = auth()->user()->school_id;
                $boardIds = $request->input('board', []);
                $mediumIds = $request->input('medium', []);
                $standardIds = $request->input('standard', []);

                // Start building the query
                $query = SubjectModel::query();

                // Apply filters
               
                    $query->where(function ($q) use ($boardIds) {
                        foreach ($boardIds as $boardId) {
                            $q->whereJsonContains('board_array', $boardId);
                        }
                    });
               
              
                    $query->where(function ($q) use ($mediumIds) {
                        foreach ($mediumIds as $mediumId) {
                            $q->whereJsonContains('medium_array', $mediumId);
                        }
                    });
            

                
                    $query->where(function ($q) use ($standardIds) {
                        foreach ($standardIds as $standardId) {
                            $q->whereJsonContains('standard_array', $standardId);
                        }
                    });


                // Get the filtered subjects
                if (!empty($boardIds) && !empty($mediumIds) && !empty($standardIds)) {
                $subjects = $query->where('is_deleted',0)->get();
                    return response()->json([
                        'success' => true,
                        'message' => 'Data retrieved successfully',
                        'data' => $subjects
                    ]);
                }
                else{
                    return response()->json([
                        'success' => true,
                        'message' => 'Data retrieved successfully',
                        'data' => []
                    ]);
                }
             
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
