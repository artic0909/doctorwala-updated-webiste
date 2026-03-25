<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AccessRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiNotificationController extends Controller
{
    public function notifications(Request $request)
    {
        try {
            $user = $request->user();

            $requests = AccessRequest::where('dw_user_id', $user->id)
                ->with(['doctor'])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status'  => true,
                'message' => 'Notifications fetched successfully.',
                'data'    => $requests
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function acceptRequest($id, Request $request)
    {
        try {
            $req = AccessRequest::where('id', $id)
                ->where('dw_user_id', $request->user()->id)
                ->firstOrFail();

            $req->update([
                'req_status'    => 'accepted',
                'access_status' => 'on',
                'read_status'   => 'read',
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Request accepted. The clinic can now view your medical profile.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Request not found or unauthorized.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function rejectRequest($id, Request $request)
    {
        try {
            $req = AccessRequest::where('id', $id)
                ->where('dw_user_id', $request->user()->id)
                ->firstOrFail();

            $req->update([
                'req_status'    => 'rejected',
                'access_status' => 'off',
                'read_status'   => 'read',
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Request rejected successfully.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Request not found or unauthorized.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function permissionOffRequest($id, Request $request)
    {
        try {
            $req = AccessRequest::where('id', $id)
                ->where('dw_user_id', $request->user()->id)
                ->firstOrFail();

            $req->update([
                'req_status'    => 'rejected',
                'access_status' => 'off',
                'read_status'   => 'read',
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Access has been revoked for this clinic.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Request not found or unauthorized.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function permissionOnRequest($id, Request $request)
    {
        try {
            $req = AccessRequest::where('id', $id)
                ->where('dw_user_id', $request->user()->id)
                ->firstOrFail();

            $req->update([
                'req_status'    => 'accepted',
                'access_status' => 'on',
                'read_status'   => 'read',
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Access has been granted to this clinic.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Request not found or unauthorized.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }
}
