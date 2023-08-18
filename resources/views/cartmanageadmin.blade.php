<h1>Order List</h1>

    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Book Name</th>
                <th>Author Name</th>
                <th>Price</th>
                <th>File Path</th>
                <th>Count</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($groupedOrders as $user => $orders)
                <tr>
                    <td rowspan="{{ count($orders) }}">{{ $user }}</td>
                    <td>{{ $orders[0]->Book_Name }}</td>
                    <td>{{ $orders[0]->Author_Name }}</td>
                    <td>{{ $orders[0]->Price }}</td>
                    <td>{{ $orders[0]->file_path }}</td>
                    <td>{{ $orders[0]->count }}</td>
                    
                </tr>
                @foreach ($orders->slice(1) as $order)
                    <tr>
                        <td>{{ $order->Book_Name }}</td>
                        <td>{{ $order->Author_Name }}</td>
                        <td>{{ $order->Price }}</td>
                        <td>{{ $order->file_path }}</td>
                        <td>{{ $order->count }}</td>
                    </tr>
                @endforeach
                <td><a href="" class = "btn btn-sm btn-success">Confirm</a></td>
            @endforeach
        </tbody>
    </table>