@extends('layouts.front')
@section('content')


<section class="user-dashbord">
	<div class="container">
		<div class="row">
			@include('includes.user-dashboard-sidebar')
			<div class="col-lg-8">
				<div class="user-profile-details">
					<div class="order-history">
						<div class="header-area">
							<h4 class="title">
								{{ __('My Shop') }}
							</h4>
						</div>
						<div class="mr-table allproduct mt-4">
							<div class="table-responsiv">
								<table id="example" class="table table-hover dt-responsive" cellspacing="0"
									width="100%">
									<thead>
										<tr>
											<th>{{ __('Serial') }}</th>
											<th>{{ __('Name') }}</th>
											<th>{{ __('Thumbnail') }}</th>
											<th>{{ __('Price') }}</th>
											
										</tr>
									</thead>
									<tbody>
										@foreach($myshops as $myshop)
										<tr>
											<td>#{{$loop->index+1}}</td>
											<td><a href="{{ route('front.product', $myshop->product->slug) }}">{{$myshop->product->name}}
											</a>
											</td>
											<td>
												<a href="{{ route('front.product', $myshop->product->slug) }}"><img src="{{asset('assets/images/products/'.$myshop->product->photo)}}" alt="" style="width:100px;height: 100px">
												</a>
											</td>
											
										    <td>{{$myshop->product->price}} BDT</td>
										
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection