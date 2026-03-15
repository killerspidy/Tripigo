@extends('admin.layouts.app')

@section('title', 'Booking Management')

@push('styles')
<style>
/* ─── Stat Cards ────────────────────────────── */
.stat-card {
    border:none; border-radius:14px; overflow:hidden;
    box-shadow:0 4px 16px rgba(0,0,0,.08); margin-bottom:0;
}
.stat-card .card-body { padding:20px 24px; }
.stat-card .stat-icon {
    width:48px; height:48px; border-radius:12px;
    display:flex; align-items:center; justify-content:center;
    font-size:20px; flex-shrink:0; background:rgba(255,255,255,.25);
}
.stat-card .stat-value { font-size:26px; font-weight:800; color:#fff; line-height:1.1; }
.stat-card .stat-label { font-size:12px; color:rgba(255,255,255,.8); font-weight:500; margin-top:2px; }

/* ─── Table ──────────────────────────────────── */
.bookings-table th {
    font-size:11px; font-weight:700; color:#6b7280;
    text-transform:uppercase; letter-spacing:.5px;
    background:#f9fafb; border-top:none; white-space:nowrap;
}
.bookings-table td { vertical-align:middle; font-size:13px; }
.bookings-table tbody tr:hover { background:#fafbff; }

/* ─── Status Badges ─────────────────────────── */
.s-badge {
    display:inline-block; padding:3px 10px; border-radius:20px;
    font-size:11px; font-weight:700; letter-spacing:.4px;
}
.s-paid     { background:#d4edda; color:#1a7a3c; }
.s-pending  { background:#fff3cd; color:#856404; }
.s-failed   { background:#f8d7da; color:#842029; }
.s-cancelled{ background:#e2e3e5; color:#495057; }
.s-refunded { background:#cff4fc; color:#055160; }

/* ─── Filters Bar ────────────────────────────── */
.filters-bar { background:#f9fafb; border-radius:10px; padding:14px 18px; margin-bottom:20px; }
</style>
@endpush

@section('content')
<div class="container-fluid pb-5">

    {{-- Page Title --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-0 fw-bold">Booking Management</h4>
            <small class="text-muted">All customer tour bookings in one place.</small>
        </div>
    </div>

    {{-- ══ Stat Cards ════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card card" style="background:linear-gradient(135deg,#4e73df,#2e59d9);">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon">🎟️</div>
                    <div>
                        <div class="stat-value">{{ $stats['total'] }}</div>
                        <div class="stat-label">Total Bookings</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card card" style="background:linear-gradient(135deg,#1cc88a,#17a673);">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon">✅</div>
                    <div>
                        <div class="stat-value">{{ $stats['paid'] }}</div>
                        <div class="stat-label">Paid</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card card" style="background:linear-gradient(135deg,#f6c23e,#dda20a);">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon">⏳</div>
                    <div>
                        <div class="stat-value">{{ $stats['pending'] }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card card" style="background:linear-gradient(135deg,#36b9cc,#258391);">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon">💰</div>
                    <div>
                        <div class="stat-value" style="font-size:20px;">₹{{ number_format($stats['revenue'], 0) }}</div>
                        <div class="stat-label">Total Revenue</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ Main Card ══════════════════════════════════════════════ --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 mb-4">
                <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-dismiss="alert"></button>
            </div>
            @endif

            {{-- Filters --}}
            <div class="filters-bar">
                <form method="GET" action="{{ route('admin.bookings.index') }}">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-5">
                            <input type="text" name="search" class="form-control form-control-sm"
                                   placeholder="🔍  Search by ID, name, email, Razorpay ID, tour…"
                                   value="{{ request('search') }}" style="border-radius:8px;">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control form-control-sm" style="border-radius:8px;">
                                <option value="">All Statuses</option>
                                @foreach(['paid','pending','failed','cancelled','refunded'] as $s)
                                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-sm w-100" style="border-radius:8px;">Filter</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm w-100" style="border-radius:8px;">Reset</a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table bookings-table mb-0">
                    <thead>
                        <tr>
                            <th style="width:60px;">#</th>
                            <th>Tour</th>
                            <th>Contact</th>
                            <th>Travel Date</th>
                            <th class="text-center">Persons</th>
                            <th class="text-end">Amount</th>
                            <th class="text-center">Status</th>
                            <th>Booked On</th>
                            <th class="text-center" style="width:120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        @php
                            $trav = $booking->travelers->first();
                            $name  = $trav->name  ?? ($booking->user->name  ?? 'Guest');
                            $phone = $trav->phone ?? ($booking->user->phone ?? null);
                            $email = $trav->email ?? ($booking->user->email ?? null);
                        @endphp
                        <tr>
                            <td class="text-muted fw-semibold">#{{ $booking->id }}</td>
                            <td>
                                <div class="fw-semibold" style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $booking->tour->title ?? '<span class="text-muted">Deleted Tour</span>' }}
                                </div>
                                <small class="text-muted">{{ $booking->tour->location ?? '' }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $name }}</div>
                                @if($phone)<small class="text-muted d-block">📞 {{ $phone }}</small>@endif
                                @if($email)<small class="text-muted d-block">✉ {{ $email }}</small>@endif
                            </td>
                            <td>
                                <div>{{ $booking->from_date?->format('d M Y') ?? '—' }}</div>
                                @if($booking->to_date)
                                    <small class="text-muted">→ {{ $booking->to_date->format('d M Y') }}</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="fw-semibold">{{ $booking->persons }}</span>
                                @if($booking->travelers->count() > 0)
                                    <span class="d-block" title="{{ $booking->travelers->count() }} traveller details saved"
                                          style="font-size:10px;color:#4e73df;">
                                        👥 {{ $booking->travelers->count() }} details
                                    </span>
                                @endif
                            </td>
                            <td class="text-end fw-bold">₹{{ number_format($booking->total_amount, 2) }}</td>
                            <td class="text-center">
                                @php
                                    $sc = match($booking->status) {
                                        'paid'      => 's-paid',
                                        'pending'   => 's-pending',
                                        'failed'    => 's-failed',
                                        'cancelled' => 's-cancelled',
                                        'refunded'  => 's-refunded',
                                        default     => 's-cancelled',
                                    };
                                @endphp
                                <span class="s-badge {{ $sc }}">{{ ucfirst($booking->status) }}</span>
                            </td>
                            <td>
                                <div style="font-size:12px;">{{ $booking->created_at->format('d M Y') }}</div>
                                <small class="text-muted">{{ $booking->created_at->format('h:i A') }}</small>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.bookings.show', $booking->slug) }}"
                                       class="btn btn-sm btn-outline-primary" title="View Details"
                                       style="border-radius:6px;padding:4px 10px;">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.bookings.destroy', $booking->slug) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                title="Delete" style="border-radius:6px;padding:4px 10px;"
                                                onclick="return confirm('Delete Booking #{{ $booking->id }}?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fa fa-inbox fa-2x mb-2 d-block"></i>
                                No bookings found matching your filters.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3 px-1">
                <small class="text-muted">
                    Showing {{ $bookings->firstItem() }}–{{ $bookings->lastItem() }} of {{ $bookings->total() }} bookings
                </small>
                {{ $bookings->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
