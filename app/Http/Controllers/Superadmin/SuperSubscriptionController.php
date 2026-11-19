<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\SuperSubscriptionModel;
use Illuminate\Http\Request;

class SuperSubscriptionController extends Controller
{
    public function index()
    {
        return view('superadmin.subscriptions.create');
    }


    public function show(Request $request)
    {
        $query = SuperSubscriptionModel::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('subs_title', 'like', "%{$search}%")
                  ->orWhere('subs_amount', 'like', "%{$search}%");
            });
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $subscriptions = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        return view('superadmin.subscriptions.index', compact('subscriptions'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'subs_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'subs_title' => 'required|string',
            'subs_amount' => 'required|numeric',
            'opening_date' => 'nullable|date', // Allow it to be nullable
            'closing_date' => 'required',
            'features' => 'required|array',
            'features.*' => 'string',
        ]);

        // Handle file upload
        $filePath = null;

        if ($request->hasFile('subs_image')) {
            try {
                $file = $request->file('subs_image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/subscription-image', $fileName, 'public');
            } catch (\Exception $e) {
                return back()->withErrors(['subs_image' => 'File upload failed. Please try again.']);
            }
        }

        // Default to the current date if no opening_date is provided
        $openingDate = $request->input('opening_date') ?? now();

        SuperSubscriptionModel::create([
            'subs_image' => $filePath,
            'subs_title' => $request->input('subs_title'),
            'subs_amount' => $request->input('subs_amount'),
            'subs_open_date' => $openingDate,
            'subs_close_date' => $request->input('closing_date'),
            'features' => $request->input('features'), // Features are already an array
        ]);

        return redirect('/superadmin/super-show-subscription')->with('success', 'Added Successfully!');
    }



    public function updateStatus(Request $request, $id)
    {

        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        $couponInfo = SuperSubscriptionModel::find($id);
        $couponInfo->status = $request->input('status');
        $couponInfo->save();

        return back()->with('success', 'updated successfully!');
    }


    public function delete($id)
    {
        $couponInfo = SuperSubscriptionModel::find($id);

        if ($couponInfo) {

            if (file_exists(public_path('storage/' . $couponInfo->subs_image))) {
                unlink(public_path('storage/' . $couponInfo->subs_image));
            }


            $couponInfo->delete();

            return back()->with('success', 'deleted successfully!');
        } else {
            return back()->with('error', 'not found.');
        }
    }
}
