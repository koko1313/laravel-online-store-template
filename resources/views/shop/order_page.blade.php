@extends('layout.layout')

@section('title')
    Преглед на поръчка
@endsection

@section('content')

    <div class="container">

		<p>Поръчка номер: <em>{{$order->order_id}}</em></p>
		<p>Име: <em>{{$order->user_name}}</em></p>
		<p>Телефон: <em>{{$order->user_phone}}</em></p>
		<p>E-mail: <em>{{$order->user_email}}</em></p>
		<p>Статус на поръчката: <em>{{$order->status}}</em></p>

			<table class="table table-striped">
			<thead>
			<tr>
				<th scope="col">Продукт</th>
				<th scope="col">Количество</th>
				<th scope="col">Цена</th>
				<th scope="col">Действия</th>
			</tr>
			</thead>
			<tbody>
                @for($i=0; $i<sizeof($order->product_id_list); $i++)
                    <tr>
                        <td><a href="{{route('open.product', $order->product_id_list[$i])}}">{{$order->product_title_list[$i]}}</a></td>
                        <td>
                            <form method="POST" action="{{route('cart')}}">
                            <input type="hidden" name="product_id" value="{{$order->product_id_list[$i]}}">
                            <input type="hidden" name="order_id" value="{{$order->order_id}}">
                            <input type="number" name="quanity" size="2" min="1" value='{{$order->quanity_list[$i]}}'>
                            <button class="btn btn-link" type="submit" name="change_quanity">Промени</button>
                            {{csrf_field()}}
                            </form>
                        </td>
                        <td>{{$order->total_price_list[$i]}} лв</td>
                        <td><a onClick="return confirm('Изтриване?')" href="{{route('order.remove.product', [$order->order_id, $order->product_id_list[$i]])}}">Премахни</a></td>
                    </tr>
                @endfor
                <tr>
                    <td></td>
                    <td style="text-align: right"><strong>Общо</strong></td>
                    <td><strong>{{$order->grand_total_price}} лв</strong></td>
                    <td></td>
                </tr>

			</tbody>
			</table>
			<a href="{{route('manage_orders')}}">Назад</a> |
			@if($order->status == 'processing')
			<a href="{{route('finish.order', $order->order_id)}}">Завършена</a>
			@else
            <a href="{{route('restore.order', $order->order_id)}}">Възстанови</a>
			@endif

    </div>

@endsection