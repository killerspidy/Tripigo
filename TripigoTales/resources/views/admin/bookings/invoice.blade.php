<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $booking->slug }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            background: #fff;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 40px;
        }

        .header-left {
            display: table-cell;
            vertical-align: top;
        }

        .header-right {
            display: table-cell;
            text-align: right;
            vertical-align: top;
        }

        .logo {
            width: 150px;
            margin-bottom: 10px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #029e9d;
        }

        .invoice-title {
            font-size: 32px;
            margin: 0;
            color: #17233e;
        }

        .invoice-info {
            margin-top: 10px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            border-bottom: 2px solid #029e9d;
            padding-bottom: 5px;
            margin-bottom: 15px;
            color: #17233e;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table th, .details-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .details-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #17233e;
        }

        .totals {
            width: 100%;
            margin-top: 20px;
        }

        .total-row {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }

        .total-label {
            display: table-cell;
            text-align: right;
            padding-right: 20px;
            font-weight: bold;
        }

        .total-value {
            display: table-cell;
            text-align: right;
            width: 120px;
        }

        .grand-total {
            background: #029e9d;
            color: #fff;
            padding: 10px;
            margin-top: 10px;
            font-size: 20px;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        @media print {
            .invoice-box {
                box-shadow: none;
                border: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <div class="header-left">
                <img src="{{ public_path('images/logo.png') }}" alt="Tripigo Tales" class="logo">
                <div class="company-name">{{ $company['name'] }}</div>
                <div>{{ $company['address'] }}</div>
                <div>Contact: {{ $company['contact'] }}</div>
                <div>Email: {{ $company['email'] }}</div>
                @if(!empty($company['gstin']))
                    <div>GSTIN: {{ $company['gstin'] }}</div>
                @endif
            </div>
            <div class="header-right">
                <h1 class="invoice-title">INVOICE</h1>
                <div class="invoice-info">
                    <div><strong>Invoice No:</strong> {{ $booking->slug }}</div>
                    <div><strong>Date:</strong> {{ $booking->created_at->format('d M Y') }}</div>
                    <div><strong>Booking ID:</strong> #{{ $booking->id }}</div>
                    <div><strong>Status:</strong> {{ strtoupper($booking->status) }}</div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Customer Details</div>
            <table class="details-table">
                <tr>
                    <td width="50%">
                        <strong>Name:</strong> {{ $booking->user->name ?? 'Guest User' }}<br>
                        <strong>Email:</strong> {{ $booking->user->email ?? 'N/A' }}<br>
                        <strong>Phone:</strong> {{ $booking->user->phone ?? 'N/A' }}
                    </td>
                    <td width="50%">
                        <strong>Tour:</strong> {{ $booking->tour->title ?? 'Deleted Tour' }}<br>
                        <strong>Travel Date:</strong> {{ $booking->from_date ? $booking->from_date->format('d M Y') : 'N/A' }} to {{ $booking->to_date ? $booking->to_date->format('d M Y') : 'N/A' }}<br>
                        <strong>Duration:</strong> {{ $booking->days ?? 'N/A' }} Days
                    </td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Booking Summary</div>
            <table class="details-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Qty/Persons</th>
                        <th>Price/Rate</th>
                        <th style="text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>{{ $booking->tour->title ?? 'Deleted Tour' }}</strong><br>
                            <small>Base Package</small>
                        </td>
                        <td>{{ $booking->persons }}</td>
                        <td>&#8377;{{ number_format($booking->price_per_person, 2) }}</td>
                        <td style="text-align: right;">&#8377;{{ number_format($booking->subtotal, 2) }}</td>
                    </tr>
                    @foreach($booking->bookingAddons as $bookingAddon)
                        <tr>
                            <td>{{ $bookingAddon->addon->name }}</td>
                            <td>-</td>
                            <td>&#8377;{{ number_format($bookingAddon->price, 2) }}</td>
                            <td style="text-align: right;">&#8377;{{ number_format($bookingAddon->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals">
            <div class="total-row">
                <div class="total-label">Subtotal:</div>
                <div class="total-value">&#8377;{{ number_format($booking->subtotal + $booking->addons_amount, 2) }}</div>
            </div>
            @if($booking->discount_amount > 0)
                <div class="total-row">
                    <div class="total-label">Discount:</div>
                    <div class="total-value">-&#8377;{{ number_format($booking->discount_amount, 2) }}</div>
                </div>
            @endif
            @if($booking->gst_amount > 0)
                <div class="total-row">
                    <div class="total-label">GST:</div>
                    <div class="total-value">&#8377;{{ number_format($booking->gst_amount, 2) }}</div>
                </div>
            @endif
            <div class="total-row grand-total">
                <div class="total-label" style="color: #fff;">Grand Total:</div>
                <div class="total-value" style="color: #fff;">&#8377;{{ number_format($booking->total_amount, 2) }}</div>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for choosing Tripigo Tales for your travel experiences!</p>
            <p>This is a computer-generated invoice and does not require a physical signature.</p>
            <p>&copy; {{ date('Y') }} Tripigo Tales. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
