<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\SuperBlogModel;
use Illuminate\Http\Request;

class SuperBlogController extends Controller
{
    public function index()
    {

        $blogs = SuperBlogModel::orderBy('id', 'desc')->get();

        return view('superadmin.super-blogs', compact('blogs'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'blg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'blg_title' => 'required|string',
            'blg_desc' => 'nullable|string',
        ]);

        $filePath = null;

        if ($request->hasFile('blg_image')) {
            $file = $request->file('blg_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/blog-image', $fileName, 'public');
        }

        SuperBlogModel::create([
            'blg_image' => $filePath,
            'blg_title' => $request->blg_title,
            'blg_desc' => $request->blg_desc,
        ]);

        return back()->with('success', 'Added Successfully!');
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'blg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'blg_title' => 'required|string',
            'blg_desc' => 'nullable|string',
        ]);

        $blogInfo = SuperBlogModel::findOrFail($id);

        if ($request->hasFile('blg_image')) {

            if ($blogInfo->blg_image && file_exists(public_path('storage/' . $blogInfo->blg_image))) {
                unlink(public_path('storage/' . $blogInfo->blg_image));
            }

            $file = $request->file('blg_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/blog-image', $fileName, 'public');
            $blogInfo->blg_image = $filePath;
        }

        $blogInfo->blg_title = $request->blg_title;
        $blogInfo->blg_desc = $request->blg_desc;
        $blogInfo->save();

        return back()->with('success', 'Updated successfully!');
    }


    public function delete($id)
    {
        $blogInfo = SuperBlogModel::find($id);

        if ($blogInfo) {

            if (file_exists(public_path('storage/' . $blogInfo->blg_image))) {
                unlink(public_path('storage/' . $blogInfo->blg_image));
            }


            $blogInfo->delete();

            return back()->with('success', 'deleted successfully!');
        } else {
            return back()->with('error', 'not found.');
        }
    }
}
