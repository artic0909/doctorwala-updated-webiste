<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\PartnerCarousel;
use Illuminate\Http\Request;

class SuperPartnerCarouselController extends Controller
{
    public function index()
    {
        $carousels = PartnerCarousel::all();
        return view('superadmin.super-partner-carousel', compact('carousels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $filePath = null;

        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/partnercarousel', $fileName, 'public');
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'File upload failed. Please try again.']);
            }
        }

        PartnerCarousel::create([
            'image' => $filePath,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return back()->with('success', 'Added Successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $carousel = PartnerCarousel::find($id);

        if ($carousel) {
            if ($request->hasFile('image')) {
                if ($carousel->image && file_exists(public_path('storage/' . $carousel->image))) {
                    unlink(public_path('storage/' . $carousel->image));
                }

                $file = $request->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/partnercarousel', $fileName, 'public');
                $carousel->image = $filePath;
            }

            $carousel->title = $request->input('title');
            $carousel->description = $request->input('description');
            $carousel->save();

            return back()->with('success', 'Updated successfully!');
        } else {
            return back()->with('error', 'Not found.');
        }
    }

    public function delete($id)
    {
        $carousel = PartnerCarousel::find($id);

        if ($carousel) {
            if ($carousel->image && file_exists(public_path('storage/' . $carousel->image))) {
                unlink(public_path('storage/' . $carousel->image));
            }

            $carousel->delete();

            return back()->with('success', 'Deleted successfully!');
        } else {
            return back()->with('error', 'Not found.');
        }
    }
}
