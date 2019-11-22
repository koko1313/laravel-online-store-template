@extends('layout.layout')

@section('title')
    Поръчка
@endsection

@section('content')

    <div class="container">

        @include('messages')

        @if(isset($cart))
        <form id="form" method="POST">
            <div id="tabs">
                <ul>
                    <li><a href="#products-tab">Продукти</a></li>
                    <li><a class="disabled" href="#delivery-tab">Данни за доставка</a></li>
                    <li><a href="#final-tab" onClick="goToFinalTab()">Финализиране на поръчката</a></li>
                </ul>
                <div id="products-tab">
					<table class="table table-striped">
					<thead>
					<tr>
						<th scope="col">Продукт</th>
						<th scope="col">Единична цена</th>
						<th scope="col">Брой</th>
						<th scope="col">Цена</th>
					</tr>
					</thead>
					<tbody>
                            @for($i=0; $i<sizeof($cart->product_id_list); $i++)
                            <tr>
                                <td>{{$cart->product_title_list[$i]}}</td>
                                <td>{{$cart->product_price_list[$i]}}</td>
                                <td>{{$cart->product_quanity_list[$i]}}</td>
                                <td>{{$cart->product_total_price_list[$i]}}</td>
                            </tr>
                            @endfor

						<td></td>
						<td></td>
						<td><strong>Общо</strong></td>
						<td><strong>{{$cart->grand_total_price}}</strong></td>
					</tbody>
					</table>

                    <button class="btn" type="button" onClick="location.href='{{route('cart')}}'">Назад към количка</button>
                    <button class="btn btn-primary" type="button" onClick="goToDeliveryTab()">Продължи</button>
                </div>
                <div id="delivery-tab">
                    <div class="form-group">
                        <label for="first_name">Име<font color="red">*</font></label>
                        <input class="form-control" type="text" name="first_name" id="first_name" value="{{Auth::user()->first_name}}">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Фамилия<font color="red">*</font></label>
                        <input class="form-control" type="text" name="last_name" id="last_name" value="{{Auth::user()->last_name}}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Телефон<font color="red">*</font></label>
                        <input class="form-control" type="number" name="phone" id="phone" value="{{Auth::user()->phone}}">
                    </div>
                    <div class="form-group">
                        <label for="address">Адрес за доставка<font color="red">*</font></label>
                        <textarea class="form-control" name="address" id="address">{{Auth::user()->address}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="additional_information">Допълнителна информация</label>
                        <textarea class="form-control" name="additional_information" id="additional_information"></textarea>
                    </div>

                    <button class="btn btn-primary" type="button" onClick="goToFinalTab();" id="delivery-tab-button" disabled>Продължи</button>
                </div>
                <div id="final-tab">
                    <p>Име: <em><span id="final_info_first_name"></span> <span id="final_info_last_name"></span></em></p>
                    <p>Телефон: <em><span id="final_info_phone"></span></em></p>
                    <p>Адрес: <em><span id="final_info_address"></span></em></p>
                    <p>Допълнителна информация: <em><span id="final_info_additional_information"></span></em></p>
                    <p><strong>Цена: {{$cart->grand_total_price}}</strong></p>

                    <button class="btn btn-primary" type="submit" id="make_order_button" disabled>Поръчай</button>
                </div>
            </div>
            {{csrf_field()}}
        </form>
        @endif

    </div>

    <script>
        $("#tabs").tabs({disabled: [1,2]});

        function goToDeliveryTab() {
            $("#tabs").tabs("enable", 1);
            $("#tabs").tabs({active: 1});
            validate();
        }

        function goToFinalTab() {
            $("#tabs").tabs("enable", 2);
            $("#tabs").tabs({active: 2});
            var first_name = $("#first_name").val();
            var last_name = $("#last_name").val();
            var phone = $("#phone").val();
            var address = $("#address").val();
            var additional_information = $("#additional_information").val();

            $("#final_info_first_name").html($("#first_name").val());
            $("#final_info_last_name").html($("#last_name").val());
            $("#final_info_phone").html($("#phone").val());
            $("#final_info_address").html($("#address").val());
            $("#final_info_additional_information").html($("#additional_information").val());
        }

        $("#form").keyup(function() {
            validate();
        });

        function validate() {
            if (
                $("#first_name").val().trim() != "" &&
                $("#last_name").val().trim() != "" &&
                $("#phone").val().trim() != "" &&
                $("#address").val().trim() != ""
            ) {
                $("#delivery-tab-button").prop("disabled", false);
                $("#make_order_button").prop("disabled", false);
            } else {
                $("#delivery-tab-button").prop("disabled", true);
                $("#make_order_button").prop("disabled", true);
            }
        }
    </script>

@endsection