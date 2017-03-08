@extends('layouts.master')

@section('content')	
	<!--Add-->	
	@if(Session::has('flash_message'))
		<div class="ui small basic modal" style="text-align:center" id="flash_message">
			<div class="ui icon header">
				<i class="check icon"></i>
				Success
			</div>
			<div class="content">
				<em>{!! session('flash_message') !!}</em>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function (){
				$('#flash_message').modal('show');
				setTimeout(function () {
                    $("#flash_message").modal('hide');
                }, 2000);
			});
		</script>
	@endif

	<!--Errors-->	
	@if($errors->any())
		<div class="ui small basic modal" style="text-align:center" id="error">
			<div class="ui icon header">
				<i class="remove icon"></i>
				Error
			</div>
			<div class="content">
				@foreach ($errors->all() as $error)
                	<li>{{ $error }}</li>
              	@endforeach
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function (){
				$('#error').modal('show');
			});
		</script>
	@endif

	<!--Update Failed-->
	@if(Session::has('error_message'))
		<div class="ui small basic modal" style="text-align:center" id="error_message">
			<div class="ui icon header">
				<i class="remove icon"></i>
				Failed
			</div>
			<div class="content">
				<em>{!! session('error_message') !!}</em>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function (){
				$('#error_message').modal('show');
			});
		</script>
	@endif

	<h2>Maintenance - Promo</h2>
	<hr><br>
	<a href="{{URL::to('maintenance/promo/form-create')}}" class="ui green button" name="modalAdd"><i class="plus icon"></i>New Promo</a>
	<br><br>
	<table id="listType" class="ui celled table">
		<thead>
			<tr>
				<th>Promo</th>
				<th class="right aligned">Price (PhP)</th>
				<th>Products</th>
				<th>Services</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($promo as $promo)
				@if($promo->promoIsActive==1)
					<tr>
						<?php 
							$price = $promo->promoCost;
							$price = number_format($price,2);
						?>
						<td>{{ $promo->promoName }}</td>
						<td class="right aligned">{{ $price }}</td>
						<td>
							@foreach($promo->product as $pp)
								@if($pp->promoPIsActive==1 && $pp->promoPIsFree==0)
									<li>{{$pp->product->product->brand->brandName}} - {{$pp->product->product->productName}}| {{$pp->product->variance->varianceSize}} - {{$pp->product->variance->unit->unitName}}|{{$pp->product->product->types->typeName}} <br> x {{$pp->promoPQty}} pcs</li>
								@endif
							@endforeach
							<b>Free:</b> 
							@foreach($promo->product as $pp)
								@if($pp->promoPIsActive==1 && $pp->promoPIsFree==1)
									<li>{{$pp->product->product->brand->brandName}} - {{$pp->product->product->productName}}| {{$pp->product->variance->varianceSize}} - {{$pp->product->variance->unit->unitName}}|{{$pp->product->product->types->typeName}} <br> x {{$pp->promoPQty}} pcs</li>
								@endif
							@endforeach
						</td>
						<td>
							@foreach($promo->service as $ps)
								@if($ps->promoSIsActive==1 && $ps->promoSIsFree==0)
									<li>{{$ps->service->serviceName}}</li>
								@endif
							@endforeach
							<b>Free:</b> 
							@foreach($promo->service as $ps)
								@if($ps->promoSIsActive==1 && $ps->promoSIsFree==1)
									<li>{{$ps->service->serviceName}}</li>
								@endif
							@endforeach
						</td>
						<td>
							<a href="promo/view/{{$promo->promoId}}" class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="modalUpdate" id="{{$promo->promoId}}"><i class="write icon"></i></a>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $promo->promoId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
						<!--Modal for Deactivate-->
						<div class="ui small basic modal" id="del{{ $promo->promoId }}" style="text-align:center">
							<div class="ui icon header">
								<i class="trash icon"></i>
								Deactivate
							</div>
							{!! Form::open(['action' => 'PromoController@destroy']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="delPromoId" value="{{ $promo->promoId }}">
										<p>
											<label>Promo: {{$promo->promoName}}</label><br>
											<label>Description: {{$promo->promoDesc}}</label>
										</p>
									</div>
								</div>
								<div class="actions">
			        				<button type="submit" class="ui negative button"><i class="trash icon"></i>Deactivate</button>
			        				<button type="reset" class="ui green button"><i class="remove icon"></i>Cancel</button>
			        			</div>
							{!! Form::close() !!}
						</div>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>
@stop


@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
		    $('#listType').DataTable();
		});
		function modal(open){
			$('#' + open + '').modal('show').modal({
				closable: false,
			});
		}
	</script>
@stop