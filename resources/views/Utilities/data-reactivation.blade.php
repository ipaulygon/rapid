@extends('layouts.master')

@section('content')
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

	<h2>Data Reactivation</h2>
	<hr><br>
	<div class="ui secondary pointing menu">
		<a class="item active" data-tab="inventory">Inventory</a>
		<a class="item" data-tab="carcare">Car Care</a>
		<a class="item" data-tab="sales">Sales</a>
		<a class="item" data-tab="tech">Tehnician</a>
	</div>
	<div class="ui tab active" data-tab="inventory">
		<!-- Supplier -->
		<h3>Supplier</h3>
		<table id="supplier" class="ui celled table">
			<thead>
				<tr>
					<th>Supplier</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($supplier as $supplier)
					@if($supplier->supplierIsActive==0)
						<td>{{$supplier->supplierName}}</td>
						<td>{{$supplier->supplierDesc}}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="refresh{{$supplier->supplierId}}" onclick="modal(this.name)"><i class="refresh icon"></i></button>
						</td>
						<div class="ui small basic modal" id="refresh{{$supplier->supplierId}}" style="text-align:center">
							<div class="ui icon header">
								<i class="refresh icon"></i>
								Reactivate
							</div>
							{!! Form::open(['action' => 'ReactivationController@supplier']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="supplierId" value="{{$supplier->supplierId }}">
										<p>
											<label>Supplier: {{$supplier->supplierName}}</label><br>
											<label>Description: {{$supplier->supplierDesc}}</label>
										</p>
									</div>
								</div>
								<div class="actions">
			        				<button type="submit" class="ui positive button"><i class="refresh icon"></i>Reactivate</button>
			        				<button type="reset" class="ui negative button"><i class="remove icon"></i>Cancel</button>
			        			</div>
							{!! Form::close() !!}
						</div>
					@endif
				@endforeach
			</tbody>
		</table>
		<!-- Brand -->
		<h3>Brand</h3>
		<table id="brand" class="ui celled table">
			<thead>
				<tr>
					<th>Brand</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($brand as $brand)
					@if($brand->brandIsActive==0)
						<td>{{$brand->brandName}}</td>
						<td>{{$brand->brandDesc}}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="refresh{{$brand->brandId}}" onclick="modal(this.name)"><i class="refresh icon"></i></button>
						</td>
						<div class="ui small basic modal" id="refresh{{$brand->brandId}}" style="text-align:center">
							<div class="ui icon header">
								<i class="refresh icon"></i>
								Reactivate
							</div>
							{!! Form::open(['action' => 'ReactivationController@brand']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="brandId" value="{{$brand->brandId }}">
										<p>
											<label>Brand: {{$brand->brandName}}</label><br>
											<label>Description: {{$brand->brandDesc}}</label>
										</p>
									</div>
								</div>
								<div class="actions">
			        				<button type="submit" class="ui positive button"><i class="refresh icon"></i>Reactivate</button>
			        				<button type="reset" class="ui negative button"><i class="remove icon"></i>Cancel</button>
			        			</div>
							{!! Form::close() !!}
						</div>
					@endif
				@endforeach
			</tbody>
		</table>
		<!-- Product Type -->
		<h3>Product Type</h3>
		<table id="prodtype" class="ui celled table">
			<thead>
				<tr>
					<th>Product Type</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($product_type as $type)
					@if($type->typeIsActive==0)
						<td>{{$type->typeName}}</td>
						<td>{{$type->typeDesc}}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="refresh{{$type->typeId}}" onclick="modal(this.name)"><i class="refresh icon"></i></button>
						</td>
						<div class="ui small basic modal" id="refresh{{$type->typeId}}" style="text-align:center">
							<div class="ui icon header">
								<i class="refresh icon"></i>
								Reactivate
							</div>
							{!! Form::open(['action' => 'ReactivationController@producttype']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="typeId" value="{{$type->typeId }}">
										<p>
											<label>Product Type: {{$type->typeName}}</label><br>
											<label>Description: {{$type->typeDesc}}</label>
										</p>
									</div>
								</div>
								<div class="actions">
			        				<button type="submit" class="ui positive button"><i class="refresh icon"></i>Reactivate</button>
			        				<button type="reset" class="ui negative button"><i class="remove icon"></i>Cancel</button>
			        			</div>
							{!! Form::close() !!}
						</div>
					@endif
				@endforeach
			</tbody>
		</table>
		<!-- Unit -->
		<h3>Unit</h3>
		<table id="unit" class="ui celled table">
			<thead>
				<tr>
					<th>Unit</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($unit as $unit)
					@if($unit->unitIsActive==0)
						<td>{{$unit->unitName}}</td>
						<td>{{$unit->unitDesc}}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="refresh{{$unit->unitId}}" onclick="modal(this.name)"><i class="refresh icon"></i></button>
						</td>
						<div class="ui small basic modal" id="refresh{{$unit->unitId}}" style="text-align:center">
							<div class="ui icon header">
								<i class="refresh icon"></i>
								Reactivate
							</div>
							{!! Form::open(['action' => 'ReactivationController@unit']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="unitId" value="{{$unit->unitId }}">
										<p>
											<label>Unit: {{$unit->unitName}}</label><br>
											<label>Description: {{$unit->unitDesc}}</label>
										</p>
									</div>
								</div>
								<div class="actions">
			        				<button type="submit" class="ui positive button"><i class="refresh icon"></i>Reactivate</button>
			        				<button type="reset" class="ui negative button"><i class="remove icon"></i>Cancel</button>
			        			</div>
							{!! Form::close() !!}
						</div>
					@endif
				@endforeach
			</tbody>
		</table>
		<!-- Variance -->
		<h3>Variance</h3>
		<table id="variance" class="ui celled table">
			<thead>
				<tr>
					<th>Variance</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($variance as $variance)
					@if($variance->varianceIsActive==0)
						<td>{{$variance->varianceName}}</td>
						<td>{{$variance->varianceDesc}}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="refresh{{$variance->varianceId}}" onclick="modal(this.name)"><i class="refresh icon"></i></button>
						</td>
						<div class="ui small basic modal" id="refresh{{$variance->varianceId}}" style="text-align:center">
							<div class="ui icon header">
								<i class="refresh icon"></i>
								Reactivate
							</div>
							{!! Form::open(['action' => 'ReactivationController@variance']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="varianceId" value="{{$variance->varianceId }}">
										<p>
											<label>Variance: {{$variance->varianceName}}</label><br>
											<label>Description: {{$variance->varianceDesc}}</label>
										</p>
									</div>
								</div>
								<div class="actions">
			        				<button type="submit" class="ui positive button"><i class="refresh icon"></i>Reactivate</button>
			        				<button type="reset" class="ui negative button"><i class="remove icon"></i>Cancel</button>
			        			</div>
							{!! Form::close() !!}
						</div>
					@endif
				@endforeach
			</tbody>
		</table>
		<!-- Product -->
		<h3>Product</h3>
		<table id="product" class="ui celled table">
			<thead>
				<tr>
					<th>Product</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($product as $product)
					@if($product->productIsActive==0)
						<td>{{$product->productName}}</td>
						<td>{{$product->productDesc}}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="refresh{{$product->productId}}" onclick="modal(this.name)"><i class="refresh icon"></i></button>
						</td>
						<div class="ui small basic modal" id="refresh{{$product->productId}}" style="text-align:center">
							<div class="ui icon header">
								<i class="refresh icon"></i>
								Reactivate
							</div>
							{!! Form::open(['action' => 'ReactivationController@product']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="productId" value="{{$product->productId }}">
										<p>
											<label>Product: {{$product->productName}}</label><br>
											<label>Description: {{$product->productDesc}}</label>
										</p>
									</div>
								</div>
								<div class="actions">
			        				<button type="submit" class="ui positive button"><i class="refresh icon"></i>Reactivate</button>
			        				<button type="reset" class="ui negative button"><i class="remove icon"></i>Cancel</button>
			        			</div>
							{!! Form::close() !!}
						</div>
					@endif
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="ui tab" data-tab="carcare">
		Second
	</div>
	<div class="ui tab" data-tab="sales">
		Third
	</div>
	<div class="ui tab" data-tab="tech">
		Third
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
		    $('#supplier').DataTable({
		    	"pageLength": 100,
		    	"paging": false,
		    	"info": false,
		    });
		    $('#brand').DataTable({
		    	"pageLength": 100,
		    	"paging": false,
		    	"info": false,
		    });
		    $('#prodtype').DataTable({
		    	"pageLength": 100,
		    	"paging": false,
		    	"info": false,
		    });
		    $('#unit').DataTable({
		    	"pageLength": 100,
		    	"paging": false,
		    	"info": false,
		    });
		    $('#variance').DataTable({
		    	"pageLength": 100,
		    	"paging": false,
		    	"info": false,
		    });
		    $('#product').DataTable({
		    	"pageLength": 100,
		    	"paging": false,
		    	"info": false,
		    });
		    $('.menu .item').tab();
		});
		function modal(open){
			$('#' + open + '').modal('show');
		}
	</script>
@stop