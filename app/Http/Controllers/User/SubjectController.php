<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolModel;
use App\Models\MediumModel;
use App\Models\BoardsModel;
use App\Models\StandardModel;
use App\Models\SubjectModel;
use Yajra\DataTables\DataTables;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (\request()->ajax()) {
          if(auth()->user()->role==1){
                $query = SubjectModel::where('is_deleted',0)->get();
          }
          else{
                $query = SubjectModel::where('school_id', auth()->user()->school_id)->where('is_deleted', 0)->get();
          }
              
            // You can modify this query as needed

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $board = $row->board_array;
                    $boardEscaped = htmlspecialchars($board, ENT_QUOTES, 'UTF-8');
                    $medium = $row->medium_array;
                    $mediumEscaped = htmlspecialchars($medium, ENT_QUOTES, 'UTF-8');
                $standard = $row->standard_array;
                $standardEscaped = htmlspecialchars($standard, ENT_QUOTES, 'UTF-8');
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm edit" data-id="' . $row->id . '" data-board=\'' . $boardEscaped . '\' data-medium=\'' . $mediumEscaped . '\'data-standard=\'' . $standardEscaped . '\'>
                    <i class="bi bi-pencil" style="font-size: 0.75rem;"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">
                    <i class="bi bi-trash" style="font-size: 0.75rem;"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $response = response()->view('pages.subject');

        $response->headers->add([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);

        return $response;
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subject_name' => 'required|string|max:255',
            'id' => 'nullable',
           
        ]);
        if (isset($validatedData['id'])) {
            // Validate with 'nullable' rules if 'id' is present
            $additionalData = $request->validate([
                'medium_array' => 'nullable',
                'standard_array' => 'nullable',
                'board_array' => 'nullable',
            ]);
        } else {
            // Validate with 'required' rules if 'id' is not present
            $additionalData = $request->validate([
                'medium_array' => 'required',
                'standard_array' => 'required',
                'board_array' => 'required',
            ]);
        }

        // Merge additional data into the validated data
        $validatedData = array_merge($validatedData, $additionalData);

        
        try {
            // Create or update the record
            $subject = SubjectModel::updateOrCreate(
                ['id' => $validatedData['id']], // Criteria for update or create
                [
                    'subject_name' => $validatedData['subject_name'],
                    'medium_array' => $validatedData['medium_array'],
                    'standard_array' => $validatedData['standard_array'],
                    'board_array' => $validatedData['board_array']
            
                ]
            );
           
            // Determine if the record was created or updated
            $message = $subject->wasRecentlyCreated
                ? 'Subject created successfully!'
                : 'Subject updated successfully!';

            // Return a JSON response for success
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $subject // Optionally include the saved record
            ], 200);
        } catch (\Exception $e) {
            // Return a JSON response for errors
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function subject_medium(Request $request)
    {
        if ($request->ajax()) {
            try {
                $ids = $request->input('board', []);
                $boards = BoardsModel::whereIn('id', $ids)->where('is_deleted', 0)->get();
                $mediumIds = [];
                foreach ($boards as $board) {
                    $mediums = json_decode($board->medium, true);
                    if (is_array($mediums)) {
                        $mediumIds = array_merge($mediumIds, $mediums);
                    }
                }
                $mediumIds = array_unique($mediumIds);
                $data = MediumModel::whereIn('id', $mediumIds)->where('is_deleted', 0)->get();
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
    public function subject_board(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = BoardsModel::where('is_deleted', 0)->get();
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
    public function subject_standard(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = StandardModel::where('is_deleted', 0)->get();
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
    public function destroy(string $id)
    {
        // real
        // try {
        //     $standard = SubjectModel::findOrFail($id);
        //     $standard->delete();

        //     return response()->json(['success' => 'Record deleted successfully.']);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Record not found.'], 404);
        // }
        //soft
        try {
            $updatedRows = SubjectModel::where('id', $id)->update(['is_deleted' => 1]);


            return response()->json(['success' => 'Record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Record not found.'], 404);
        }
    }
}
