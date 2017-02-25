@extends('layouts.maintenance')

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

	<h2>Maintenance - Product</h2>
	<hr><br>
	<!-- <button class="ui positive button" name="modalNew" onclick="modal(this.name)"><i class="plus icon"></i>New Product</button> -->
	<a class="ui positive button" href="{{URL::to('/maintenance/product/form-create')}}"><i class="plus icon"></i>New Product</a>
	<br><br>
	<table id="list" class="ui celled table">
		<thead>
			<tr>
				<th>Brand</th>
				<th>Product</th>
				<th>Description</th>
				<th>Type</th>
				<th>Variances</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($product as $product)
				@if($product->productIsActive==1)
					<tr>
						<td>{{ $product->brand->brandName }}</td>
						<td>{{ $product->productName }}</td>
						<td>{{ $product->productDesc }}</td>
						<td>{{ $product->types->typeName }}</td>
						<td>
							@foreach($product->variance as $vars)
								@if($vars->pvIsActive==1)
								<?php 
									$price = $vars->pvCost;
									$price = number_format($price,2);
								?>
									<li>{{$vars->variance->varianceSize}} | {{$vars->variance->unit->unitName}} | Php {{$price}}</li>
								@endif
							@endforeach
						</td>
						<td>
							<a href="product/view/{{$product->productId}}" class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="modalUpdate" id="{{ $product->productId }}"><i class="write icon"></i></a>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $product->productId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
						<div class="ui small basic modal" id="del{{ $product->productId }}" style="text-align:center">
							<div class="ui icon header">
								<i class="trash icon"></i>
								Deactivate
							</div>
							{!! Form::open(['action' => 'ProductController@destroy']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="delProductId" value="{{ $product->productId }}">
										<p>
											<label>Product: {{ $product->productName }}</label><br>
											<label>Brand: {{$product->brand->brandName}}</label><br>
											<label>Type: {{$product->types->typeName}}</label>
										</p>
									</div>
								</div>
								<div class="actions">
			        				<button type="submit" class="ui negative button"><i class="trash icon"></i>Deactivate</button>
			        				<button type="reset" class="ui positive button"><i class="plane icon"></i>Cancel</button>
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
		    $('#list').DataTable();
		});
		function update(id){
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
			});
			$.ajax({
				type: "POST",
				url: "{{url('maintenance/product/view')}}",
				data: {'id':id},
				dataType: "JSON",
				success:function(product){
					$('#editProductId').attr('value',id);
					$('#editProductBrandId').val(product.$product[0].brand.brandId);
					$('#editProductBrandName').dropdown('set selected',product.$product[0].brand.brandName);
					$('.menu.edit').attr('id','menu'+id);
					$('#editProductName').attr('value',product.$product[0].productName);
					$('#editProductDesc').text(product.$product[0].productDesc);
					$('.update.variances').attr('id','add'+id);
					$('.cost').attr('id','cost'+id);
					$('.editProductTypeId').attr({id:'drop'+id,value:product.$product[0].types.typeId});
					$('#editProductTypeName').dropdown('set selected',product.$product[0].types.typeName);
					$('#editProductTypeName').attr('title',id);
					reload(id);
					var variance = [];			
					for (var x=0; x < product.$product[0].variance.length; x++) {
						if(product.$product[0].variance[x].pvIsActive==1){
							variance.push(product.$product[0].variance[x].pvVarianceId);
							//$('.cost').append('<label id="'+id+id+'">'+product.$product[0].variance[x].variance.varianceSize+'|'+product.$product[0].variance[x].variance.unit.unitName+'</label><input id="'+id+id+'" type="text" name="costs[]" value="'+product.$product[0].variance[x].pvCost+'">');
						}
					}
					setTimeout(function(){
						$('.update.variances').dropdown('refresh');
						$('.update.variances').dropdown('set selected',variance);
						for (var x=0; x < product.$product[0].variance.length; x++) {
							if(product.$product[0].variance[x].pvIsActive==1){
								// $('.cost').children($('input[id='+product.$product[0].variance[x].pvVarianceId+']')).val(product.$product[0].variance[x].pvCost);
								$('#cost'+id+' input[id='+product.$product[0].variance[x].pvVarianceId+']').val(product.$product[0].variance[x].pvCost);
							}
						}
					},600);
				}
			});
		}
	</script>
@stop