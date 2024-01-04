<div class="order-box dashboard-bg-box col-12">
	<!-- <a href="{{route('order', ['hash'=>$order->hash])}}" class="order-box-link"> -->
		<div class="order-container">
			<div class="order-icon">
				<i data-feather="box"></i>
			</div>

			<div class="order-detail">
				@if($order->status == 'processing')
				<h4>Delivere  <span>Panding</span></h4>
				@elseif($order->status == 'shipping')
				<h4>Delivere  <span>Shipping</span></h4>
				@elseif($order->status == 'success')
				<h4>Delivered  <span class="success-bg">Success</span></h4>
				@elseif($order->status == 'canceled')
				<h4>Delivere  <span>Cancelled</span></h4>
				@endif
			</div>
		</div>

		<div class="product-order-detail">
			<div class="order-wrap">
				<ul class="product-size">
					<li>
						<div class="size-box">
							<h6 class="text-content">Order ID: </h6>
							<h5>{{$order->sku}}</h5>
						</div>
					</li>
					<li>
						<div class="size-box">
							<h6 class="text-content">Created at: </h6>
							<h5>{{ date('d M, Y h:i A', strtotime($order->created_at)) }}</h5>
						</div>
					</li>
					<li>
						<div class="size-box">
							<h6 class="text-content">Delivary address: </h6>
							<h5>{{$order->address}}</h5>
						</div>
					</li>
					@if(isset($order->notes))
					<li>
						<div class="size-box">
							<h6 class="text-content">Notes: </h6>
							<h5>{{$order->notes}}</h5>
						</div>
					</li>
					@endif
					<li>
						<div class="size-box">
							<h6 class="text-content">Items quantity: </h6>
							<h5>{{$order->qty}}</h5>
						</div>
					</li>
					<li>
						<div class="size-box">
							<h6 class="text-content">Payment Method: </h6>
							<h5 style="text-transform: capitalize;">{{$order->payment_method}}</h5>
						</div>
					</li>
					<li>
						<div class="size-box">
							<h6 class="text-content">Price : </h6>
							<h5>${{$order->total}}</h5>
						</div>
					</li>
					<li>
						<button onclick="location.href = '{{route("order", ["hash" => $order->hash])}}';" class="btn theme-bg-color text-white btn-sm fw-bold mt-3 ">View order
						</button>
					</li>
				</ul>
			</div>
			
		</div>
	<!-- </a> -->
</div>