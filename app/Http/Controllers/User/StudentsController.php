<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BoardsModel;
use App\Models\MediumModel;
use App\Models\RoleModel;
use App\Models\StandardModel;
use App\Models\SchoolModel;
use App\Models\StudentsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\ValidatedData;
use PhpParser\PrettyPrinter\Standard;
use PHPUnit\Framework\Attributes\Medium;
use Yajra\DataTables\DataTables;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            $schoolId = auth()->user()->school_id;
           
            $query = StudentsModel::join('users', 'student.user_id', '=', 'users.id') // Adjust join condition as necessary
            ->where('student.school_id', $schoolId)
            ->where('student.del_status', 0)
            ->where('users.is_deleted', 0)
            ->select('student.*', 'users.email', 'users.password'); // Select necessary fields
            if (request()->has('board_id') && request()->get('board_id') != '') {
                $query->where('student.board_id', request()->get('board_id'));
            }

            if (request()->has('medium_id') && request()->get('medium_id') != '') {
                $query->where('student.medium_id', request()->get('medium_id'));
            }

            if (request()->has('standard_id') && request()->get('standard_id') != '') {
                $query->where('student.standard_id', request()->get('standard_id'));
            }

            if (request()->has('subject_id') && request()->get('subject_id') != '') {
                $query->where('students.subject_id', request()->get('subject_id'));
            }
            $result = $query->get()->map(function ($row) {
            
                $row->board = BoardsModel::where('id', $row->board_id)->value('name');
                $row->medium = MediumModel::where('id', $row->medium_id)->value('name');
                $row->standard = StandardModel::where('id', $row->standard_id)->value('name');

                return $row;
            });
            return DataTables::of($result)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm edit" data-id="' . $row->id . '">
                    <i class="bi bi-pencil" style="font-size: 0.75rem;"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-id="' . $row->user_id . '">
                    <i class="bi bi-trash" style="font-size: 0.75rem;"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.student');
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

        // Define base validation rules
        $rules = [
            'student_name' => 'required',
            'roll_no' => 'required',
            'id' => 'nullable',
            'board_id' => 'required',
            'medium_id' => 'required',
            'standard_id' => 'required',
            'password' => 'required',
            'email' => 'required'
        ];

        $validatedData = $request->validate($rules); // Validate request data
        if ($validatedData['id'] == '') {
            $studentExist = StudentsModel::where('board_id', $validatedData['board_id'])->where('medium_id', $validatedData['medium_id'])->where('standard_id', $validatedData['standard_id'])->where('roll_no', $validatedData['roll_no'])->first();
            if ($studentExist) {
                return response()->json([
                    'success' => true,
                    'message' => "student already exist",
                    // 'data' => $standard // Optionally include the saved record
                ], 200);
            } else {
                $role = RoleModel::where('role_name', 'student')->first();
                $User = User::create([
                    'email' => $validatedData['email'],
                    'password' => bcrypt($validatedData['password']),
                    'name' => $validatedData['student_name'],
                    'school_id' => $schoolId,
                    'role' => $role->id,
                ]);
                if (!$User) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Failed to create user',

                    ], 200);
                }
                $student = StudentsModel::create([
                    'roll_no' => $validatedData['roll_no'],
                    'medium_id' => $validatedData['medium_id'],
                    'board_id' => $validatedData['board_id'],
                    'standard_id' => $validatedData['standard_id'],
                    'student_name' => $validatedData['student_name'],
                    'user_id'=>$User->id,
                    'school_id' => $schoolId,
                    'del_status'=>0
                ]);
                if (!$student) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to create user',
                    ], 500);
                }
                return response()->json([
                    'success' => true,
                    'message' => "student created successfull",
                    // 'data' => $standard // Optionally include the saved record
                ], 200);
            }
        } else {
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
        if ($request->ajax()) {
            // Validate incoming data
            $validatedData = $request->validate([
                'student_name' => ['required', 'string', 'max:255'],
                'roll_no' => ['required', 'max:255'],
                'id' => ['required', 'exists:users,id'], // Ensure the user ID exists
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['nullable', 'string', 'min:6'], // Password is optional
                'board_id' => 'required',
                'medium_id' => 'required',
                'standard_id' => 'required'
            ]);

            try {
                // Find the user by ID
                $user = User::findOrFail($validatedData['id']);
                $student = StudentsModel::where('user_id', $user->id)->first();
                // Check if the email needs to be updated
                $user->name = $validatedData['student_name'];
                if ($user->email !== $validatedData['email']) {
                    // Ensure new email is not already taken
                    $request->validate([
                        'email' => ['unique:users,email']
                    ]);

                    // Update email
                    $user->email = $validatedData['email'];
                }
                if ($student->roll_no != $validatedData['roll_no']) {
                    // Ensure new email is not already taken
                    $teacherExists = StudentsModel::where('school_id', $user->school_id)
                        ->where('roll_no', $validatedData['roll_no'])
                        ->exists();

                    if ($teacherExists) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Student already exists with this roll no',
                        ], 409); // 409 Conflict
                    }

                    // Update email
                    $student->roll_no = $validatedData['roll_no'];
                    
                }

                // Check if the password needs to be updated
                if (!empty($validatedData['password'])) {
                    // Hash and update the new password
                    $user->password = bcrypt($validatedData['password']);
                }

                // Update other user fields
                $user->save();

                // Update related teacher record


                if ($student) {
                    $student->update([
                        'student_name' => $validatedData['student_name'],
                        'roll_no' => $validatedData['roll_no'],
                        'board_id' => $validatedData['board_id'],
                        'medium_id' => $validatedData['medium_id'],
                        'standard_id' => $validatedData['standard_id']
                    ]);
                } else {
                    // Handle case where related teacher record does not exist
                    return response()->json([
                        'success' => false,
                        'message' => 'Student record not found'
                    ], 404);
                }

                // Return success response
                return response()->json([
                    'success' => true,
                    'message' => 'Updated successfully',
                ]);
            } catch (\Exception $e) {
                // Catch and handle any exceptions that occur
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        }

        // If not an AJAX request, return an error
        return response()->json([
            'success' => false,
            'message' => 'Invalid request',
        ], 400);
    }
    public function student_board(Request $request)
    {
        if ($request->ajax()) {
            try {
                $schoolId = auth()->user()->school_id;
                $school = SchoolModel::where('id', $schoolId)->first();
                $board = BoardsModel::whereIn('id', json_decode($school->board_array))->where('is_deleted',0)->get();
                return response()->json([
                    'success' => true,
                    'message' => 'Data retrieved successfully',
                    'data' => $board
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve data: ' . $e->getMessage()
                ], 500); // 500 Internal Server Error
            }
        }
    }
    public function student_medium(Request $request)
    {
        if ($request->ajax()) {
            $validatedData = $request->validate([
                'board_id' => 'required',
            ]);
            try {
                $schoolId = auth()->user()->school_id;
                $school = SchoolModel::where('id', $schoolId)->first();
                $schoolmedium = MediumModel::whereIn('id', json_decode($school->medium_array))->get();
                $board = BoardsModel::where('id', $validatedData['board_id'])->first();
                $boardmedium = MediumModel::whereIn('id', json_decode($board->medium))->where('is_deleted',0)->get();
                $commonMediums = $schoolmedium->intersect($boardmedium);
                return response()->json([
                    'success' => true,
                    'message' => 'Data retrieved successfully',
                    'data'
                    => $commonMediums
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve data: ' . $e->getMessage()
                ], 500); // 500 Internal Server Error
            }
        }
    }
    public function student_standard(Request $request)
    {
        if ($request->ajax()) {
            try {
                $schoolId = auth()->user()->school_id;
                $school = SchoolModel::where('id', $schoolId)->first();
                $medium = StandardModel::whereIn('id', json_decode($school->standard_array))->where('is_deleted',0)->get();
                return response()->json([
                    'success' => true,
                    'message' => 'Data retrieved successfully',
                    'data' => $medium
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve data: ' . $e->getMessage()
                ], 500); // 500 Internal Server Error
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //real
        // try {
        //     $standard = StudentsModel::findOrFail($id);
        //     $standard->delete();

        //     return response()->json(['success' => 'Record deleted successfully.']);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Record not found.'], 404);
        // }
        //soft
        try {
            $deleteUser = User::where('id', $id)->update(['is_deleted' => 1]);
            $deletedTeacher = StudentsModel::where('user_id', $id)->update(['del_status' => 1]);

            return response()->json(['success' => 'Record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Record not found.'], 404);
        }
    }
}
