<?php

namespace App\Http\Controllers\Autocomplete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MediumModel;
use App\Models\SchoolModel;
use App\Models\User;

class AutocompleteController extends Controller
{
    public function autocomplete_medium(Request $request)
    {
        $query = $request->get('query');

        // Fetch suggestions from the database
        $mediums = MediumModel::where('name', 'LIKE', "%{$query}%")->where('is_deleted',0)->get(['id', 'name']);

        return response()->json($mediums);
    }
    public function autocomplete_school(Request $request)
    {
        $term = $request->get('term');

        // Fetch matching schools from the database
        $schools = SchoolModel::where('school_name', 'like', '%' . $term . '%')->where('is_deleted', 0)
            ->get(['id', 'school_name']);

        // Format the results for jQuery UI Autocomplete
        $results = $schools->map(function ($school) {
            return [
                'label' => $school->school_name,
                'value' => $school->school_name,
                'id'=> $school->id
            ];
        });

        return response()->json($results);
    }
    public function autocomplete_teacher(Request $request)
    {
        $term = $request->get('term');
        $schoolId = auth()->user()->school_id;

        // Fetch matching teachers from the database
        $teachers = User::where('name', 'like', '%' . $term . '%')->where('school_id',$schoolId)
            ->where('is_deleted', 0)
            ->get(['id', 'name']);

        // Format the results for jQuery UI Autocomplete
        $results = $teachers->map(function ($teacher) {
            return [
                'label' => $teacher->name,
                'value' => $teacher->name,
                'id'    => $teacher->id
            ];
        });

        return response()->json($results);
    }

}
