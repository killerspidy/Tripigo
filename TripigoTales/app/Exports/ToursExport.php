<?php

namespace App\Exports;

use App\Models\Tour;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ToursExport implements FromCollection, WithHeadings, WithMapping
{
    protected bool $forArchive = false;

    public function __construct(bool $forArchive = false)
    {
        $this->forArchive = $forArchive;
    }

    public function collection()
    {
        return Tour::with(['category', 'subcategory'])->orderBy('id')->get();
    }

    public function headings(): array
    {
        return [
            'ID', 'Title', 'Location', 'Language', 'Star Rating', 'Image', 'Gallery Images', 'PDF',
            'Category', 'Subcategory', 'Tour Duration', 'Price', 'Two Person Share', 'Three Person Share',
            'Special Discount', 'Discount Status', 'Day', 'Max People', 'Min Age', 'Bedroom',
            'Friday Date', 'Pickup', 'Departure Time', 'Description', 'What To Expect',
            'Price Includes', 'Departure Return Location', 'Travel Plan', 'Status',
        ];
    }

    public function map($tour): array
    {
        $imagePath = $tour->image ?? '';
        $pdfPath = $tour->pdf ?? '';
        $galleryPaths = '';

        if ($this->forArchive) {
            if ($imagePath && file_exists(public_path($imagePath))) {
                $imagePath = 'media/' . $tour->id . '_main.' . pathinfo($imagePath, PATHINFO_EXTENSION);
            }
            if ($pdfPath && file_exists(public_path($pdfPath))) {
                $pdfPath = 'media/' . $tour->id . '_pdf.' . pathinfo($pdfPath, PATHINFO_EXTENSION);
            }
            if (!empty($tour->gallery_images) && is_array($tour->gallery_images)) {
                $parts = [];
                foreach ($tour->gallery_images as $i => $path) {
                    if ($path && file_exists(public_path($path))) {
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $parts[] = 'media/' . $tour->id . '_gallery_' . $i . '.' . $ext;
                    }
                }
                $galleryPaths = implode(',', $parts);
            }
        } else {
            $galleryPaths = is_array($tour->gallery_images) ? implode(',', $tour->gallery_images) : '';
        }

        return [
            $tour->id,
            $tour->title ?? '',
            $tour->location ?? '',
            $tour->language ?? '',
            $tour->star_rating ?? '',
            $imagePath,
            $galleryPaths,
            $pdfPath,
            $tour->category->name ?? '',
            $tour->subcategory->name ?? '',
            $tour->tour_duration ?? '',
            $tour->price ?? '',
            $tour->two_person_share ?? '',
            $tour->three_person_share ?? '',
            $tour->special_discount ?? '',
            $tour->discount_status ?? 0,
            is_array($tour->day) ? json_encode($tour->day) : ($tour->day ?? ''),
            $tour->max_people ?? '',
            $tour->min_age ?? '',
            $tour->bedroom ?? '',
            $tour->friday_date ? (\Carbon\Carbon::parse($tour->friday_date)->format('Y-m-d')) : '',
            $tour->pickup ?? '',
            $tour->departure_time ? (\Carbon\Carbon::parse($tour->departure_time)->format('H:i')) : '',
            $tour->description ?? '',
            is_array($tour->what_to_expect) ? json_encode($tour->what_to_expect) : ($tour->what_to_expect ?? ''),
            is_array($tour->price_includes) ? json_encode($tour->price_includes) : ($tour->price_includes ?? ''),
            is_array($tour->departure_return_location) ? json_encode($tour->departure_return_location) : ($tour->departure_return_location ?? ''),
            is_array($tour->travel_plan) ? json_encode($tour->travel_plan) : ($tour->travel_plan ?? ''),
            $tour->status ? 'Active' : 'Inactive',
        ];
    }
}
