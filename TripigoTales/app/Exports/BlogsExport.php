<?php

namespace App\Exports;

use App\Models\Blog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BlogsExport implements FromCollection, WithHeadings, WithMapping
{
    protected bool $forArchive = false;

    public function __construct(bool $forArchive = false)
    {
        $this->forArchive = $forArchive;
    }

    public function collection()
    {
        return Blog::orderBy('id')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Image',
            'Description',
            'Author',
            'Published Date',
            'Status',
        ];
    }

    public function map($blog): array
    {
        $imagePath = $blog->image ?? '';
        if ($this->forArchive && $imagePath && file_exists(public_path($imagePath))) {
            $imagePath = 'media/' . $blog->id . '_' . basename($imagePath);
        }
        return [
            $blog->id,
            $blog->title,
            $imagePath,
            $blog->description ?? '',
            $blog->author ?? '',
            $blog->published_date ? $blog->published_date->format('Y-m-d') : '',
            $blog->status ? 'Active' : 'Inactive',
        ];
    }
}
