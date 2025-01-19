<table>
    <thead>
        <tr>
            <th style="font-weight: bold;">Order ID</th>
            <th style="font-weight: bold;">Customer</th>
            <th style="font-weight: bold;">Email</th>
            <th style="font-weight: bold;">Phone</th>
            <th style="font-weight: bold;">Status</th>
            <th style="font-weight: bold;">Total</th>
            <th style="font-weight: bold;">Date Purchased</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->name }}</td>
            <td>{{ $order->email }}</td>
            <td>{{ $order->mobile }}</td>
            <td>
                @if($order->delivery_status == 'pending')
                <span style="color: red;">Pending</span>
                @elseif($order->delivery_status == 'shipped')
                <span style="color: #17A2B8;">Shipped</span>
                @elseif($order->delivery_status == 'delivered')
                <span style="color: green;">Delivered</span>
                @else
                <span style="color: red;">Cancelled</span>
                @endif
            </td>
            <td>${{ number_format($order->grand_total,2) }}</td>
            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y')}}</td>
        </tr>
        @endforeach
    </tbody>
</table>