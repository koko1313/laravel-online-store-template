@extends('layout.layout')

@section('title')
    Количка
@endsection

@section('content')

    <div class="container">

    @include('messages')

	@if(isset($cart))
		<table class="table table-striped">
		<thead>
		<tr>
			<th scope="col">Продукт</th>
			<th scope="col">Единична цена</th>
			<th scope="col">Количество</th>
			<th scope="col">Цена</th>
			<th scope="col">Действия</th>
		</tr>
		</thead>
		<tbody>
			@for($i=0; $i<sizeof($cart->product_id_list); $i++)
				<tr>
					<td><a href="{{route('open.product', $cart->product_id_list[$i])}}">{{$cart->product_title_list[$i]}}</a></td>
					<td>{{$cart->product_price_list[$i]}} лв</td>
					<td>
						<form method="POST">
						<input type="hidden" name="product_id" value="{{$cart->product_id_list[$i]}}">
						<input type="number" name="quanity" size="2" min="1" value="{{$cart->product_quanity_list[$i]}}">
						<button class="btn btn-link" type="submit" name="change_quanity">Промени</button>
						{{csrf_field()}}
						</form>
					</td>
					<td>{{$cart->product_total_price_list[$i]}} лв</td>
					<td><a href="{{route('cart.remove.product', $cart->product_id_list[$i])}}">Премахни</a></td>
				</tr>
			@endfor

			<tr>
				<td></td>
				<td></td>
				<td style="text-align: right"><strong>Общо</strong></td>
				<td><strong>{{$cart->grand_total_price}} лв</strong></td>
				<td></td>
			</tr>
		</tbody>
		</table>

		<a href="{{route('make.order')}}" class="btn btn-primary">Поръчай</a>
	@else
		<p>Нямате продукти в количката</p>
	@endif

    </div>

@endsection