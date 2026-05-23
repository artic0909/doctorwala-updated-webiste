<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\DwUserModel;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class SuperAllUserController extends Controller
{
    public function index(Request $request)
    {
        $query = DwUserModel::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('user_email', 'like', "%{$search}%")
                  ->orWhere('user_mobile', 'like', "%{$search}%")
                  ->orWhere('user_city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $users = $query->orderBy('id', 'desc')->paginate(10);
        return view('superadmin.super-all-user', compact('users'));
    }

    public function delete($id)
    {
        $userInfo = DwUserModel::find($id);

        $userInfo->delete();

        return back()->with('success', 'deleted successfully!');
    }


    public function exportAsExel(Request $request){
        return Excel::download(new UsersExport($request->all()), 'user_details.xlsx');
    }
}
