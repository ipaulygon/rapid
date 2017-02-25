@extends('layouts.maintenance')

@section('content')
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

	<h2>Maintenance - Update Promo</h2>
	<hr><br>

	<div class="ui form">
		{!! Form::open(['action' => 'PromoController@update']) !!}
			<input type="hidden" name="editPromoId" value="{{ $promo[0]->promoId }}" readonly>
			<div class="inline fields">
				<div class="two wide field">
					<label>Promo<span>*</span></label>
				</div>
				<div class="six wide field">
					<input type="text" name="editPromoName" value="{{ $promo[0]->promoName }}" placeholder="Promo">
				</div>
				<div class="two wide field">
					<label>Price<span>*</span></label>
				</div>
				<div class="six wide field">
					<div class="ui labeled input">
						<div class="ui label">Php</div>
						<input type="text" name="editPromoCost" value="{{ $promo[0]->promoCost }}" placeholder="100">
					</div>
				</div>
			</div>
			<div class="inline fields">
				<div class="two wide field">
					<label>Start Date<span>*</span></label>
				</div>
				<div class="six wide field">
					<input type="date" name="editPromoStart" value="{{ $promo[0]->promoStart }}" placeholder="Start Date">
				</div>
				<div class="two wide field">
					<label>End Date</label>
				</div>
				<div class="six wide field">
					<input type="date" name="editPromoEnd" value="{{ $promo[0]->promoEnd }}" placeholder="End Date">
				</div>
			</div>
			<div class="inline fields">
				<div class="two wide field">
					<label>Description</label>
				</div>
				<div class="fourteen wide field">
					<textarea type="text" name="editPromoDesc" placeholder="Description" rows="2">{{ $promo[0]->promoDesc }}</textarea>
				</div>
			</div>
			<div class="three fields">
				<div class="field">
					<label>Products:</label>
					<div id="add" style="width:100%" class="ui multiple search selection dropdown">
						<input type="hidden" name="editPromoProductId"><i class="dropdown icon"></i>
						<input class="search" autocomplete="off" tabindex="0">
						<div class="default text">Select Products</div>
						<div class="menu" tabindex="-1">
							@foreach($product as $product)
								@if($product->pvIsActive==1)
									<div class="item" title="{{$promo[0]->promoId}}" data-value="{{ $product->pvId }}">{{$product->product->brand->brandName}} - {{$product->product->productName}}| {{$product->variance->varianceSize}} - {{$product->variance->unit->unitName}}| {{$product->product->types->typeName}}</div>
								@endif
							@endforeach
						</div>
					</div>
				</div>
				<div class="field" id="qty{{$promo[0]->promoId}}">
					<label>Quantity:</label>
				</div>
				<div class="field">
					<label>Services:</label>
					<div id="serv" style="width:100%" class="ui multiple search selection dropdown">
						<input type="hidden" name="editPromoServiceId"><i class="dropdown icon"></i>
						<input class="search" autocomplete="off" tabindex="0">
						<div class="default text">Select Services</div>
						<div class="menu" tabindex="-1">
							@foreach($service as $service)
								@if($service->serviceIsActive==1)
									<div class="item" data-value="{{ $service->serviceId }}">{{$service->serviceName}} - {{$service->categories->categoryName}}</div>
								@endif
							@endforeach
						</div>
					</div>
				</div>
			</div>
			<hr>
			<i>Note: All with <span>*</span> are required fields</i>
			<div style="float:right">
				<a href="{{URL::to('/maintenance/promo')}}" type="reset" class="ui negative button"><i class="arrow left icon"></i>Back</a>
				<button type="submit" class="ui positive button"><i class="plus icon"></i>Save</button>
			</div>
		{!! Form::close() !!}
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
		    $('#listType').DataTable();
		    $('#serv.ui.dropdown').dropdown();
		    $('#add.ui.dropdown').dropdown({
		    	onAdd: function(value,text,$addedChoice){
		    		var prod = $addedChoice.attr('title');
		    		$("#qty"+prod).append('<div id="'+value+'"><label id="'+value+'">'+text+'</label><div class="ui right labeled input"><input id="'+value+'" type="text" name="qtys[]"><div class="ui label">pieces</div></div></div>');
		    	},
		    	onRemove: function(value, text, $removedChoice){
		    		var prod = $removedChoice.attr('title');
		    		$("#qty"+prod+" div[id="+value+"]").remove();
				}
		    });
		    var products = [
		    	@foreach($pp as $pp)
		    		@if($pp->promoPIsActive==1)
		    			'{{$pp->promoProductId}}',
		    		@endif
		    	@endforeach
		    ];
		    $('#add.ui.dropdown').dropdown('set selected',products);
		    @foreach($pd as $pp)
	    		@if($pp->promoPIsActive==1)
	    			$('#qty{{$promo[0]->promoId}} input[id={{$pp->promoProductId}}]').val({{$pp->promoPQty}});
	    		@endif
	    	@endforeach
	    	var services = [
		    	@foreach($ps as $ps)
		    		@if($ps->promoSIsActive==1)
		    			'{{$ps->promoServiceId}}',
		    		@endif
		    	@endforeach
		    ];
		    $('#serv.ui.dropdown').dropdown('set selected',services);
		    
		});
	</script>
@stop