<x-mail::message>
# Booking Confirmed!

Hello {{ $booking->user->name ?? 'Traveller' }},

Thank you for booking with **Tripigo Tales**. Your booking for **{{ $booking->tour->title }}** has been successfully confirmed.

<x-mail::panel>
**Booking Details:**
- **Booking ID:** #{{ $booking->id }}
- **Tour:** {{ $booking->tour->title }}
- **Dates:** {{ $booking->from_date->format('d M Y') }} to {{ $booking->to_date->format('d M Y') }}
- **Persons:** {{ $booking->persons }}
- **Total Amount Paid:** ₹{{ number_format($booking->total_amount, 2) }}
</x-mail::panel>

You can view your full booking details and download your invoice by clicking the button below:

<x-mail::button :url="route('frontend.booking.success', $booking->slug)">
View Booking Details
</x-mail::button>

If you have any questions, feel free to contact us at info@tripigotales.com or call us at +91 7743963339.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
