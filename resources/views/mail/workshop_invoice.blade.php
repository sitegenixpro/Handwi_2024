<!DOCTYPE html>
<html>
<head>
    <title>Workshop Invoice</title>
</head>
<body style="margin: 0; color: #000; background-color: #000; font-family: Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #000;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#fff;border-radius:10px;overflow:hidden;">
                    
                    <tr>
                        <td align="center" style="padding: 20px;">
                            <img src="{{ asset('admin-assets/assets/img/handwi-logo-blac.png') }}" alt="Logo" style="max-width: 190px;">
                            <h1 style="color: #000;">Workshop Booking Confirmation</h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px;">
                            <p style="font-size: 16px; color:#000;">Hi {{ $user->name }},</p>
                            <p style="font-size: 14px; color:#000;">Thank you for booking the workshop. Here are your details:</p>
                            
                            <h3 style="margin-top: 30px; color:#000;">Booking #: {{ $booking->order_number }}</h3>
                            <p><strong>Workshop:</strong> {{ $workshop->name ?? 'N/A' }}</p>
                            
                            <p><strong>Seats Booked:</strong> {{ $booking->number_of_seats }}</p>
                            <p><strong>Seat Numbers:</strong> {{ $booking->seat_no }}</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px;">
                            <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; font-size: 14px; color: #000;">
                                <thead>
                                    <tr style="background-color: #f2f2f2;">
                                        <th align="left">Item</th>
                                        <th align="center">Qty</th>
                                        <th align="right">Unit Price (AED)</th>
                                        <th align="right">Total (AED)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $workshop->name ?? 'Workshop' }}</td>
                                        <td align="center">{{ $booking->number_of_seats }}</td>
                                        <td align="right">{{ number_format($booking->price, 2) }}</td>
                                        <td align="right">{{ number_format($booking->price * $booking->number_of_seats, 2) }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" align="right"><strong>Subtotal:</strong></td>
                                        <td align="right">{{ number_format($booking->price * $booking->number_of_seats, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="right"><strong>Tax:</strong></td>
                                        <td align="right">{{ number_format($booking->tax, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="right"><strong>Grand Total:</strong></td>
                                        <td align="right"><strong>{{ number_format($booking->grand_total, 2) }} AED</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px;">
                            <p style="color: #000;">If you have any questions, feel free to contact us.</p>
                            <p style="color: #000;">Thank you for booking with {{ config('app.name') }}!</p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding: 20px; background-color: #eee;">
                            <p style="margin: 0; color: #000;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
