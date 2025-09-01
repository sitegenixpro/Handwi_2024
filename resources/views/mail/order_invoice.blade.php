<!DOCTYPE html>
<html>
<head>
    <title>Order Invoice</title>
</head>
<body style="margin: 0; color: #000; background-color: #000; font-family: Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #000;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#fff;border-radius:10px;overflow:hidden;">
                    
                    <tr>
                        <td align="center" style="padding: 20px;">
                            <img src="{{ asset('admin-assets/assets/img/handwi-logo-blac.png') }}" alt="Logo" style="max-width: 190px;">
                            <h1 style="color: #000;">Order Confirmation</h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px;">
                            <p style="font-size: 16px; color:#000;">Hi {{ $user->name }},</p>
                            <p style="font-size: 14px; color:#000;">Thank you for your order. Below are your order details.</p>
                            
                            <h3 style="margin-top: 30px; color:#000;">Order #: {{ $order->order_number }}</h3>
                            <p><strong>Pickup Date:</strong> {{ \Carbon\Carbon::parse($order->pick_up_date)->format('d M Y') }}</p>
                            <p><strong>Pickup Time:</strong> {{ $order->pick_up_time }}</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px;">
                            <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; font-size: 14px; color: #000;">
                                <thead>
                                    <tr style="background-color: #f2f2f2;">
                                        <th align="left">Product</th>
                                        <th align="center">Qty</th>
                                        <th align="right">Price</th>
                                        <th align="right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orderProducts as $item)
                                        <tr>
                                            <td>{{ $item->product->product_name ?? 'N/A' }}</td>
                                            <td align="center">{{ $item->quantity }}</td>
                                            <td align="right">AED {{ number_format($item->price, 2) }}</td>
                                            <td align="right">AED {{ number_format($item->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" align="right"><strong>Subtotal:</strong></td>
                                        <td align="right">AED {{ number_format($order->total, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="right"><strong>Tax:</strong></td>
                                        <td align="right">AED {{ number_format($order->vat, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="right"><strong>Shipping:</strong></td>
                                        <td align="right">AED {{ number_format($order->shipping_charge, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="right"><strong>Grand Total:</strong></td>
                                        <td align="right"><strong>AED {{ number_format($order->grand_total, 2) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px;">
                            <p style="color: #000;">If you have any questions, feel free to contact our support team.</p>
                            <p style="color: #000;">Thank you for shopping with {{ config('app.name') }}!</p>
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
