@extends('layout.layout')

@section('title')
    Управление на поръчки
@endsection

@section('content')

    <div class="container">

        <div id="order-tabs">
            <ul>
                <li><a href="#awaiting-delivery-tab">Очакват обработка</a></li>
                <li><a href="#finished-tab">Завършени</a></li>
            </ul>
            <div id="awaiting-delivery-tab">

				<table class="table table-striped">
				<thead>
				<tr>
					<th scope="col">Поръчка</th>
					<th scope="col">Клиент</th>
					<th scope="col">Телефон</th>
					<th scope="col">E-mail</th>
					<th scope="col">Действия</th>
				</tr>
				</thead>
				<tbody>
                    @foreach($processing_orders as $order)
					<tr>
						<td>{{$order->order_id}}</td>
						<td>{{$order->user_name}}</td>
						<td>{{$order->user_phone}}</td>
						<td>{{$order->user_email}}</td>
						<td>
							<a href="{{route('view.order', $order->order_id)}}">Прегледай</a> |
							<a href="{{route('finish.order', $order->order_id)}}">Завършена</a> |
							<a onClick="return confirm('Изтриване на поръчката?')" href="{{route('delete.order', $order->order_id)}}">Нулиране</a>
						</td>
					</tr>
                    @endforeach
				</tbody>
				</table>

            </div>
            <div id="finished-tab">

				<table class="table table-striped">
				<thead>
				<tr>
					<th scope="col">Поръчка</th>
					<th scope="col">Клиент</th>
					<th scope="col">Телефон</th>
					<th scope="col">E-mail</th>
					<th scope="col">Действия</th>
				</tr>
				</thead>
				<tbody>
					@foreach($finished_orders as $order)
					<tr>
						<td>{{$order->order_id}}</td>
						<td>{{$order->user_name}}</td>
						<td>{{$order->user_phone}}</td>
						<td>{{$order->user_email}}</td>
						<td>
							<a href="{{route('view.order', $order->order_id)}}">Прегледай</a> |
							<a href="{{route('restore.order', $order->order_id)}}">Възстанови</a> |
							<a onClick="return confirm('Изтриване на поръчката?')" href="{{route('delete.order', $order->order_id)}}">Нулиране</a>
						</td>
					</tr>
					@endforeach
				</tbody>
				</table>

            </div>
        </div>

        <script>$("#order-tabs").tabs()</script>

    </div>

@endsection