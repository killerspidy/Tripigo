<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Tour;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['tour', 'user'])->latest()->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => true]);

        return redirect()->route('reviews.index')
            ->with('success', 'Review approved successfully');
    }

    public function reject($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => false]);

        return redirect()->route('reviews.index')
            ->with('success', 'Review rejected successfully');
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:1000',
        ]);

        $review = Review::findOrFail($id);
        $review->update([
            'admin_reply' => $request->admin_reply,
            'is_approved' => true, // Auto-approve when admin replies
        ]);

        return redirect()->route('reviews.index')
            ->with('success', 'Reply added successfully');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('reviews.index')
            ->with('success', 'Review deleted successfully');
    }
}
