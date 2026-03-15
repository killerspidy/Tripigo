<?php
foreach (\App\Models\Category::whereNull('slug')->orWhere('slug', '')->get() as $c) {
    if (!$c->name) {
        $c->name = 'Category ' . $c->id;
    }
    $c->slug = \Illuminate\Support\Str::slug($c->name) . '-' . $c->id;
    $c->save();
}
echo 'Fixed missing slugs.';
