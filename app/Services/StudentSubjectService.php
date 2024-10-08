<?php

namespace App\Services;

use App\Models\StudentsModel;
use App\Models\SubjectModel;
use Illuminate\Support\Facades\Log;

class StudentSubjectService
{
    /**
     * Get all subjects for students.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSubjects()
    {
        $userId = auth()->user()->id;

        try {
            // Find the student record
            $student = StudentsModel::where('user_id', $userId)->first();

            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found',
                ], 404); // 404 Not Found status code
            }

            // Decode the JSON array of subject IDs


            $boardId = strval($student->board_id);
            $mediumId = strval($student->medium_id);
            $standard_Id = strval($student->standard_id);

            // Retrieve the subjects
            $subjects = SubjectModel::whereJsonContains('board_array', $boardId)
                ->whereJsonContains('medium_array', $mediumId)
                ->whereJsonContains('standard_array', $standard_Id)
                ->where('is_deleted',0)
                ->get();


            return response()->json([
                'success' => true,
                'message' => 'Subjects retrieved successfully',
                'data' => $subjects,
            ], 200); // 200 OK status code

        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error retrieving student subjects: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve subjects',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status code
        }
    
    }
}
