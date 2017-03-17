@extends('layouts.master')

@section('content')
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

	<h2>Transaction - New Purchase Order</h2>
	<hr><br>

	<div class="ui form">
		{!! Form::open(['action' => 'OrderSupplyController@create']) !!}
			<input type="hidden" name="orderId" value="{{$newId}}" readonly>
			<div class="field">
				<h3>No. {{$newId}}</h3>
			</div>
			<div class="inline fields">
				<div class="two wide field">
					<label>Supplier<span>*</span></label>
				</div>
				<div class="six wide field">
					<div style="width:100%" id="supplier" class="ui search selection dropdown">
						<input type="hidden" name="orderSupplierId"><i class="dropdown icon"></i>
						<input class="search" autocomplete="off" tabindex="0">
						<div class="default text">Select Supplier</div>
						<div class="menu" tabindex="-1">
							@foreach($supplier as $supplier)
								<div class="item" data-value="{{ $supplier->supplierId }}">{{ $supplier->supplierName }}</div>
							@endforeach
						</div>
					</div>
				</div>
				<div class="four wide field"></div>
				<div class="two wide field">
					<label>Date</label>
				</div>
				<div class="two wide field">
					<?php echo date("F d, Y"); ?>
				</div>
			</div>
			<div class="inline fields">
				<div class="two wide field">
					<label>Description</label>
				</div>
				<div class="fourteen wide field">
					<textarea name="orderDesc" placeholder="Description" rows="3"></textarea>
				</div>
			</div>
			<div class="inline fields">
				<div class="two wide field">
					<label>Total cost: PhP</label>
				</div>
				<div class="eight wide field">
					<input id="totalCost" style="border:none;font-weight: bold" type="text" name="totalCost" value="0.00" readonly>
					<input id="totalCosts" style="border:none;font-weight: bold" type="hidden" name="totalCosts" value="0" readonly>
				</div>
			</div>
			<div class="inline fields">
				<div class="two wide field">
					<label>Product</label>
				</div>
				<div class="fourteen wide field">
					<div style="width:100%" id="product" class="ui search multiple selection dropdown">
						<input type="hidden" name="orderProductId"><i class="dropdown icon"></i>
						<input class="search" autocomplete="off" tabindex="0">
						<div class="default text">Select Products</div>
						<div class="menu" tabindex="-1">
							@foreach($products as $product)
								<div class="item" title="{{$product->pvCost}}" data-value="{{ $product->pvId }}">{{$product->product->brand->brandName}} - {{$product->product->productName}}| {{$product->variance->varianceSize}} - {{$product->variance->unit->unitName}}| {{$product->product->types->typeName}}</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
			<table id="list" class="ui celled table">
				<thead>
					<tr>
						<th>Quantity</th>
						<th>Product</th>
						<th>Description</th>
						<th>Unit Price(PhP)</th>
						<th>Total Cost(PhP)</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="tableInsert"></tbody>
			</table>
			<br>
			<hr>
			<i>Note: All with <span>*</span> are required fields</i>
			<div style="float:right">
				<a href="{{URL::to('/transaction/order-supply')}}" type="reset" class="ui negative button"><i class="arrow left icon"></i>Back</a>
				<button type="submit" class="ui positive button"><i class="plus icon"></i>Save</button>
			</div>
		{!! Form::close() !!}
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			var t = $('#list').DataTable({
				pageLength: 100,
				paging: false,
				info: false,
				ordering: false
			});
			$('#tiTitle').attr('class','title active');
			$('#tiContent').attr('class','content active');
			$('#stiTitle').attr('class','title active');
			$('#stiContent').attr('class','content active');
			$('#supplier.ui.dropdown').dropdown();
			$('#product.ui.dropdown').dropdown({
				onAdd:function(value,text,$addedChoice){
					var cost = $addedChoice.attr('title');
					addRow(value,text,cost);
				},
				onRemove:function(value,text,$removedChoice){
					removeRow(value);
				}
			});
			$('.ui.form').form({
			    fields: {
			    	orderSupplierId: 'empty',
			    	orderProductId: 'empty',
			  	}
			});
		});
		function addRow(value,text,cost){
			var t = $('#list').DataTable();
			t.row.add( [
	            '<div class="ui fluid input"><input id="'+value+'" style="text-align:right" name="qty[]" onchange="compute(this.value,this.id)" onkeypress="return validate(event,this.id)" type="text" maxlength="3" data-content="Only numerical values are allowed" required></div>',
	            text,
	            '<div class="ui fluid input"><input name="desc[]" type="text"></div>',
	            '<div class="ui fluid input"><input id="cost'+value+'" style="border:none;text-align:right" type="text" value="'+cost+'" readonly></div>',
	            '<div class="ui fluid input"><input id="total'+value+'" style="border:none;text-align:right" type="text" value="0" readonly></div>',
	            '<span id="'+value+'" onclick="removeRowd(this.id)" class="ui circular icon negative button deleteRow"><i class="ui remove icon"></i></span>',
	        ] ).draw( false );
		}
		function compute(value,idx){
			var cost = $('input[id=cost'+idx+']').val();
			var computed = cost*value;
			var minus = $('input[id=total'+idx+']').val();
			$('input[id=total'+idx+']').val(computed);
			var total = eval($('#totalCosts').val()+"+"+computed+"-"+minus).toFixed(2);
			$('#totalCost').val(total.toLocaleString('en_PH'));
			$('#totalCosts').val(total);
		}
		function removeRow(value){
			var totalCost = $('#totalCosts').val();
			var cost = $('input[id=total'+value+']').val();
			totalCost = eval(totalCost+"-"+cost).toFixed(2);
			$('#totalCost').val(totalCost);
			$('#totalCosts').val(totalCost);
			var t = $('#list').DataTable();
		    t.row( $('input#'+value).parents('tr') ).remove().draw();
		}
		function removeRowd(value){
			var array = [value,"hello"];
			$('#product').dropdown('remove selected',array);
		}
		function validate(event, idx){
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
	</script>
@stop