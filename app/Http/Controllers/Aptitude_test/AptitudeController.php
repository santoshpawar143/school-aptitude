<?php

namespace App\Http\Controllers\Aptitude_test;

use App\Http\Controllers\Controller;
use App\Models\ChapterModel;
use Illuminate\Http\Request;


use App\Models\TestModel;
use App\Models\GenerateTestModel;
use App\Models\QuestionsModel;
use App\Models\ResultsModel;
use App\Models\StudentsModel;
use Illuminate\Auth\Events\Validated;
use PHPUnit\Framework\Attributes\Medium;


class AptitudeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     
        return view('pages.aptitude_test');
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
     
    }
   
    public function start_test(Request $request)
    {
     
    
        $rules = [
            'chapter_id' => 'required',
        ];

        try {
            // Validate the request data
            $validatedData = $request->validate($rules);



            // Fetch the test using the test code
           
            $new_test = QuestionsModel::where('chapter_id', $validatedData['chapter_id'])->get();
            $chapter_name = ChapterModel::where('id', $validatedData['chapter_id'])->value('chapter_name');
            // Return the successful response
            return response()->json([
                'success' => true,
                'message' => "Success",
                'data'   => $new_test,
                'chapter_id'=>$validatedData['chapter_id'],
                'chapter_name'=>$chapter_name
               
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'success' => false,
                'message' => "Validation error: " . $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            // Handle general errors
            return response()->json([
                'success' => false,
                'message' => "An error occurred: " . $e->getMessage(),
            ], 500);
        }
    }

    public function save_test(Request $request)
    {
        try {
            // Get the authenticated user's ID
            $userId = auth()->user()->id;
            $school_id=auth()->user()->school_id;
            // Define validation rules
            $rules = [
                'chapter_id' => 'required|integer',
                'marks_obtained' => 'required|integer',
                'totalMarks' => 'required|integer',
                'selected_ans'=>'required',
                'result'=>'required'
            ];

            // Validate request data
            $validatedData = $request->validate($rules);

            // Fetch the subject ID based on chapter ID
            $subject_id = ChapterModel::where('id', $validatedData['chapter_id'])->value('subject_id');

            if (is_null($subject_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subject ID not found for the given chapter ID'
                ], 404); // Return 404 Not Found if the subject ID is not found
            }

            // Create or update the result record
            $result = ResultsModel::updateOrCreate(
                [
                    'chapter_id' => $validatedData['chapter_id'],
                    'student_id' => $userId,
                    'subject_id' => $subject_id,
                    'school_id' => $school_id,
                    
                ],
                [
                    'marks_obtained' => $validatedData['marks_obtained'],
                    'total_marks' => $validatedData['totalMarks'],
                    'selected_ans'=>$validatedData['selected_ans'],
                    'result'=>$validatedData['result'],
                    'is_deleted' => 0,
                ]
            );

            // Return a JSON response for success
            return response()->json([
                'success' => true,
                'message' => 'Result saved successfully',
                'data' => $result
            ], 200);
        } catch (\Exception $e) {
            // Return a JSON response for errors
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    }

