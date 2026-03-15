<?php

namespace App\Imports;

use App\Models\Blog;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BlogsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected ?string $mediaBasePath = null;

    public function __construct(?string $mediaBasePath = null)
    {
        $this->mediaBasePath = $mediaBasePath;
    }

    public function model(array $row)
    {
        $imagePath = $row['image'] ?? null;
        if ($this->mediaBasePath && $imagePath && trim($imagePath) !== '') {
            $fullPath = $this->mediaBasePath . '/' . ltrim($imagePath, '/\\');
            if (file_exists($fullPath) && is_file($fullPath)) {
                $targetDir = public_path('uploads/blogs');
                File::ensureDirectoryExists($targetDir);
                $name = time() . '_' . uniqid() . '_' . basename($fullPath);
                $destPath = 'uploads/blogs/' . $name;
                if (copy($fullPath, public_path($destPath))) {
                    $imagePath = $destPath;
                }
            } else {
                $imagePath = null;
            }
        }
        return new Blog([
            'title'       => $row['title'] ?? '',
            'image'       => $imagePath,
            'description' => $row['description'] ?? null,
            'author'      => $row['author'] ?? null,
            'published_date' => !empty($row['published_date']) ? $row['published_date'] : null,
            'status'      => isset($row['status']) && (strtolower($row['status']) === 'active' || $row['status'] === 1) ? 1 : 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
        ];
    }
}
