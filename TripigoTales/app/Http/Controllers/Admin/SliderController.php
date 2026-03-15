<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\SliderButton;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::with('buttons')->orderBy('sort_order')->latest()->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subtitle' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable',
            'buttons' => 'nullable|array',
            'buttons.*.label' => 'required_with:buttons.*|string|max:255',
            'buttons.*.link' => 'nullable|string|max:500',
            'buttons.*.style' => 'nullable|string|in:nir-btn,nir-btn-black',
        ]);

        $data = $request->only(['subtitle', 'title', 'description', 'sort_order']);
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $dir = public_path('uploads/sliders');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move($dir, $imageName);
            $data['image'] = 'uploads/sliders/' . $imageName;
        }

        $slider = Slider::create($data);

        if ($request->has('buttons') && is_array($request->buttons)) {
            foreach ($request->buttons as $index => $btn) {
                if (empty($btn['label'])) continue;
                SliderButton::create([
                    'slider_id' => $slider->id,
                    'label' => $btn['label'],
                    'link' => $btn['link'] ?? '#',
                    'style' => $btn['style'] ?? 'nir-btn',
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('sliders.index')->with('success', 'Slider created successfully');
    }

    public function edit($id)
    {
        $slider = Slider::with('buttons')->findOrFail($id);
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $request->validate([
            'subtitle' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable',
            'buttons' => 'nullable|array',
            'buttons.*.label' => 'required_with:buttons.*|string|max:255',
            'buttons.*.link' => 'nullable|string|max:500',
            'buttons.*.style' => 'nullable|string|in:nir-btn,nir-btn-black',
        ]);

        $data = $request->only(['subtitle', 'title', 'description', 'sort_order']);
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($slider->image && file_exists(public_path($slider->image))) {
                unlink(public_path($slider->image));
            }
            $dir = public_path('uploads/sliders');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move($dir, $imageName);
            $data['image'] = 'uploads/sliders/' . $imageName;
        }

        $slider->update($data);

        // Replace buttons
        $slider->buttons()->delete();
        if ($request->has('buttons') && is_array($request->buttons)) {
            foreach ($request->buttons as $index => $btn) {
                if (empty($btn['label'])) continue;
                SliderButton::create([
                    'slider_id' => $slider->id,
                    'label' => $btn['label'],
                    'link' => $btn['link'] ?? '#',
                    'style' => $btn['style'] ?? 'nir-btn',
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('sliders.index')->with('success', 'Slider updated successfully');
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        if ($slider->image && file_exists(public_path($slider->image))) {
            unlink(public_path($slider->image));
        }
        $slider->delete();
        return redirect()->route('sliders.index')->with('success', 'Slider deleted successfully');
    }
}
