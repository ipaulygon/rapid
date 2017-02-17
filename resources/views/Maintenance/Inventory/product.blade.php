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
	<button class="ui positive button" name="modalNew" onclick="modal(this.name)"><i class="plus icon"></i>New Product</button>
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
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="modalUpdate" id="{{ $product->productId }}" onclick="update(this.id),modal(this.name)"><i class="write icon"></i></button>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $product->productId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
						<!--Modal for Update-->
						
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
	
	<!--Update Modal-->
	<div class="ui small modal" id="modalUpdate">
		<div class="header">Update Product</div>
		<div class="content">
			<div class="description">
				<div class="ui form">
					{!! Form::open(['action' => 'ProductController@update']) !!}
						<input type="hidden" id="editProductId" name="editProductId" readonly>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Brand<span>*</span></label>
	    					</div>
	    					<div class="six wide field">
	    						<div id="editProductBrandName" class="ui search selection dropdown">
	    							<input id="editProductBrandId" type="hidden" name="editProductBrandId"><i class="dropdown icon"></i>
	    							<input class="search" autocomplete="off" tabindex="0">
	    							<div class="default text">Select Brand</div>
	    							<div class="menu" tabindex="-1">
	    								@foreach($brand as $brands)
	    									@if($brands->brandIsActive==1)
	    										<div class="item" data-value="{{ $brands->brandId }}">{{ $brands->brandName }}</div>
	    									@endif
	    								@endforeach
	    							</div>
	    						</div>
	    					</div>
	    					<div class="two wide field">
	    						<label>Type<span>*</span></label>
	    					</div>
	    					<div class="six wide field">
	    						<div id="editProductTypeName" class="ui search selection dropdown" onchange="reload(this.title)">
	    							<input class="editProductTypeId" type="hidden" name="editProductTypeId"><i class="dropdown icon"></i>
	    							<input class="search" autocomplete="off" tabindex="0">
	    							<div class="default text">Select Type</div>
	    							<div class="menu" tabindex="-1">
	    								@foreach($type as $types)
	    									@if($types->typeIsActive==1)
	    										<div class="item" data-value="{{ $types->typeId }}">{{ $types->typeName }}</div>
	    									@endif
	    								@endforeach
	    							</div>
	    						</div>
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Product<span>*</span></label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<input id="editProductName" type="text" name="editProductName" placeholder="Product">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Description</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<textarea id="editProductDesc" type="text" name="editProductDesc" placeholder="Description"></textarea>
	    					</div>
	    				</div>
	    				<div class="two fields">
	    					<div class="field">
	    						<label>Variances</label>
	    						<div style="width:100%" class="ui multiple update search selection dropdown variances">
	    							<input type="hidden" name="editVariance"><i class="dropdown icon"></i>
	    							<input class="search" autocomplete="off" tabindex="0">
	    							<div class="default text">Select Variances</div>
	    							<div class="menu edit" tabindex="-1"></div>
	    						</div>
	    					</div>
	    					<div class="field">
	    						<div class="cost" class="sixteen wide field"></div>
	    					</div>
	    				</div>
	    				<div class="actions">
	    					<i>Note: All with <span>*</span> are required fields</i>
	    					<button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
	    					<button type="submit" class="ui positive button"><i class="plus icon"></i>Update</button>
	    				</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>

	<!--Add Modal-->
	<div class="ui small modal" id="modalNew">
		<div class="header">New Product</div>
		<div class="content">
			<div class="description">
				<div class="ui form">
					{!! Form::open(['action' => 'ProductController@create']) !!}
						<input type="hidden" name="productId" value="{{ $newId }}" readonly>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Brand<span>*</span></label>
	    					</div>
	    					<div class="six wide field">
	    						<div id="brand" class="ui search selection dropdown">
	    							<input type="hidden" name="productBrandId"><i class="dropdown icon"></i>
	    							<input class="search" autocomplete="off" tabindex="0">
	    							<div class="default text">Select Brand</div>
	    							<div class="menu" tabindex="-1">
	    								@foreach($brand as $brand)
	    									@if($brand->brandIsActive==1)
	    										<div class="item" data-value="{{ $brand->brandId }}">{{ $brand->brandName }}</div>
	    									@endif
	    								@endforeach
	    							</div>
	    						</div>
	    					</div>
	    					<div class="two wide field">
	    						<label>Type<span>*</span></label>
	    					</div>
	    					<div class="six wide field">
	    						<div id="type" class="ui search selection dropdown" title="{{$newId}}" onchange="reload(this.title)">
	    							<input id="drop{{$newId}}" type="hidden" name="productTypeId"><i class="dropdown icon"></i>
	    							<input class="search" autocomplete="off" tabindex="0">
	    							<div class="default text">Select Type</div>
	    							<div class="menu" tabindex="-1">
	    								@foreach($type as $type)
	    									@if($type->typeIsActive==1)
	    										<div class="item" data-value="{{ $type->typeId }}">{{ $type->typeName }}</div>
	    									@endif
	    								@endforeach
	    							</div>
	    						</div>
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Product<span>*</span></label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<input type="text" name="productName" placeholder="Product">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Description</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<textarea type="text" name="productDesc" placeholder="Description"></textarea>
	    					</div>
	    				</div>
	    				<div class="two fields">
	    					<div class="field">
	    						<label>Variances</label>
	    						<div id="add{{$newId}}" style="width:100%" class="ui multiple add search selection dropdown">
	    							<input id="variances" type="hidden" name="variance"><i class="dropdown icon"></i>
	    							<input class="search" autocomplete="off" tabindex="0">
	    							<div class="default text">Select Variances</div>
	    							<div id="menu{{$newId}}" class="menu" tabindex="-1"></div>
	    						</div>
	    					</div>
	    					<div class="field">
	    						<div id="cost{{$newId}}" class="sixteen wide field"></div>
	    					</div>
	    				</div>
	    				<div class="actions">
	    					<i>Note: All with <span>*</span> are required fields</i>
	    					<button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
	    					<button type="submit" class="ui positive button"><i class="plus icon"></i>Save</button>
	    				</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@stop


@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
		    $('#list').DataTable();
		    $('#brand.ui.dropdown').dropdown();
		    $('#type.ui.dropdown').dropdown();
		    $('.add.ui.dropdown').dropdown({
		    	onAdd: function(value,text,$addedChoice){
		    		var prod = $addedChoice.attr('title');
		    		$("#cost"+prod).append('<label id="'+value+'">'+text+'</label><input id="'+value+'" type="text" name="cost[]">');
		    	},
		    	onRemove: function(value, text, $removedChoice){
		    		var prod = $removedChoice.attr('title');
		    		$("#cost"+prod+" input[id="+value+"]").remove();
		    		$("#cost"+prod+" label[id="+value+"]").remove();
		    	}
		    });
		    $('.update.ui.dropdown').dropdown({
		    	onAdd: function(value,text,$addedChoice){
		    		var prod = $addedChoice.attr('title');
		    		$("#cost"+prod).append('<label id="'+value+'">'+text+'</label><input id="'+value+'" type="text" name="costs[]" value="">');
		    	},
		    	onRemove: function(value, text, $removedChoice){
		    		var prod = $removedChoice.attr('title');
		    		$("#cost"+prod+" input[id="+value+"]").remove();
		    		$("#cost"+prod+" label[id="+value+"]").remove();
		    	}
		    });
		    update("PROD0001");
		    $('#modalUpdate').modal('refresh');

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
					},700);
					
				}
			});
		}
		function reload(title){
			$(".item#"+title).remove();
			$("#cost"+title+" input").remove();
			$("#cost"+title+" label").remove();
			$("#add"+title).dropdown('clear');
			var id = $("#drop"+title).val();
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
			});
			$.ajax({
				type: "POST",
				url: "{{url('maintenance/product/type')}}",
				data: {'id':id},
				dataType: "JSON",
				success:function(data){
					for(var x=0;x<data.data.length;x++){
						$("#menu"+title).append('<div class="item" data-value="'+data.data[x].variance["varianceId"]+'" id="'+title+'" title="'+title+'">'+data.data[x].variance["varianceSize"]+'|'+data.data[x].variance.unit["unitName"]+'</div>');
					}
				}
			});
		}
		function modal(open){
			$('#' + open + '').modal('show');
		}
	</script>
@stop