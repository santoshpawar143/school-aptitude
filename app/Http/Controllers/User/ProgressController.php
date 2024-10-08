<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChapterModel;
use App\Models\ResultsModel;
use App\Models\StudentsModel;
use App\Services\StudentSubjectService;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {

            $subjectId = \request()->get('subject_id');
            $user = auth()->user();
            $student = StudentsModel::where('user_id', $user->id)->first();
            // $query = ResultsModel::where('school_id', $student->school_id)->where('subject_id', $subjectId)->where('is_deleted', 0)->get(); // Use query() to build the query
            $query = ResultsModel::join('chapters', 'result.chapter_id', '=', 'chapters.id') // Adjust join condition as necessary
            ->where('result.school_id', $student->school_id)
            ->where('result.student_id',$user->id)
            ->where('result.subject_id', $subjectId)
            ->where('result.is_deleted', 0)
            ->where('chapters.is_deleted', 0)
            ->select('result.*', 'chapters.chapter_name') // Select necessary fields
            ->get();


            // Return the data as JSON for DataTables
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm review" data-id="' . $row->id . '">
              Review</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.progress');
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
     
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      
    }
 
    protected $studentSubjectService;
    public function __construct(StudentSubjectService $studentSubjectService)
    {
        $this->studentSubjectService = $studentSubjectService;
    }
    public function progress_all_subject()
    {
        $subjects = $this->studentSubjectService->getAllSubjects();
        return $subjects;
    }
}
