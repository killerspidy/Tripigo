<x-mail::message>
# New Booking Alert

A new booking has been successfully paid and confirmed on the website.

<x-mail::table>
| Field | Details |
| :--- | :--- |
| **Booking ID** | #{{ $booking->id }} |
| **Customer** | {{ $booking->user->name ?? 'N/A' }} ({{ $booking->user->email ?? 'N/A' }}) |
| **Tour** | {{ $booking->tour->title }} |
| **Amount** | ₹{{ number_format($booking->total_amount, 2) }} |
| **Razorpay ID**| {{ $booking->razorpay_payment_id }} |
</x-mail::table>

<x-mail::button :url="url('/admin/bookings/' . $booking->id)">
View in Admin Panel
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
