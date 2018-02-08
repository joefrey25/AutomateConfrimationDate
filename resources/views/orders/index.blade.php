@extends('main')

@section('content')
    <div class="container">
        <table class="table table-striped">
            <thead>
                <th>Order #</th>
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Billing Address</th>
                <th colspan="2">Action</th>
            </thead>
            <tbody>
                
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->products }}</td>
                        <td>{{ $order->total_quantity }}</td>
                        <td>{{ $order->total_price }}</td>
                        <td>{{ $order->billing_address }}</td>
                        <td>
                            <form action="/orders/confirm" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{ $order->id }}" name="order_id">
                                <button class="btn btn-success confirm" data-order-id="{{ $order->id }}" {{ (is_null($order->confirmation_date))? '' : 'disabled' }} >Confirm</button>
                            </form>
                        </td>
                        <td>
                            <form action="/orders/confirmDelivery" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{ $order->id }}" name="order_id">
                                <button class="btn btn-danger deliver" {{ (is_null($order->delivery_date))? '' : 'disabled' }} >Deliver</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if (Session::has('err_message'))
        <div class="alert alert-danger">
            { !!Session::get('err_message')!! }
        </div>
    @endif
@endsection