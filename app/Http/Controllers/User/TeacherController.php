<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BoardsModel;
use App\Models\MediumModel;
use App\Models\RoleModel;
use App\Models\StandardModel;
use App\Models\SchoolModel;
use App\Models\User;
use App\Models\StudentsModel;
use App\Models\SubjectModel;
use App\Models\TeacherModel;
use Illuminate\Auth\Events\Validated;
use Yajra\DataTables\DataTables;
class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            $schoolId = auth()->user()->school_id;
            $query = TeacherModel::join('users', 'teacher.user_id', '=', 'users.id') // Adjust join condition as necessary
            ->where('teacher.school_id', $schoolId)
            ->where('teacher.del_status', 0)
            ->where('users.is_deleted', 0)
            ->select('teacher.*', 'users.email', 'users.password') // Select necessary fields
            ->get();
           
            return DataTables::of($query)
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
        return view('pages.teacher');
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
            'teacher_name' => ['required', 'string', 'max:255'],
            'teacher_no' => ['required', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ]);
       
      try {
            $role = RoleModel::where('role_name', 'teacher')->first();
            $teacherExists = TeacherModel::where('school_id', $schoolId)
            ->where('teacher_no', $validatedData['teacher_no'])
            ->exists();

            if ($teacherExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Teacher already exists with this teacher no',
                ], 409); // 409 Conflict
            }
          
            $user = User::create([
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'name' => $validatedData['teacher_name'],
                'school_id' => $schoolId,
                'role' => $role->id,
            ]);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create user',
                ], 500);
            }

            // Create a new teacher record
            $teacher = TeacherModel::create([
                'teacher_no' => $validatedData['teacher_no'],
                'user_id' =>     $user->id,
                'teacher_name' => $validatedData['teacher_name'],
                'school_id' => $schoolId,
                'del_status' => 0
            ]);

            if (!$teacher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create teacher',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => "Teacher created successfully",
            ], 201); // 201 Created
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
        if ($request->ajax()) {
            // Validate incoming data
            $validatedData = $request->validate([
                'teacher_name' => ['required', 'string', 'max:255'],
                'teacher_no' => ['required', 'max:255'],
                'id' => ['required', 'exists:users,id'], // Ensure the user ID exists
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['nullable', 'string', 'min:6'], // Password is optional
            ]);

            try {
                // Find the user by ID
                $user = User::findOrFail($validatedData['id']);
                $teacher = TeacherModel::where('user_id', $user->id)->first();
                // Check if the email needs to be updated
                if ($user->email !== $validatedData['email']) {
                    // Ensure new email is not already taken
                    $request->validate([
                        'email' => ['unique:users,email']
                    ]);

                    // Update email
                    $user->email = $validatedData['email'];
                }
                if ($teacher->teacher_no != $validatedData['teacher_no']) {
                    // Ensure new email is not already taken
                    $teacherExists = TeacherModel::where('school_id', $user->school_id)
                        ->where('teacher_no', $validatedData['teacher_no'])
                        ->exists();

                    if ($teacherExists) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Teacher already exists with this teacher no',
                        ], 409); // 409 Conflict
                    }

                    // Update email
                    $teacher->teacher_no = $validatedData['teacher_no'];
                }
               
                // Check if the password needs to be updated
                if (!empty($validatedData['password'])) {
                    // Hash and update the new password
                    $user->password = bcrypt($validatedData['password']);
                }

                // Update other user fields
                $user->save();

                // Update related teacher record
              

                if ($teacher) {
                    $teacher->update([
                        'teacher_name' => $validatedData['teacher_name'],
                        'teacher_no' => $validatedData['teacher_no'],
                    ]);
                } else {
                    // Handle case where related teacher record does not exist
                    return response()->json([
                        'success' => false,
                        'message' => 'Teacher record not found'
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
            $deletedTeacher = TeacherModel::where('user_id', $id)->update(['del_status' => 1]);

            return response()->json(['success' => 'Record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Record not found.'], 404);
        }
    }
}
