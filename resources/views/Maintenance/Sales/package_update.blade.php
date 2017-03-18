@extends('layouts.master')

@section('content')
	<h2>Maintenance - Update Package</h2>
	<hr><br>

	<div class="ui form">
		{!! Form::open(['action' => 'PackageController@update']) !!}
			<input type="hidden" name="editPackageId" value="{{ $package[0]->packageId }}" readonly>
			<div class="ui error message"></div>
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
					<li>Package already exists. Update failed.</li>
				</div>
			@endif	
			<div class="inline fields">
				<div class="two wide field">
					<label>Package<span>*</span></label>
				</div>
				<div class="six wide field">
					<input maxlength="140" type="text" name="editPackageName" value="{{ $package[0]->packageName }}" placeholder="Package">
				</div>
				<div class="two wide field">
					<label>Price<span>*</span></label>
				</div>
				<div class="six wide field">
					<div class="ui labeled input">
						<div class="ui label">Php</div>
						<input style="text-align:right" type="text" id="editPackageCost" name="editPackageCost" onkeypress="return validated(event,this.id)" data-content="Only numerical values are allowed" maxlength="8" value="{{ $package[0]->packageCost }}" placeholder="Price">
					</div>
				</div>
			</div>
			<div class="inline fields">
				<div class="two wide field">
					<label>Description</label>
				</div>
				<div class="six wide field">
					<textarea maxlength="140" type="text" name="editPackageDesc" placeholder="Description" rows="2">{{ $package[0]->packageDesc }}</textarea>
				</div>
				<div class="two wide field">
					<label>Total Cost of Items:</label>
				</div>
				<div class="six wide field">
					Php <input style="border:none" id="totalCost" type="text" readonly value="0">
				</div>
			</div>
			<div class="three fields">
				<div class="field">
					<label>Products:</label>
					<div id="add" style="width:100%" class="ui multiple search selection dropdown">
						<input type="hidden" name="editPackageProductId"><i class="dropdown icon"></i>
						<input class="search" autocomplete="off" tabindex="0">
						<div class="default text">Select Products</div>
						<div class="menu" tabindex="-1">
							@foreach($product as $product)
								@if($product->pvIsActive==1)
									<div class="item" id="{{$product->pvCost}}" title="{{$package[0]->packageId}}" data-value="{{ $product->pvId }}">{{$product->product->brand->brandName}} - {{$product->product->productName}}| {{$product->variance->varianceSize}} - {{$product->variance->unit->unitName}}| {{$product->product->types->typeName}}</div>
								@endif
							@endforeach
						</div>
					</div>
				</div>
				<div class="field" id="qty{{$package[0]->packageId}}">
					<label>Quantity:</label>
				</div>
				<div class="field">
					<label>Services:</label>
					<div id="serv" style="width:100%" class="ui multiple search selection dropdown">
						<input type="hidden" name="editPackageServiceId"><i class="dropdown icon"></i>
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
			<hr>
			<i>Note: All with <span>(*)</span> are required fields</i>
			<div style="float:right">
				<a href="{{URL::to('/maintenance/package')}}" type="reset" class="ui negative button"><i class="arrow left icon"></i>Back</a>
				<button type="submit" class="ui primary button"><i class="plus icon"></i>Save</button>
			</div>
		{!! Form::close() !!}
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			$('#mTitle').attr('class','title header active');
			$('#mContent').attr('class','content active');
			$('#smTitle').attr('class','title header active');
			$('#smContent').attr('class','content active');
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
		    $('.ui.form').form({
			    fields: {
			    	editPackageName: 'empty',
			    	editPackageCost: 'empty',
			  	}
			});
		    var products = [
		    	@foreach($pp as $pp)
		    		@if($pp->packagePIsActive==1)
		    			'{{$pp->packageProductId}}',
		    		@endif
		    	@endforeach
		    ];
		    $('#add.ui.dropdown').dropdown('set selected',products);
		    @foreach($pd as $pp)
	    		@if($pp->packagePIsActive==1)
	    			$('#qty{{$package[0]->packageId}} input[id={{$pp->packageProductId}}]').val({{$pp->packagePQty}});
					var unitTotalCost = {{$pp->product->pvCost}}*{{$pp->packagePQty}};
					$('#total'+{{$pp->packageProductId}}).val(unitTotalCost);
					var totalCost = $("#totalCost").val();
					totalCost = eval(totalCost+"+"+unitTotalCost);
					$("#totalCost").val(totalCost);
				@endif
	    	@endforeach
	    	var services = [
		    	@foreach($ps as $ps)
		    		@if($ps->packageSIsActive==1)
		    			'{{$ps->packageServiceId}}',
		    		@endif
		    	@endforeach
		    ];
		    $('#serv.ui.dropdown').dropdown('set selected',services);
		});
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
                
            }as
        }
	</script>
@stop