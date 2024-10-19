<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerCheckoutController extends Controller
{
    public function confirmCheckout(Request $request){
        // Làm tạm chứ chưa có api
        $project = Project::find($request->project_id);
        if ($project) {
            $data = $project->update([
                'status' => 2,
                'updated_at' => Carbon::now()
            ]);
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found'
            ], 404);
        }
    }
}
