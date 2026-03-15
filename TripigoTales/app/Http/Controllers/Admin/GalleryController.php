<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\ContactInquiry;
use App\Models\ContactUsSubmission;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['title']);

        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/galleries'), $imageName);
            $data['image'] = 'uploads/galleries/'.$imageName;
        }

        Gallery::create($data);

        return redirect()->route('galleries.index')
            ->with('success', 'Gallery item created successfully');
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'title' => $request->title,
        ];

        if ($request->hasFile('image')) {
            if ($gallery->image && file_exists(public_path($gallery->image))) {
                unlink(public_path($gallery->image));
            }

            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/galleries'), $imageName);
            $data['image'] = 'uploads/galleries/'.$imageName;
        }

        $gallery->update($data);

        return redirect()->route('galleries.index')
            ->with('success', 'Gallery item updated successfully');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        if ($gallery->image && file_exists(public_path($gallery->image))) {
            unlink(public_path($gallery->image));
        }

        $gallery->delete();

        return redirect()->route('galleries.index')
            ->with('success', 'Gallery item deleted successfully');
    }


    /** FAQ form submissions (destination, full_name, etc.). */
    public function feqList()
    {
        $inquiries = ContactInquiry::with('destination')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('admin.faq.index', compact('inquiries'));
    }

    /** Contact Us page form submissions only (first_name, last_name, email, phone, message). */
    public function contactUsIndex()
    {
        $submissions = ContactUsSubmission::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.contact-us.index', compact('submissions'));
    }
}

