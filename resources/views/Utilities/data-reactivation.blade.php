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

	<h2>Data Activation</h2>
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
		<!-- Category -->
		<h3>Service Category</h3>
		<table id="category" class="ui celled table">
			<thead>
				<tr>
					<th>Service Category</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($service_category as $category)
					@if($category->categoryIsActive==0)
						<td>{{$category->categoryName}}</td>
						<td>{{$category->categoryDesc}}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="refresh{{$category->categoryId}}" onclick="modal(this.name)"><i class="refresh icon"></i></button>
						</td>
						<div class="ui small basic modal" id="refresh{{$category->categoryId}}" style="text-align:center">
							<div class="ui icon header">
								<i class="refresh icon"></i>
								Reactivate
							</div>
							{!! Form::open(['action' => 'ReactivationController@category']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="categoryId" value="{{$category->categoryId }}">
										<p>
											<label>Service Category: {{$category->categoryName}}</label><br>
											<label>Description: {{$category->categoryDesc}}</label>
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
		<!-- Service -->
		<h3>Service</h3>
		<table id="service" class="ui celled table">
			<thead>
				<tr>
					<th>Service</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($service as $service)
					@if($service->serviceIsActive==0)
						<td>{{$service->serviceName}}</td>
						<td>{{$service->serviceDesc}}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="refresh{{$service->serviceId}}" onclick="modal(this.name)"><i class="refresh icon"></i></button>
						</td>
						<div class="ui small basic modal" id="refresh{{$service->serviceId}}" style="text-align:center">
							<div class="ui icon header">
								<i class="refresh icon"></i>
								Reactivate
							</div>
							{!! Form::open(['action' => 'ReactivationController@service']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="serviceId" value="{{$service->serviceId }}">
										<p>
											<label>Service: {{$service->serviceName}}</label><br>
											<label>Description: {{$service->serviceDesc}}</label>
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
		<!-- Inspect Type -->
		<h3>Inspect Type</h3>
		<table id="inspectType" class="ui celled table">
			<thead>
				<tr>
					<th>Inspect Type</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($inspect_type as $inspectType)
					@if($inspectType->inspectTypeIsActive==0)
						<td>{{$inspectType->inspectTypeName}}</td>
						<td>{{$inspectType->inspectTypeDesc}}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="refresh{{$inspectType->inspectTypeId}}" onclick="modal(this.name)"><i class="refresh icon"></i></button>
						</td>
						<div class="ui small basic modal" id="refresh{{$inspectType->inspectTypeId}}" style="text-align:center">
							<div class="ui icon header">
								<i class="refresh icon"></i>
								Reactivate
							</div>
							{!! Form::open(['action' => 'ReactivationController@inspecttype']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="inspectTypeId" value="{{$inspectType->inspectTypeId }}">
										<p>
											<label>Inspect Type: {{$inspectType->inspectTypeName}}</label><br>
											<label>Description: {{$inspectType->inspectTypeDesc}}</label>
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
		<!-- Inspect Item -->
		<h3>Inspect Item</h3>
		<table id="inspectItem" class="ui celled table">
			<thead>
				<tr>
					<th>Inspect Item</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($inspect_item as $inspectItem)
					@if($inspectItem->inspectItemIsActive==0)
						<td>{{$inspectItem->inspectItemName}}</td>
						<td>{{$inspectItem->inspectItemDesc}}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="refresh{{$inspectItem->inspectItemId}}" onclick="modal(this.name)"><i class="refresh icon"></i></button>
						</td>
						<div class="ui small basic modal" id="refresh{{$inspectItem->inspectItemId}}" style="text-align:center">
							<div class="ui icon header">
								<i class="refresh icon"></i>
								Reactivate
							</div>
							{!! Form::open(['action' => 'ReactivationController@inspectitem']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="inspectItemId" value="{{$inspectItem->inspectItemId }}">
										<p>
											<label>Inspect Item: {{$inspectItem->inspectItemName}}</label><br>
											<label>Description: {{$inspectItem->inspectItemDesc}}</label>
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
	<div class="ui tab" data-tab="sales">
		<!-- Package -->
		<h3>Package</h3>
		<table id="package" class="ui celled table">
			<thead>
				<tr>
					<th>Package</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($package as $package)
					@if($package->packageIsActive==0)
						<td>{{$package->packageName}}</td>
						<td>{{$package->packageDesc}}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="refresh{{$package->packageId}}" onclick="modal(this.name)"><i class="refresh icon"></i></button>
						</td>
						<div class="ui small basic modal" id="refresh{{$package->packageId}}" style="text-align:center">
							<div class="ui icon header">
								<i class="refresh icon"></i>
								Reactivate
							</div>
							{!! Form::open(['action' => 'ReactivationController@package']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="packageId" value="{{$package->packageId }}">
										<p>
											<label>Package: {{$package->packageName}}</label><br>
											<label>Description: {{$package->packageDesc}}</label>
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
		<!-- Promo -->
		<h3>Promo</h3>
		<table id="promo" class="ui celled table">
			<thead>
				<tr>
					<th>Promo</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($promo as $promo)
					@if($promo->promoIsActive==0)
						<td>{{$promo->promoName}}</td>
						<td>{{$promo->promoDesc}}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="refresh{{$promo->promoId}}" onclick="modal(this.name)"><i class="refresh icon"></i></button>
						</td>
						<div class="ui small basic modal" id="refresh{{$promo->promoId}}" style="text-align:center">
							<div class="ui icon header">
								<i class="refresh icon"></i>
								Reactivate
							</div>
							{!! Form::open(['action' => 'ReactivationController@promo']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="promoId" value="{{$promo->promoId }}">
										<p>
											<label>Promo: {{$promo->promoName}}</label><br>
											<label>Description: {{$promo->promoDesc}}</label>
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
		<!-- Discount -->
		<h3>Discount</h3>
		<table id="discount" class="ui celled table">
			<thead>
				<tr>
					<th>Discount</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($discount as $discount)
					@if($discount->discountIsActive==0)
						<td>{{$discount->discountName}}</td>
						<td>{{$discount->discountDesc}}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="refresh{{$discount->discountId}}" onclick="modal(this.name)"><i class="refresh icon"></i></button>
						</td>
						<div class="ui small basic modal" id="refresh{{$discount->discountId}}" style="text-align:center">
							<div class="ui icon header">
								<i class="refresh icon"></i>
								Reactivate
							</div>
							{!! Form::open(['action' => 'ReactivationController@discount']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="discountId" value="{{$discount->discountId }}">
										<p>
											<label>Discount: {{$discount->discountName}}</label><br>
											<label>Description: {{$discount->discountDesc}}</label>
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
	<div class="ui tab" data-tab="tech">
		<!-- Tech -->
		<h3>Technician</h3>
		<table id="tech" class="ui celled definition table">
			<thead>
				<tr>
					<th></th>
					<th>Technician</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($technician as $tech)
					@if($tech->techIsActive==0)
						<td><img style="width: 150px;height:150px; object-fit: contain;" src="{{URL::asset($tech->techPic)}}"></td>
						<td>{{$tech->techFirst}} {{$tech->techMiddle}} {{$tech->techLast}}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="refresh{{$tech->techId}}" onclick="modal(this.name)"><i class="refresh icon"></i></button>
						</td>
						<div class="ui small basic modal" id="refresh{{$tech->techId}}" style="text-align:center">
							<div class="ui icon header">
								<i class="refresh icon"></i>
								Reactivate
							</div>
							{!! Form::open(['action' => 'ReactivationController@tech']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="techId" value="{{$tech->techId}}">
										<div class="ui small centered card">
											<div class="image">
												<img src="{{asset($tech->techPic)}}">
											</div>
										</div>
										<p>{{$tech->techFirst}} {{$tech->techMiddle}} {{$tech->techLast}}</p>
										<p>{{$tech->techContact}}</p>
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
		    $('#category').DataTable({
		    	"pageLength": 100,
		    	"paging": false,
		    	"info": false,
		    });
		    $('#service').DataTable({
		    	"pageLength": 100,
		    	"paging": false,
		    	"info": false,
		    });
		    $('#inspectType').DataTable({
		    	"pageLength": 100,
		    	"paging": false,
		    	"info": false,
		    });
		    $('#inspectItem').DataTable({
		    	"pageLength": 100,
		    	"paging": false,
		    	"info": false,
		    });
		    $('#package').DataTable({
		    	"pageLength": 100,
		    	"paging": false,
		    	"info": false,
		    });
		    $('#promo').DataTable({
		    	"pageLength": 100,
		    	"paging": false,
		    	"info": false,
		    });
		    $('#discount').DataTable({
		    	"pageLength": 100,
		    	"paging": false,
		    	"info": false,
		    });
		    $('#tech').DataTable({
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