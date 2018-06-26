	@extends('layouts.frontend.master')
	@section('content')
	<!-- Products -->
	<section class="chart-page padding-top-100 padding-bottom-100">
		<div class="container"> 
			
			<!-- Payments Steps -->
			<div class="shopping-cart"> 
				
				<!-- SHOPPING INFORMATION -->
				<div class="cart-ship-info">
					<div class="row"> 
						<!-- ESTIMATE SHIPPING & TAX -->
						<div class="col-lg-12">
							<h4>Your order has been received</h4>
							<hr>
							<p style="font-weight: bold; color: #E25203; font-size: 16px;">Thank you for your purchase!</p>
							<p>Your order # is: {{$orderId}}</p>
							<p>Order Date: {{Carbon\Carbon::parse($orderInfo[0]->order_day)->format('F jS, Y')}}</p>
							<hr>
							<h6>Shipping Address</h6>
							<p>Name: {{$orderInfo[0]->customerName}}</p>
							<p>Phone: {{$orderInfo[0]->phone}}</p>
							<p>Email: {{$orderInfo[0]->email}}</p>
							<p>Address: {{$orderInfo[0]->address}}</p>
							<hr>
						</div>
						<!-- SUB TOTAL -->
						<div class="col-lg-12">
							<h6>ITEM ORDERED</h6>
							<div class="order-place" style="padding-bottom: 0 !important;">
								<div class="order-detail">
									@foreach ($orderInfo as $item)
										<p>{{$item->pQty}} x {{$item->pName}} <span>${{$item->pPrice}} </span></p>
									@endforeach
									<!-- SUB TOTAL -->
									<p class="all-total">TOTAL COST <span> ${{$orderInfo[0]->total}}</span></p>
								</div>
							</div>
							<hr>
						</div>
						<div class="col-lg-12">
							<a href="{{route('products')}}" class="btn">Continue shopping</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		</section>


	@stop