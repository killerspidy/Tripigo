<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourBooking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Generate and download the invoice PDF.
     */
    public function download($slug)
    {
        $booking = TourBooking::with([
            'tour',
            'user',
            'travelers',
            'bookingAddons.addon',
            'coupon',
        ])->where('slug', $slug)->firstOrFail();

        // Pass data to the view
        $data = [
            'booking' => $booking,
            'company' => [
                'name'    => 'Tripigo Tales',
                'address' => 'Pune, Maharashtra',
                'contact' => '+91 7743963339',
                'email'   => 'info@tripigotales.com',
                'gstin'   => '27XXXXXXXXXXXXX', // Placeholder GSTIN
            ]
        ];

        // Load thermal/invoice view and generate PDF
        $pdf = Pdf::loadView('admin.bookings.invoice', $data);

        // Download the PDF
        return $pdf->download("invoice-{$booking->slug}.pdf");
    }
}
