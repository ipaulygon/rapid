@extends('layouts.master')

@section('content')
	<h2>Maintenance - Update Promo</h2>
	<hr><br>

	<div class="ui form">
		{!! Form::open(['action' => 'PromoController@update']) !!}
			<input type="hidden" name="editPromoId" value="{{ $promo[0]->promoId }}" readonly>
			<div class="error message"></div>
			@if(Session::has('update_error'))
				@if($errors->any())
					<div class="ui negative message">
						<h3>Something went wrong!</h3>
						{!! implode('', $errors->all(
							'<li>:message</li>'
						)) !!}
					</div>
				@endif
			@endif
			@if(Session::has('update_unique'))
				<div class="ui negative message">
					<h3>Something went wrong!</h3>
					<li>Promo already exists. Update failed.</li>
				</div>
			@endif
			<div class="inline fields">
				<div class="two wide field">
					<label>Promo<span>*</span></label>
				</div>
				<div class="six wide field">
					<input maxlength="255" type="text" name="editPromoName" value="{{ $promo[0]->promoName }}" placeholder="Promo">
				</div>
				<div class="two wide field">
					<label>Price<span>*</span></label>
				</div>
				<div class="six wide field">
					<div class="ui labeled input">
						<div class="ui label">Php</div>
						<input style="text-align:right" type="text" name="editPromoCost" value="{{ $promo[0]->promoCost }}" placeholder="100">
					</div>
				</div>
			</div>
			<div class="inline fields">
				<div class="two wide field">
					<label>Description</label>
				</div>
				<div class="six wide field">
					<textarea maxlength="255" type="text" name="editPromoDesc" placeholder="Description" rows="2">{{ $promo[0]->promoDesc }}</textarea>
				</div>
				<div class="two wide field">
					<label>Total Cost of Items:</label>
				</div>
				<div class="six wide field">
					PhP <input style="border:none" id="totalCost" type="text" readonly value="0">
				</div>
			</div>
			<div class="inline fields">
				<div class="two wide field">
					<label>Promo Type</label>
				</div>
				<div class="six wide field">
					<div class="grouped fields">
						<div class="field">
							<div class="ui radio checkbox">
								<input id="date" type="radio" name="editPromoType" value="1" onchange="types(this.value)">
								<label>Date based</label>
							</div>
						</div>
						<div class="field">
							<div class="ui radio checkbox">
								<input id="supply" type="radio" name="editPromoType" value="2" onchange="types(this.value)">
								<label>Supply based</label>
							</div>
						</div>
						<div class="field">
							<div class="ui radio checkbox">
								<input id="datesupply" type="radio" name="editPromoType" value="3" onchange="types(this.value)">
								<label>Date and supply based</label>
							</div>
						</div>
					</div>
				</div>
				<div class="two wide field">
					<label>Supply</label>
				</div>
				<div class="six wide field">
					<div class="ui right labeled input">
						<input id="supplies" type="text" name="editPromoSupplies" value="{{$promo[0]->promoSupplies}}" placeholder="Pieces">
						<div class="ui label">
							pcs.
						</div>
					</div>
				</div>
			</div>
			<?php 
				$start = date('F d, Y',strtotime($promo[0]->promoStart));
				$end = date('F d, Y',strtotime($promo[0]->promoEnd));
				if($promo[0]->promoType==1){
					?>
						<script>
							$('#date').prop('checked',true);
							$('#supplies').attr("disabled",true);
							$('#supplies').attr("value",0);
							$('.start').attr("disabled",false);
							$('.end').attr("disabled",false);
							$('#supplies').val('');
							$('.start').val('');
							$('.end').val('');
						</script>
					<?php
				}
				if($promo[0]->promoType==2){
					?>
						<script>
							$('#supply').prop('checked',true);
							$('#supplies').attr("disabled",false);
							$('.start').attr("disabled",true);
							$('#start').val('');
							$('.end').attr("disabled",true);
							$('#end').val('');
						</script>
					<?php
				}
				if($promo[0]->promoType==3){
					?>
						<script>
							$('#datesupply').prop('checked',true);
							$('#supplies').attr("disabled",false);
							$('.start').attr("disabled",false);
							$('.end').attr("disabled",false);
						</script>
					<?php
				}
			?>
			<div class="inline fields">
				<div class="two wide field">
					<label>Start Date<span>*</span></label>
				</div>
				<div class="six wide field">
					<input id="start" type="hidden" name="editPromoStart" value="{{$promo[0]->promoStart}}">
					<input class="start" type="text" value="{{$start}}" name="start" placeholder="Start Date" onchange="dates(this.value,this.name)">
				</div>
				<div class="two wide field">
					<label>End Date</label>
				</div>
				<div class="six wide field">
					<input id="end" type="hidden" name="editPromoEnd" value="{{$promo[0]->promoEnd}}">
					<input class="end" type="text" value="{{$end}}" name="end" placeholder="End Date" onchange="dates(this.value,this.name)">
				</div>
			</div>
			<!--Inclusion-->
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
									<?php
										$size = "";
										if($service->serviceSize==1){
											$size="Sedan";
										}else{
											$size="Large Vehicle";
										}
									?>
									<div class="item" id="{{$service->servicePrice}}" data-value="{{ $service->serviceId }}">{{$service->serviceName}} - {{$size}}</div>
								@endif
							@endforeach
						</div>
					</div>
				</div>
			</div>
			<!--Free-->
			<h3>Free Products and Services</h3>
			<!--Noted for inclusion-->
			<div class="three fields">
				<div class="field">
					<label>Products:</label>
					<div id="adds" style="width:100%" class="ui multiple search selection dropdown">
						<input type="hidden" name="editFreePromoProductId"><i class="dropdown icon"></i>
						<input class="search" autocomplete="off" tabindex="0">
						<div class="default text">Select Products</div>
						<div class="menu" tabindex="-1">
							@foreach($freeproduct as $pv)
								@if($pv->pvIsActive==1)
									<div class="item" id="{{$pv->pvCost}}" title="{{ $promo[0]->promoId }}" data-value="{{ $pv->pvId }}">{{$pv->product->brand->brandName}} - {{$pv->product->productName}}| {{$pv->variance->varianceSize}} - {{$pv->variance->unit->unitName}}| {{$pv->product->types->typeName}}</div>
								@endif
							@endforeach
						</div>
					</div>
				</div>
				<div class="field" id="freeQty{{$promo[0]->promoId}}">
					<label>Quantity:</label>
				</div>
				<div class="field">
					<label>Services:</label>
					<div id="servs" style="width:100%" class="ui multiple search selection dropdown">
						<input type="hidden" name="editFreePromoServiceId"><i class="dropdown icon"></i>
						<input class="search" autocomplete="off" tabindex="0">
						<div class="default text">Select Services</div>
						<div class="menu" tabindex="-1">
							@foreach($freeservice as $services)
								@if($services->serviceIsActive==1)
									<div class="item" id="{{$services->servicePrice}}" data-value="{{ $services->serviceId }}">{{$services->serviceName}} - {{$services->categories->categoryName}}</div>
								@endif
							@endforeach
						</div>
					</div>
				</div>
			</div>
			<hr>
			<i>Note: All with <span>(*)</span> are required fields</i>
			<div style="float:right">
				<a href="{{URL::to('/maintenance/promo')}}" type="reset" class="ui negative button"><i class="arrow left icon"></i>Back</a>
				<button type="submit" class="ui primary button"><i class="plus icon"></i>Save</button>
			</div>
		{!! Form::close() !!}
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
		    $('#listType').DataTable();
		    $('#serv.ui.dropdown').dropdown({
				onAdd: function(value,text,$addedChoice){
					var cost = $addedChoice.attr("id");
					totalService(cost);
				},
				onRemove:function(value,text,$removedChoice){
					var cost = $removedChoice.attr("id");
					lessService(cost);
				}
			});
			$('#servs.ui.dropdown').dropdown({
				onAdd: function(value,text,$addedChoice){
					var cost = $addedChoice.attr("id");
					totalService(cost);
				},
				onRemove:function(value,text,$removedChoice){
					var cost = $removedChoice.attr("id");
					lessService(cost);
				}
			});
		    $('#add.ui.dropdown').dropdown({
		    	onAdd: function(value,text,$addedChoice){
		    		var prod = $addedChoice.attr('title');
					var cost = $addedChoice.attr('id');
		    		$("#qty"+prod).append('<div id="'+value+'"><label id="'+value+'">'+text+'</label><div class="ui right labeled input"><input style="text-align:right" id="'+value+'" title="'+cost+'" type="text" name="qtys[]" required onchange="totalProd(this.title,this.value,this.id)" onkeypress="return validate(event,this.id)" maxlength="3" data-content="Only numerical values are allowed"><div class="ui label">pieces</div></div></div>');
					$("#qty"+prod).append('<input type="hidden" id="total'+value+'" value="0">');
		    	},
		    	onRemove: function(value, text, $removedChoice){
		    		var prod = $removedChoice.attr('title');
					var cost = $removedChoice.attr('id');
					lessProd(value,cost);
		    		$("#qty"+prod+" div[id="+value+"]").remove();
					$("#qty"+prod+" input[id=total"+value+"]").remove();
				}
		    });
			$('#adds.ui.dropdown').dropdown({
		    	onAdd: function(value,text,$addedChoice){
		    		var prod = $addedChoice.attr('title');
					var cost = $addedChoice.attr('id');
		    		$("#freeQty"+prod).append('<div id="'+value+'"><label id="'+value+'">'+text+'</label><div class="ui right labeled input"><input style="text-align:right" id="free'+value+'" title="'+cost+'" type="text" name="freeqtys[]" required onchange="totalProd(this.title,this.value,this.id)" onkeypress="return validate(event,this.id)" maxlength="3" data-content="Only numerical values are allowed"><div class="ui label">pieces</div></div></div>');
					$("#freeQty"+prod).append('<input type="hidden" id="totalfree'+value+'" value="0">');
		    	},
		    	onRemove: function(value, text, $removedChoice){
		    		var prod = $removedChoice.attr('title');
					var cost = $removedChoice.attr('id');
					lessProd(value,cost);
		    		$("#freeQty"+prod+" div[id="+value+"]").remove();
					$("#freeQty"+prod+" input[id=total"+value+"]").remove();
				}
		    });
		    $('.ui.form').form({
			    fields: {
			    	editPromoName: 'empty',
			    	editPromoCost: 'empty',
			  	}
			});
		    $( function() {
			    var dateFormat = "MM d, yy",
			    	from = $( ".start" ).datepicker({
			    		dateFormat: "MM d, yy",
			    		changeMonth: true,
			          	minDate: new Date(),
			        }).on( "change", function() {
						to.datepicker( "option", "minDate", getDate( this ) );
			        }),
			    	to = $( ".end" ).datepicker({
			    		minDate: new Date(),
			        	changeMonth: true,
			        	dateFormat: "MM d, yy",
			     	}).on( "change", function() {
			        	from.datepicker( "option", "maxDate", getDate( this ) );
			      	});
			 
			    function getDate( element ) {
			    	var date;
			      	try {
			        	date = $.datepicker.parseDate( dateFormat, element.value );
			      	} catch( error ) {
			        	date = null;
			      	}
			      return date;
			    }
			});
		    var products = [
		    	@foreach($pp as $pp)
		    		@if($pp->promoPIsActive==1  && $pp->promoPIsFree==0)
		    			'{{$pp->promoProductId}}',
		    		@endif
		    	@endforeach
		    ];
		    $('#add.ui.dropdown').dropdown('set selected',products);
		    @foreach($pd as $pp)
	    		@if($pp->promoPIsActive==1  && $pp->promoPIsFree==0)
	    			$('#qty{{$promo[0]->promoId}} input[id={{$pp->promoProductId}}]').val({{$pp->promoPQty}});
					var unitTotalCost = {{$pp->product->pvCost}}*{{$pp->promoPQty}};
					$('#total'+{{$pp->promoProductId}}).val(unitTotalCost);
					var totalCost = $("#totalCost").val();
					totalCost = eval(totalCost+"+"+unitTotalCost);
					$("#totalCost").val(totalCost);
				@endif
	    	@endforeach
			// free
			var freeproducts = [
		    	@foreach($freepp as $pp)
		    		@if($pp->promoPIsActive==1 && $pp->promoPIsFree==1)
		    			'{{$pp->promoProductId}}',
		    		@endif
		    	@endforeach
		    ];
		    $('#adds.ui.dropdown').dropdown('set selected',freeproducts);
		    @foreach($freepd as $pp)
	    		@if($pp->promoPIsActive==1 && $pp->promoPIsFree==1)
	    			$('#freeQty{{$promo[0]->promoId}} input[id=free{{$pp->promoProductId}}]').val({{$pp->promoPQty}});
					var unitTotalCost = {{$pp->product->pvCost}}*{{$pp->promoPQty}};
					$('#total'+{{$pp->promoProductId}}).val(unitTotalCost);
					var totalCost = $("#totalCost").val();
					totalCost = eval(totalCost+"+"+unitTotalCost);
					$("#totalCost").val(totalCost);
				@endif
	    	@endforeach
			//service
	    	var services = [
		    	@foreach($ps as $ps)
		    		@if($ps->promoSIsActive==1 && $ps->promoSIsFree==0)
		    			'{{$ps->promoServiceId}}',
		    		@endif
		    	@endforeach
		    ];
			//free
			var freeservices = [
		    	@foreach($freeps as $ps)
		    		@if($ps->promoSIsActive==1 && $ps->promoSIsFree==1)
		    			'{{$ps->promoServiceId}}',
		    		@endif
		    	@endforeach
		    ];
		    $('#serv.ui.dropdown').dropdown('set selected',services);
			$('#servs.ui.dropdown').dropdown('set selected',freeservices);
		});
		function dates(date,name){
			var oldDate = new Date(date);
			var month = oldDate.getMonth()+1;
			if(month<10){
				month = "0"+month;
			}
			var day = oldDate.getDate();
			if(day<10){
				day = "0"+day;
			}
			var year = oldDate.getFullYear();
			var newDate = year+"-"+month+"-"+day;
			$("#"+name).val(newDate);
		}
		function types(type){
			if(type==1){
				$('#supplies').attr("disabled",true);
				$('#supplies').attr("value",0);
				$('.start').attr("disabled",false);
				$('.end').attr("disabled",false);
				$('#supplies').val('');
				$('.start').val('');
				$('.end').val('');
			}if(type==2){
				$('#supplies').attr("disabled",false);
				$('.start').attr("disabled",true);
				$('#start').val('');
				$('.end').attr("disabled",true);
				$('#end').val('');
			}if(type==3){
				$('#supplies').attr("disabled",false);
				$('.start').attr("disabled",false);
				$('.end').attr("disabled",false);
			}
		}
		function lessService(cost){
			var totalCost = $("#totalCost").val();
			totalCost = eval(totalCost+"-"+cost);
			$("#totalCost").val(totalCost);
		}
		function totalService(cost){
			var totalCost = $("#totalCost").val();
			totalCost = eval(cost+"+"+totalCost);
			$("#totalCost").val(totalCost);
		}
		function lessProd(idx,cost){
			var totalCost = $("#totalCost").val();
			var unitTotalCost = $("#total"+idx).val();
			if(unitTotalCost=="" || unitTotalCost==null){
				unitTotalCost = 0;
			}
			totalCost = eval(totalCost+"-"+unitTotalCost);
			$("#totalCost").val(totalCost);
		}
		function totalProd(cost,value,idx){
			var totalCost = $("#totalCost").val();
			var unitTotalCost = $("#total"+idx).val();
			totalCost = eval(totalCost+"-"+unitTotalCost);
			if(value=="" || value==null){
				value = 0;
			}
			var unitCost = eval(cost*value);
			$("#total"+idx).val(unitCost);
			totalCost = eval(totalCost+"+"+unitCost);
			$("#totalCost").val(totalCost);
		}
		function validate(event, idx) {
            var char = String.fromCharCode(event.which);
            var patt = /\d/;
            var res = patt.test(char);
            if (!res) {
                $("input[id="+idx+"]").popup('show');
                return false;
            }
            else {
                $("input[id="+idx+"]").popup('hide');
                
            }
        }
		function validated(event, idx) {
            var char = String.fromCharCode(event.which);
            var patt = /^\d*\.?\d*$/;
            var res = patt.test(char);
            if (!res) {
                $("input[id="+idx+"]").popup('show');
                return false;
            }
            else {
                $("input[id="+idx+"]").popup('hide');
            }
        }
	</script>
@stop