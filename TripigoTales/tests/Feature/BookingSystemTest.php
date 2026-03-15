<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingSystemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_cannot_cancel_within_24_hours()
    {
        $user = \App\Models\User::factory()->create();
        $tour = \App\Models\Tour::create([
            'title' => 'Test Tour',
            'price' => 1000,
            'status' => true
        ]);

        // Booking starting in 12 hours
        $booking = \App\Models\TourBooking::create([
            'user_id' => $user->id,
            'tour_id' => $tour->id,
            'from_date' => now()->addHours(12),
            'status' => 'paid',
            'total_amount' => 1000,
            'persons' => 1,
            'price_per_person' => 1000
        ]);

        $this->assertFalse($booking->canBeCancelled());
        $this->assertStringContainsString('no longer eligible', $booking->getRefundEligibilityText());

        $this->actingAs($user, 'user')
            ->post("/user/booking/{$booking->id}/cancel", ['cancellation_reason' => 'Too late'])
            ->assertRedirect()
            ->assertSessionHas('error');
        
        $this->assertEquals('paid', $booking->fresh()->status);
    }

    /** @test */
    public function test_user_can_cancel_before_24_hours()
    {
        $user = \App\Models\User::factory()->create();
        $tour = \App\Models\Tour::create([
            'title' => 'Test Tour',
            'price' => 1000,
            'status' => true
        ]);

        // Booking starting in 48 hours
        $booking = \App\Models\TourBooking::create([
            'user_id' => $user->id,
            'tour_id' => $tour->id,
            'from_date' => now()->addHours(48),
            'status' => 'paid',
            'total_amount' => 1000,
            'persons' => 1,
            'price_per_person' => 1000
        ]);

        $this->assertTrue($booking->canBeCancelled());
        $this->assertStringContainsString('eligible for a refund', $booking->getRefundEligibilityText());

        $this->actingAs($user, 'user')
            ->post("/user/booking/{$booking->id}/cancel", ['cancellation_reason' => 'Change of plans'])
            ->assertRedirect();
        
        $this->assertEquals('awaiting_refund', $booking->fresh()->status);
        $this->assertDatabaseHas('booking_audits', [
            'tour_booking_id' => $booking->id,
            'action' => 'user_cancellation',
            'new_value' => 'awaiting_refund'
        ]);
    }

    /** @test */
    public function test_audit_log_created_on_admin_status_update()
    {
        $admin = \App\Models\User::factory()->create(['is_admin' => 1]); // Assuming 1 is admin
        $booking = \App\Models\TourBooking::factory()->create(['status' => 'pending']);

        $this->actingAs($admin)
            ->post("/admin/bookings/{$booking->id}/status", ['status' => 'paid'])
            ->assertRedirect();

        $this->assertDatabaseHas('booking_audits', [
            'tour_booking_id' => $booking->id,
            'action' => 'admin_status_update',
            'old_value' => 'pending',
            'new_value' => 'paid'
        ]);
    }
}
