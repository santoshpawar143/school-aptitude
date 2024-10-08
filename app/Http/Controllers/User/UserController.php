<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RoleModel;
use Yajra\DataTables\DataTables;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\request()->ajax()) {
            // $query = User::get(); // You can modify this query as needed
            $query = User::with('school')->where('is_deleted',0)->where('role','!=',1)->get();
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('school_name', function ($row) {
                // Access the school name through the relationship
                return $row->school ? $row->school->name : 'No School';
            })
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
        return view('pages.user');
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
         $is_update=User::find($request->id);
         if($is_update){

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'id' => 'nullable',
                'password' => 'nullable|string|min:6', // Added validation rule for password
                'email' => 'required|email',
                'role' => 'required',
                'school_id' => 'required'
            ]);

            // Handle password logic
            if ($request->filled('password')) {
                // If a new password is provided, hash it before saving
                $validatedData['password'] = bcrypt($request->password);
            } else {
                // Otherwise, keep the existing password
                $validatedData['password'] = $is_update->password;
            }
         }
         
         else{
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'id' => 'nullable',
                'password' => 'required',
                'email' => 'required|email',
                'role' => 'required',
                'school_id' => 'required'
            ]);
         }
       

        try {
            // Create or update the record
            $standard = User::updateOrCreate(
                ['id' => $validatedData['id']], // Criteria for update or create
                $validatedData // Data to be saved
            );

            // Determine if the record was created or updated
            $message = $standard->wasRecentlyCreated
                ? 'User created successfully!'
                : 'User updated successfully!';

            // Return a JSON response for success
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
        //real
        // try {
        //     $standard = User::findOrFail($id);
        //     $standard->delete();

        //     return response()->json(['success' => 'Record deleted successfully.']);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Record not found.'], 404);
        // }
        //soft
        try {
            $updatedRows = User::where('id', $id)->update(['is_deleted' => 1]);


            return response()->json(['success' => 'Record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Record not found.'], 404);
        }
    }
    public function user_role(){
        if (\request()->ajax()) {
            $roles = RoleModel::where('is_deleted',0)->get();

           
            return response()->json($roles);
        }
    }
}
