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

	<h2>Maintenance - Package</h2>
	<hr><br>
	<a href="{{URL::to('maintenance/package/form-create')}}" class="ui primary button" name="modalAdd"><i class="plus icon"></i>New Package</a>
	<br><br>
	<table id="listType" class="ui celled table">
		<thead>
			<tr>
				<th>Package</th>
				<th class="right aligned">Price (PhP)</th>
				<th>Products</th>
				<th>Services</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($package as $package)
				@if($package->packageIsActive==1)
					<tr>
						<?php 
							$price = $package->packageCost;
							$price = number_format($price,2);
						?>
						<td>{{ $package->packageName }}</td>
						<td class="right aligned">{{ $price }}</td>
						<td>
							@foreach($package->product as $pp)
								@if($pp->packagePIsActive==1)
									<li>{{$pp->product->product->brand->brandName}} - {{$pp->product->product->productName}}| {{$pp->product->variance->varianceSize}} - {{$pp->product->variance->unit->unitName}}|{{$pp->product->product->types->typeName}} <br> x {{$pp->packagePQty}} pcs</li>
								@endif
							@endforeach
						</td>
						<td>
							@foreach($package->service as $ps)
								@if($ps->packageSIsActive==1)
									<li>{{$ps->service->serviceName}}</li>
								@endif
							@endforeach
						</td>
						<td>
							<a href="package/view/{{$package->packageId}}" class="ui primary basic circular icon button" data-tooltip="Update Record" data-inverted="" name="modalUpdate" id="{{$package->packageId}}"><i class="write icon"></i></a>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $package->packageId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
						<!--Modal for Deactivate-->
						<div class="ui small basic modal" id="del{{ $package->packageId }}" style="text-align:center">
							<div class="ui icon header">
								<i class="trash icon"></i>
								Deactivate
							</div>
							{!! Form::open(['action' => 'PackageController@destroy']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="delPackageId" value="{{ $package->packageId }}">
										<p>
											<label>Package: {{$package->packageName}}</label><br>
											<label>Description: {{$package->packageDesc}}</label>
										</p>
									</div>
								</div>
								<div class="actions">
			        				<button type="submit" class="ui negative button"><i class="trash icon"></i>Deactivate</button>
			        				<button type="reset" class="ui primary button"><i class="remove icon"></i>Cancel</button>
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
		function update(id){
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
			});
			$.ajax({
				type: "POST",
				url: "{{url('maintenance/package/view')}}",
				data: {'id':id},
				dataType: "JSON",
				success:function(package){
					console.log(package.$package[0]);
					$('#editPackageId').attr('value',package.$package[0].packageId);
					$('#editPackageName').attr('value',package.$package[0].packageName);
					$('#editPackageCost').attr('value',package.$package[0].packageCost);
					$('#editPackageDesc').text(package.$package[0].packageDesc);
					$('.update.product').attr('id','add'+id);
					$('.menu.edit').children().attr('title',id);
					$('.qty').attr('id','qty'+id);
					var product = [];
					for(var x=0;x<package.$package[0].product.length;x++){
						if(package.$package[0].product[x].packagePIsActive==1){
							if(package.$package[0].product[x].product.pvIsActive==1){
								product.push(package.$package[0].product[x].product.pvId+"");
							}
						}
					}
					$('.update.product').dropdown('clear');
					$('.update.product').dropdown('set selected',product);
					for(var x=0;x<package.$package[0].product.length;x++){
						if(package.$package[0].product[x].packagePIsActive==1){
							$('#qty'+id+' input[id='+package.$package[0].product[x].packageProductId+']').attr('value',package.$package[0].product[x].packagePQty);
						}
					}
					$('.update.service').attr('id','serv'+id);
					var service = [];
					for(var x=0;x<package.$package[0].service.length;x++){
						if(package.$package[0].service[x].packageSIsActive==1){
							if(package.$package[0].service[x].service.serviceIsActive==1){
								service.push(package.$package[0].service[x].service.serviceId);
							}
						}
					}
					$('.update.service').dropdown('clear');
					$('.update.service').dropdown('set selected',service);
				}
			});
		}
	</script>
@stop