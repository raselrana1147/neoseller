@extends('layouts.front')

@section('content')

<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<ul class="pages">
					<li>
						<a href="{{ route('front.index') }}">
							{{ $langg->lang17 }}
						</a>
					</li>
					<li>
						<a href="{{ route('front.checkout') }}">
							{{ $langg->lang136 }}
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- Breadcrumb Area End -->

<!-- Check Out Area Start -->

<section class="checkout">
	<div class="container">
		  @include('error.error')
		<div class="row">
			<div class="col-lg-12">
				<div class="checkout-area mb-0 pb-0">
					<div class="checkout-process">
						<ul class="nav" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="pills-step1-tab" data-toggle="pill" href="#pills-step1"
									role="tab" aria-controls="pills-step1" aria-selected="true">
									<span>1</span> {{ $langg->lang743 }}
									<i class="far fa-address-card"></i>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link disabled" id="pills-step2-tab" data-toggle="pill" href="#pills-step2"
									role="tab" aria-controls="pills-step2" aria-selected="false">
									<span>2</span> {{ $langg->lang744 }}
									<i class="fas fa-dolly"></i>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link disabled" id="pills-step3-tab" data-toggle="pill" href="#pills-step3"
									role="tab" aria-controls="pills-step3" aria-selected="false">
									<span>3</span> {{ $langg->lang745 }}
									<i class="far fa-credit-card"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>


			<div class="col-lg-8">

{{-- ====================start from============================ --}}

				<form id="step1-form" action="{{route('paypal.submit')}}" method="POST" class="checkoutform">

					@include('includes.form-success')
					@include('includes.form-error')

					{{ csrf_field() }}

		<div class="checkout-area">
			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="pills-step1" role="tabpanel"
					aria-labelledby="pills-step1-tab">
					<div class="content-box">

						<div class="content">
						
							<div class="billing-address">
								<h5 class="title">
									{{ $langg->lang147 }}
								</h5>
								<div class="row">
									{{-- <div class="col-lg-6 {{ $digital == 1 ? 'd-none' : '' }}">
										<select class="form-control" id="shipop" name="shipping"
											required="" style="margin-bottom: 7px">
											<option value="shipto">{{ $langg->lang149 }}</option>
											<option value="pickup">{{ $langg->lang150 }}</option>
										</select>
									</div>
									<br>
 --}}
									<div class="col-lg-6 d-none" id="shipshow">
										<select class="form-control nice" name="pickup_location">
											@foreach($pickups as $pickup)
											<option value="{{$pickup->location}}">{{$pickup->location}}
											</option>
											@endforeach
										</select>
									</div>
									<br>

									<div class="col-lg-6">
										<input class="form-control" type="text" name="name"
											placeholder="{{ $langg->lang152 }}" required=""
											value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->name : '' }}">
									 </div>
									 <br>

									<div class="col-lg-6">
										<input class="form-control" type="text" name="phone"
											placeholder="{{ $langg->lang153 }}" required=""
											value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->phone : '' }}">
									</div>

									<div class="col-lg-6">
										<input class="form-control" type="text" name="city"
											placeholder="City" required=""
											value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->city : '' }}">
									</div>

									<br>

									<div class="col-lg-6">
							         <input class="form-control " type="text" name="address"
								       placeholder="{{ $langg->lang155 }}" required=""
								       value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->address : '' }}">
						            </div>

									{{-- <div class="col-lg-6 {{ $digital == 1 ? 'd-none' : '' }}">
										<select class="form-control" id="shiparea_id" name="shiparea_id"
											required="" style="margin-bottom: 7px">
											<option value="">Select One</option>
											<option value="1">Inside Dhaka</option>
											<option value="2">Outsite Dhaka</option>
										</select>
									</div>
									
									<br> --}}			

						</div>
							</div>

							{{-- ====ship in different address code====== --}}

							<div class="row">
								<div class="col-lg-12  mt-3">
									<div class="bottom-area">
										<button type="submit" class="mybtn1">Continue</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				{{-- end form --}}


				<div class="tab-pane fade" id="pills-step2" role="tabpanel"
					aria-labelledby="pills-step2-tab">
					<div class="content-box">
						<div class="content">

							<div class="order-area">
								@foreach($products as $product)
								<div class="order-item">
									<div class="product-img">
										<div class="d-flex">
											<img src=" {{ asset('assets/images/products/'.$product['item']['photo']) }}"
												height="80" width="80" class="p-1">

										</div>
									</div>
									<div class="product-content">
										<p class="name"><a
												href="{{ route('front.product', $product['item']['slug']) }}"
												target="_blank">{{ $product['item']['name'] }}</a></p>
										<div class="unit-price">
											<h5 class="label">{{ $langg->lang754 }} : </h5>
											<p>{{ App\Models\Product::convertPrice($product['item']['price']) }}</p>
										</div>
										@if(!empty($product['size']))
										<div class="unit-price">
											<h5 class="label">{{ $langg->lang312 }} : </h5>
											<p>{{ $product['size'] }}</p>
										</div>
										@endif
										@if(!empty($product['color']))
										<div class="unit-price">
											<h5 class="label">{{ $langg->lang313 }} : </h5>
											<span id="color-bar" style="border: 10px solid {{$product['color'] == "" ? "white" : $product['color']}};"></span>
										</div>
										@endif
										<div class="quantity">
											<h5 class="label">{{ $langg->lang755 }} : </h5>
											<span class="qttotal">{{ $product['qty'] }} </span>
										</div>
										<div class="total-price">

											<h5 class="label">{{ $langg->lang756 }} : </h5>
											<p>{{ App\Models\Product::convertPrice($product['price']) }}</p>
										</div>

									</div>
								</div>


								@endforeach


							</div>
							<div class="row">
								<div class="col-lg-12 mt-3">
									<div class="bottom-area">
										<a href="javascript:;" id="step1-btn"
											class="mybtn1 mr-3">{{ $langg->lang757 }}</a>
										<a href="javascript:;" id="step3-btn"
											class="mybtn1">{{ $langg->lang753 }}</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="pills-step3" role="tabpanel"
					aria-labelledby="pills-step3-tab">
					<div class="content-box">
						<div class="content">

							<div class="billing-info-area {{ $digital == 1 ? 'd-none' : '' }}">
								<h4 class="title">
									{{ $langg->lang758 }}
								</h4>
								<ul class="info-list">
									<li>
										<p id="shipping_user"></p>
									</li>
									
									<li>
										<p id="shipping_phone"></p>
									</li>
									
								</ul>
							</div>
		{{-- =======payment infomation======== --}}
							<div class="payment-information">
								<h4 class="title">
									{{ $langg->lang759 }}
								</h4>
								<div class="row">
									<div class="col-lg-12">
										<div class="nav flex-column" role="tablist"
											aria-orientation="vertical">
											
											
											@if($gs->cod_check == 1)
											@if($digital == 0)
											<a class="nav-link payment" data-show="no"
												data-form="{{route('cash.submit')}}"
												data-href="{{ route('front.load.payment',['slug1' => 'cod','slug2' => 0]) }}"
												id="v-pills-tab3-tab" data-toggle="pill"
												href="#v-pills-tab3" role="tab" aria-controls="v-pills-tab3"
												aria-selected="false">
												<div class="icon">
													<span class="radio"></span>
												</div>
												<p>
													{{ $langg->lang762 }}

													@if($gs->cod_text != null)

													<small>
														{{ $gs->cod_text }}
													</small>

													@endif

												</p>
											</a>
											@endif
											@endif
																					
											@if($digital == 0)

											@foreach($gateways as $gt)

											<a class="nav-link payment" data-show="yes"
												data-form="{{route('gateway.submit')}}"
												data-href="{{ route('front.load.payment',['slug1' => 'other','slug2' => $gt->id]) }}"
												id="v-pills-tab{{ $gt->id }}-tab" data-toggle="pill"
												href="#v-pills-tab5" role="tab"
												aria-controls="v-pills-tab{{ $gt->id }}"
												aria-selected="false">
												<div class="icon">
													<span class="radio"></span>
												</div>
												<p>
													{{ $gt->title }}

													@if($gt->subtitle != null)

													<small>
														{{ $gt->subtitle }}
													</small>

													@endif

												</p>
											</a>
											@endforeach

											@endif

										</div>
									</div>
			<div class="col-lg-12">
				<div class="pay-area d-none">
					<div class="tab-content" id="v-pills-tabContent">
						@if($gs->paypal_check == 1)
						<div class="tab-pane fade show active" id="v-pills-tab1"
							role="tabpanel" aria-labelledby="v-pills-tab1-tab">
							<input type="hidden" name="method" value="Paypal">
							<input type="hidden" name="cmd" value="_xclick">
							<input type="hidden" name="no_note" value="1">
							<input type="hidden" name="lc" value="UK">
							<input type="hidden" name="currency_code"
								value="{{$curr->name}}">
							<input type="hidden" name="bn"
								value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest">
						</div>
						@endif
						@if($gs->stripe_check == 1)
						<div class="tab-pane fade" id="v-pills-tab2" role="tabpanel"
							aria-labelledby="v-pills-tab2-tab">
						</div>
						@endif
						@if($gs->cod_check == 1)
						@if($digital == 0)
						<div class="tab-pane fade" id="v-pills-tab3" role="tabpanel"
							aria-labelledby="v-pills-tab3-tab">
						</div>
						@endif
						@endif
						@if($gs->is_instamojo == 1)
						<div class="tab-pane fade" id="v-pills-tab4" role="tabpanel"
							aria-labelledby="v-pills-tab4-tab">
						</div>
						@endif
						@if($gs->is_paystack)
						<div class="tab-pane fade" id="v-pills-tab5" role="tabpanel"
							aria-labelledby="v-pills-tab5-tab">
						</div>
						@endif
						@if($digital == 0)
						@foreach($gateways as $gt)

						<div class="tab-pane fade" id="v-pills-tab{{ $gs->id }}"
							role="tabpanel"
							aria-labelledby="v-pills-tab{{ $gs->id }}-tab">

						</div>

						@endforeach
						@endif
					</div>
				</div>
			</div>
								</div>
							</div>

{{-- =================end payment information================== --}}

							<div class="row">
								<div class="col-lg-12 mt-3">
									<div class="bottom-area">

										<a href="javascript:;" id="step2-btn"
											class="mybtn1 mr-3">{{ $langg->lang757 }}</a>
										<button type="submit" id="final-btn"
											class="mybtn1">{{ $langg->lang753 }}</button>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


					<input type="hidden" id="shipping-cost" name="shipping_cost" value="0">
					<input type="hidden" id="packing-cost" name="packing_cost" value="0">
					<input type="hidden" name="dp" value="{{$digital}}">
					<input type="hidden" name="tax" value="{{$gs->tax}}">
					<input type="hidden" name="totalQty" value="{{$totalQty}}">

					<input type="hidden" name="vendor_shipping_id" value="{{ $vendor_shipping_id }}">
					<input type="hidden" name="vendor_packing_id" value="{{ $vendor_packing_id }}">


					@if(Session::has('coupon_total'))
					<input type="hidden" name="total" id="grandtotal" value="{{ $totalPrice }}">
					@elseif(Session::has('coupon_total1'))
					<input type="hidden" name="total" id="grandtotal"
						value="{{ preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1') ) }}">
					@else
					<input type="hidden" name="total" id="grandtotal" value="{{round($totalPrice * $curr->value,2)}}">
					@endif


					<input type="hidden" name="coupon_code" id="coupon_code"
						value="{{ Session::has('coupon_code') ? Session::get('coupon_code') : '' }}">
					<input type="hidden" name="coupon_discount" id="coupon_discount"
						value="{{ Session::has('coupon') ? Session::get('coupon') : '' }}">
					<input type="hidden" name="coupon_id" id="coupon_id"
						value="{{ Session::has('coupon') ? Session::get('coupon_id') : '' }}">
					<input type="hidden" name="user_id" id="user_id"
						value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->id : '' }}">



				</form>


				{{-- ==========================end here form================== --}}

			</div>

			@if(Session::has('cart'))
			<div class="col-lg-4">
				<div class="right-area">
					<div class="order-box">
						<h4 class="title">{{ $langg->lang127 }}</h4>
						<ul class="order-list">
							<li>
								<p>
									{{ $langg->lang128 }}
								</p>
								<P>
									<b
										class="cart-total">{{ Session::has('cart') ? App\Models\Product::convertPrice(Session::get('cart')->totalPrice) : '0.00' }}</b>
								</P>
							</li>

							@if($gs->tax != 0)

							<li>
								<p>
									{{ $langg->lang144 }}
								</p>
								<P>
									<b> {{$gs->tax}}% </b>

								</P>
							</li>

							@endif




							@if(Session::has('coupon'))


							<li class="discount-bar">
								<p>
									{{ $langg->lang145 }} <span
										class="dpercent">{{ Session::get('coupon_percentage') == 0 ? '' : '('.Session::get('coupon_percentage').')' }}</span>
								</p>
								<P>
									@if($gs->currency_format == 0)
									<b id="discount">{{ $curr->sign }}{{ Session::get('coupon') }}</b>
									@else
									<b id="discount">{{ Session::get('coupon') }}{{ $curr->sign }}</b>
									@endif
								</P>
							</li>


							@else


							<li class="discount-bar d-none">
								<p>
									{{ $langg->lang145 }} <span class="dpercent"></span>
								</p>
								<P>
									<b id="discount">{{ $curr->sign }}{{ Session::get('coupon') }}</b>
								</P>
							</li>


							@endif




						</ul>

						<div class="total-price">

							<p>{{ $langg->lang131 }}</p>
							
							<p>

								@if(Session::has('coupon_total'))
								@if($gs->currency_format == 0)
								<span id="total-cost">{{ $curr->sign }}{{ $totalPrice }}</span>
								@else
								<span id="total-cost">{{ $totalPrice }}{{ $curr->sign }}</span>
								@endif

								@elseif(Session::has('coupon_total1'))
								<span id="total-cost"> {{ Session::get('coupon_total1') }}</span>
								@else
								<span id="total-cost">{{ App\Models\Product::convertPrice($totalPrice) }}</span>
								@endif

							</p>

						</div>
                  <p style="font-weight: bold;">Total Commission: {{ $acharge }}</p>

						<div class="cupon-box">

							<div id="coupon-link">
								<img src="{{ asset('assets/front/images/tag.png') }}">
								Have a coupon code ?
							</div>

							<form id="check-coupon-form" class="coupon">
								<input type="text" placeholder="{{ $langg->lang133 }}" id="code" required=""
									autocomplete="off">
								<button type="submit">Apply</button>
							</form>


						</div>

						@if($digital == 0)

						{{-- Shipping Method Area Start --}}
						{{-- <div class="packeging-area"> --}}
							{{-- <h4 class="title">Shipping Method</h4> --}}

							

							{{-- <div class="radio-design" id="shippingmethod">
					        <input type="radio" class="shipping" id="" name="shipping"
									value="">
							<span class="checkmark"></span>
							<label for="free-shepping"></label>
							</div> --}}

							<div class="packeging-area">
								<h4 class="title">Shipping method</h4>

								{{-- @foreach($shipping_data as $data) --}}
								
								{{-- <div class="radio-design">
                                 <input type="radio" class="shipping" id="free-shepping{{ $data->id }}" name="shipping"
										value="{{ round($data->price * $curr->value,2) }}"
										{{ ($loop->first) ? 'checked' : '' }}>
									<span class="checkmark"></span>

									<label for="free-shepping{{ $data->id }}">
										{{ $data->title }}
										@if($data->price != 0)
										+ {{ $curr->sign }}{{ round($data->price * $curr->value,2) }}
										@endif
										<small>{{ $data->subtitle }}</small>
									</label>
								</div> --}}
								@php
									$shiptype=App\Shiptype::all();
								@endphp
								@foreach($shiptype as $type)
								<h5>{{$type->name}}</h5>
								@foreach($type->shipinfo as $info)
								<div class="radio-design" style="margin-left: 25px">
                                 <input type="radio" class="shipping" id="free-shepping{{ $info->id }}" name="shipping" value="{{ round($info->price * $curr->value,2) }}"
                                 {{ ($info->id)==1 ? 'checked' : '' }}> 
									<span class="checkmark"></span>
									<label for="">
										<span>{{$info->location}}</span>
										<small>Cost: {{$info->price}} TK</small>
										<small>Delivery time : {{$info->duration}}</small>
										@if($info->note !=null)
										 <small>Note : {{$info->note}}</small> 
										@endif
									</label>
								</div>
								@endforeach
								@endforeach

								
								{{-- @endforeach --}}

						</div>

							

						{{-- </div> --}}
						{{-- Shipping Method Area End --}}

						{{-- Packeging Area Start --}}
						
						{{-- Packeging Area End Start--}}

						{{-- Final Price Area Start--}}
						<div class="final-price">
							<span>{{ $langg->lang767 }} :</span>
							@if(Session::has('coupon_total'))
							@if($gs->currency_format == 0)
							<span id="final-cost">{{ $curr->sign }}{{ $totalPrice }}</span>
							@else
							<span id="final-cost">{{ $totalPrice }}{{ $curr->sign }}</span>
							@endif

							@elseif(Session::has('coupon_total1'))
							<span id="final-cost"> {{ Session::get('coupon_total1') }}</span>
							@else
							<span id="final-cost">{{ App\Models\Product::convertPrice($totalPrice) }}</span>
							@endif



						</div>
						{{-- Final Price Area End --}}

						@endif

						{{-- <a href="{{ route('front.checkout') }}" class="order-btn mt-4">
							{{ $langg->lang135 }}
						</a> --}}
					</div>
				</div>
			</div>
			@endif
		</div>
	</div>
</section>
<!-- Check Out Area End-->

@if(isset($checked))

<!-- LOGIN MODAL -->
<div class="modal fade" id="comment-log-reg1" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
	aria-labelledby="comment-log-reg-Title" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" aria-label="Close">
					<a href="{{ url()->previous() }}"><span aria-hidden="true">&times;</span></a>
				</button>
			</div>
			<div class="modal-body">
				<nav class="comment-log-reg-tabmenu">
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<a class="nav-item nav-link login active" id="nav-log-tab" data-toggle="tab" href="#nav-log"
							role="tab" aria-controls="nav-log" aria-selected="true">
							{{ $langg->lang197 }}
						</a>
						<a class="nav-item nav-link" id="nav-reg-tab" data-toggle="tab" href="#nav-reg" role="tab"
							aria-controls="nav-reg" aria-selected="false">
							{{ $langg->lang198 }}
						</a>
					</div>
				</nav>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-log" role="tabpanel" aria-labelledby="nav-log-tab">
						<div class="login-area">
							<div class="header-area">
								<h4 class="title">{{ $langg->lang172 }}</h4>
							</div>
							<div class="login-form signin-form">
								@include('includes.admin.form-login')
								<form id="loginform" action="{{ route('user.login.submit') }}" method="POST">
									{{ csrf_field() }}
									<div class="form-input">
										<input type="email" name="email" placeholder="{{ $langg->lang173 }}"
											required="">
										<i class="icofont-user-alt-5"></i>
									</div>
									<div class="form-input">
										<input type="password" class="Password" name="password"
											placeholder="{{ $langg->lang174 }}" required="">
										<i class="icofont-ui-password"></i>
									</div>
									<div class="form-forgot-pass">
										<div class="left">
											<input type="hidden" name="modal" value="1">
											<input type="checkbox" name="remember" id="mrp"
												{{ old('remember') ? 'checked' : '' }}>
											<label for="mrp">{{ $langg->lang175 }}</label>
										</div>
										<div class="right">
											<a href="{{ route('user-forgot') }}">
												{{ $langg->lang176 }}
											</a>
										</div>
										
									</div>
									<input id="authdata" type="hidden" value="{{ $langg->lang177 }}">
									<button type="submit" class="submit-btn">{{ $langg->lang178 }}</button>
									@if(App\Models\Socialsetting::find(1)->f_check == 1 ||
									App\Models\Socialsetting::find(1)->g_check == 1)
									<div class="social-area">
										<h3 class="title">{{ $langg->lang179 }}</h3>
										<p class="text">{{ $langg->lang180 }}</p>
										<ul class="social-links">
											@if(App\Models\Socialsetting::find(1)->f_check == 1)
											<li>
												<a href="{{ route('social-provider','facebook') }}">
													<i class="fab fa-facebook-f"></i>
												</a>
											</li>
											@endif
											@if(App\Models\Socialsetting::find(1)->g_check == 1)
											<li>
												<a href="{{ route('social-provider','google') }}">
													<i class="fab fa-google-plus-g"></i>
												</a>
											</li>
											@endif
										</ul>
									</div>
									@endif
								</form>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="nav-reg" role="tabpanel" aria-labelledby="nav-reg-tab">
						<div class="login-area signup-area">
							<div class="header-area">
								<h4 class="title">{{ $langg->lang181 }}</h4>
							</div>
							<div class="login-form signup-form">
								@include('includes.admin.form-login')
								<form id="registerform" action="{{route('user-register-submit')}}" method="POST">
									{{ csrf_field() }}

									<div class="form-input">
										<input type="text" class="User Name" name="name"
											placeholder="{{ $langg->lang182 }}" required="">
										<i class="icofont-user-alt-5"></i>
									</div>

									<div class="form-input">
										<input type="email" class="User Name" name="email"
											placeholder="{{ $langg->lang183 }}" required="">
										<i class="icofont-email"></i>
									</div>

									<div class="form-input">
										<input type="text" class="User Name" name="phone"
											placeholder="{{ $langg->lang184 }}" required="">
										<i class="icofont-phone"></i>
									</div>

									<div class="form-input">
										<input type="text" class="User Name" name="address"
											placeholder="{{ $langg->lang185 }}" required="">
										<i class="icofont-location-pin"></i>
									</div>

									<div class="form-input">
										<input type="password" class="Password" name="password"
											placeholder="{{ $langg->lang186 }}" required="">
										<i class="icofont-ui-password"></i>
									</div>

									<div class="form-input">
										<input type="password" class="Password" name="password_confirmation"
											placeholder="{{ $langg->lang187 }}" required="">
										<i class="icofont-ui-password"></i>
									</div>

									@if($gs->is_capcha == 1)

									<ul class="captcha-area">
										<li>
											<p><img class="codeimg1" src="{{asset("assets/images/capcha_code.png")}}"
													alt=""> <i class="fas fa-sync-alt pointer refresh_code "></i></p>
										</li>
									</ul>

									<div class="form-input">
										<input type="text" class="Password" name="codes"
											placeholder="{{ $langg->lang51 }}" required="">
										<i class="icofont-refresh"></i>
									</div>

									@endif

									<input id="processdata" type="hidden" value="{{ $langg->lang188 }}">
									<button type="submit" class="submit-btn">{{ $langg->lang189 }}</button>

								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- LOGIN MODAL ENDS -->

@endif

@endsection

@section('scripts')

<script type="text/javascript">
	var coup = 0;
	var pos = {{  $gs->currency_format }};

	@if(isset($checked))

	$('#comment-log-reg1').modal('show');

	@endif

	var mship = $('.shipping').length > 0 ? $('.shipping').first().val() : 0;
	var mpack = $('.packing').length > 0 ? $('.packing').first().val() : 0;
	mship = parseFloat(mship);
	mpack = parseFloat(mpack);

	$('#shipping-cost').val(mship);
	$('#packing-cost').val(mpack);
	var ftotal = parseFloat($('#grandtotal').val()) + mship + mpack;
	ftotal = parseFloat(ftotal);
	if (ftotal % 1 != 0) {
		ftotal = ftotal.toFixed(2);
	}
	if (pos == 0) {
		$('#final-cost').html('{{ $curr->sign }}' + ftotal);
	} else {
		$('#final-cost').html(ftotal + '{{ $curr->sign }}');
	}



	$('#shipop').on('change', function () {
		var val = $(this).val();
		if (val == 'pickup') {
			$('#shipshow').removeClass('d-none');
			$("#ship-diff-address").parent().addClass('d-none');
			$('.ship-diff-addres-area').addClass('d-none');
			$('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required', false);
		} else {
			$('#shipshow').addClass('d-none');
			$("#ship-diff-address").parent().removeClass('d-none');
			$('.ship-diff-addres-area').removeClass('d-none');
			$('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required', true);
		}

	});


	$('.shipping').on('click', function () {
		mship = $(this).val();
		$('#shipping-cost').val(mship);
		var ttotal = parseFloat($('#grandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
		ttotal = parseFloat(ttotal);
		if (ttotal % 1 != 0) {
			ttotal = ttotal.toFixed(2);
		}
		if (pos == 0) {
			$('#final-cost').html('{{ $curr->sign }}' + ttotal)
		} else {
			$('#final-cost').html(ttotal + '{{ $curr->sign }}')
		}
	});

	$('.packing').on('click', function () {
		mpack = $(this).val();
		$('#packing-cost').val(mpack);
		var ttotal = parseFloat($('#grandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
		ttotal = parseFloat(ttotal);
		if (ttotal % 1 != 0) {
			ttotal = ttotal.toFixed(2);
		}
		if (pos == 0) {
			$('#final-cost').html('{{ $curr->sign }}' + ttotal)
		} else {
			$('#final-cost').html(ttotal + '{{ $curr->sign }}')
		}
	});

	$("#check-coupon-form").on('submit', function () {
		var val = $("#code").val();
		var total = $("#grandtotal").val();
		var ship = 0;
		$.ajax({
			type: "GET",
			url: mainurl + "/carts/coupon/check",
			data: {
				code: val,
				total: total,
				shipping_cost: ship
			},
			success: function (data) {
				
				if (data == 0) {
					toastr.error(langg.no_coupon);
					$("#code").val("");
				} else if (data == 2) {
					toastr.error(langg.already_coupon);
					$("#code").val("");
				} else if(data.status == 1){
					toastr.error(data.message);
					$("#code").val("");
					//console.log('less tk');
				}else {
					$("#check-coupon-form").toggle();
					$(".discount-bar").removeClass('d-none');

					if (pos == 0) {
						$('#total-cost').html('{{ $curr->sign }}' + data[0]);
						$('#discount').html('{{ $curr->sign }}' + data[2]);
					} else {
						$('#total-cost').html(data[0] + '{{ $curr->sign }}');
						$('#discount').html(data[2] + '{{ $curr->sign }}');
					}
					$('#grandtotal').val(data[0]);
					$('#coupon_code').val(data[1]);
					$('#coupon_discount').val(data[2]);
					if (data[4] != 0) {
						$('.dpercent').html('(' + data[4] + ')');
					} else {
						$('.dpercent').html('');
					}


					var ttotal = parseFloat($('#grandtotal').val()) + parseFloat(mship) + parseFloat(
						mpack);
					ttotal = parseFloat(ttotal);
					if (ttotal % 1 != 0) {
						ttotal = ttotal.toFixed(2);
					}

					if (pos == 0) {
						$('#final-cost').html('{{ $curr->sign }}' + ttotal)
					} else {
						$('#final-cost').html(ttotal + '{{ $curr->sign }}')
					}

					toastr.success(langg.coupon_found);
					$("#code").val("");
				}
			 }
		});
		return false;
	});

	// Password Checking

	$("#open-pass").on("change", function () {
		if (this.checked) {
			$('.set-account-pass').removeClass('d-none');
			$('.set-account-pass input').prop('required', true);
			$('#personal-email').prop('required', true);
			$('#personal-name').prop('required', true);
		} else {
			$('.set-account-pass').addClass('d-none');
			$('.set-account-pass input').prop('required', false);
			$('#personal-email').prop('required', false);
			$('#personal-name').prop('required', false);

		}
	});

	// Password Checking Ends

	// Shipping Address Checking

	$("#ship-diff-address").on("change", function () {
		if (this.checked) {
			$('.ship-diff-addres-area').removeClass('d-none');
			$('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required', true);
		} else {
			$('.ship-diff-addres-area').addClass('d-none');
			$('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required', false);
		}

	});

	// Shipping Address Checking Ends
	
</script>


<script type="text/javascript">
	var ck = 0;
	$('#step1-form').on('submit', function (e) {
		if (ck == 0) {
			e.preventDefault();
			$('#pills-step2-tab').removeClass('disabled');
			$('#pills-step2-tab').click();

		} else {
			$('#preloader').show();
		}
		$('#pills-step1-tab').addClass('active');
	});

	$('#step1-btn').on('click', function () {
		$('#pills-step1-tab').removeClass('active');
		$('#pills-step2-tab').removeClass('active');
		$('#pills-step3-tab').removeClass('active');
		$('#pills-step2-tab').addClass('disabled');
		$('#pills-step3-tab').addClass('disabled');
		$('#pills-step1-tab').click();
	});

	// Step 2 btn DONE

	$('#step2-btn').on('click', function () {
		$('#pills-step3-tab').removeClass('active');
		$('#pills-step1-tab').removeClass('active');
		$('#pills-step2-tab').removeClass('active');
		$('#pills-step3-tab').addClass('disabled');
		$('#pills-step2-tab').click();
		$('#pills-step1-tab').addClass('active');
	});

	$('#step3-btn').on('click', function () {

		$('#pills-step3-tab').removeClass('disabled');
		$('#pills-step3-tab').click();
		var shipping_user = !$('input[name="shipping_name"]').val() ? $('input[name="name"]').val() : $(
			'input[name="shipping_name"]').val();
		var shipping_location = !$('input[name="shipping_address"]').val() ? $('input[name="address"]').val() : $(
			'input[name="shipping_address"]').val();
		var shipping_phone = !$('input[name="shipping_phone"]').val() ? $('input[name="phone"]').val() : $(
			'input[name="shipping_phone"]').val();
		var shipping_email = !$('input[name="shipping_email"]').val() ? $('input[name="email"]').val() : $(
			'input[name="shipping_email"]').val();

		$('#shipping_user').html('<i class="fas fa-user"></i>' + shipping_user);
		$('#shipping_location').html('<i class="fas fas fa-map-marker-alt"></i>' + shipping_location);
		$('#shipping_phone').html('<i class="fas fa-phone"></i>' + shipping_phone);
		$('#shipping_email').html('<i class="fas fa-envelope"></i>' + shipping_email);

		$('#pills-step1-tab').addClass('active');
		$('#pills-step2-tab').addClass('active');

	});

	$('#final-btn').on('click', function () {
		ck = 1;
	});


	$('.payment').on('click', function () {
		$('#step1-form').prop('action', $(this).data('form'));
		$('.pay-area #v-pills-tabContent .tab-pane.fade').not($(this).attr('href')).html('');
		var show = $(this).data('show');
		if (show != 'no') {
			$('.pay-area').removeClass('d-none');
		} else {
			$('.pay-area').addClass('d-none');
		}
		$($(this).attr('href')).load($(this).data('href'));
	});
</script>

<script>
	$(document).ready(function(){
		$('#shiparea_id').change(function(){
			var shiparea_id=$('#shiparea_id').val();



			 $.get("http:localhost/oferri/getshiping/"+shiparea_id,function(data){
                data=JSON.parse(data);
                data.forEach(function(element){
                	console.log(data);
                	checkout
                    //option+="<option value='"+element.id+"'>"+element.name+"</option>"
               
                })
                 // $('#district_id').html(option);

              });

		});
	});
</script>

@endsection