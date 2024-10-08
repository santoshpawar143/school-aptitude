<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ChapterModel;
use App\Models\StudentsModel;
use App\Models\SubjectModel;
use App\Services\StudentSubjectService;
use Exception;
use Hamcrest\Core\HasToString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class StudentSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {

            $subjectId = \request()->get('subject_id');
            $user = auth()->user();
            $student = StudentsModel::where('user_id',$user->id)->first();
            $query = ChapterModel::where('school_id', $student->school_id)->where('standard_id',$student->standard_id)->where('medium_id', $student->medium_id)->where('board_id', $student->board_id)->where('subject_id',$subjectId)->where('is_deleted', 0)->get(); // Use query() to build the query



            // Return the data as JSON for DataTables
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm aptitude" data-id="' . $row->id . '">
              Start</a>';
                   
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.student_subject');
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
        //
    }
    protected $studentSubjectService;
    public function __construct(StudentSubjectService $studentSubjectService)
    {
        $this->studentSubjectService = $studentSubjectService;
    }
    public function student_all_subject()
    {
        $subjects = $this->studentSubjectService->getAllSubjects();
        return $subjects;
    }

}
