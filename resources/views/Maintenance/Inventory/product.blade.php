@extends('layouts.master')

@section('content')	
	<!--Create-->	
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
	<button class="ui positive button" name="modalCreate" onclick="modal(this.name)"><i class="plus icon"></i>Add Product</button>
	<br><br>
	<table id="list" class="ui celled four column table">
		<thead>
			<tr>
				<th>Brand</th>
				<th>Product</th>
				<th>Description</th>
				<th>Type</th>
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
							<button class="ui green basic circular icon button" data-tooltip="Update Data" data-inverted="" name="edit{{ $product->productId }}" onclick="modal(this.name)"><i class="write icon"></i></button>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Data" data-inverted="" name="del{{ $product->productId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>
	
	<!--Create Modal-->
	<div class="ui modal" id="modalCreate">
		<div class="header">Create Product</div>
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
	    						<div class="ui search selection dropdown">
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
	    						<div class="ui search selection dropdown">
	    							<input type="hidden" name="productTypeId"><i class="dropdown icon"></i>
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
	    						<label>Variances</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<div class="ui multiple search selection dropdown">
	    							<input type="hidden" name="varianceId[]"><i class="dropdown icon"></i>
	    							<input class="search" autocomplete="off" tabindex="0">
	    							<div class="default text">Select Variances</div>
	    							<div class="menu" tabindex="-1">
	    								@foreach($variance as $var)
	    									@if($var->varianceIsActive==1)
	    										<div class="item" data-value="{{ $var->varianceId }}">{{ $var->varianceSize }} | {{$var->unit->unitName}}</div>
	    									@endif
	    								@endforeach
	    							</div>
	    						</div>
	    					</div>
	    				</div>
	    				<table id="var" class="ui celled four column definition table">
	    					<thead>
	    						<th></th>
	    						<th>Size</th>
	    						<th>Unit</th>
	    						<th>Price</th>
	    					</thead>
	    					<tbody>
	    						@foreach($variance as $var)
	    							@if($var->varianceIsActive==1)
	    								<tr>
	    									<td>
	    										<div class="ui slider checkbox">
	    											<input type="checkbox" name="{{$var->varianceId}}">
	    										</div>
	    									</td>
	    									<td>{{$var->varianceSize}}</td>
	    									<td>{{$var->unit->unitName}}</td>
	    									<td><input type="text" id="{{$var->varianceId}}" name="price[]" disabled></td>
	    								</tr>
	    							@endif
	    						@endforeach
	    					</tbody>
	    				</table>
	    				<div class="actions">
	    					<i>Note: All with <span>*</span> are required fields</i>
	    					<button type="reset" class="ui negative button"><i class="remove icon"></i>Clear</button>
	    					<button type="submit" class="ui positive button"><i class="plus icon"></i>Create</button>
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
		    $('#var').DataTable();
		    $('.ui.dropdown').dropdown();
		});
		function modal(open){
			$('#' + open + '').modal('show');
		}
	</script>
@stop