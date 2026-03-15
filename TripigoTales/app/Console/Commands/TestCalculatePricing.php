<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tour;
use Illuminate\Http\Request;

class TestCalculatePricing extends Command
{
    protected $signature = 'test:pricing';
    protected $description = 'Test the calculatePricing endpoint logic';

    public function handle()
    {
        $tour = Tour::first();
        if (!$tour) {
            $this->error('No tour found');
            return;
        }

        $controller = app('App\Http\Controllers\PaymentController');
        $request = new Request([
            'tour_id' => $tour->id,
            'persons' => 2,
            'addons' => [],
            'coupon' => null
        ]);
        
        $response = $controller->calculatePrice($request);
        $this->info($response->getContent());
    }
}
