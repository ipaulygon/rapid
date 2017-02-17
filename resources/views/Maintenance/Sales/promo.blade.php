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

	<h2>Maintenance - Promo</h2>
	<hr><br>
	<button class="ui positive button" name="modalAdd" onclick="modal(this.name)"><i class="plus icon"></i>New Promo</button>
	<br><br>
	<table id="listType" class="ui celled table">
		<thead>
			<tr>
				<th>Promo</th>
				<th class="right aligned">Price</th>
				<th>Description</th>
				<th>Products</th>
				<th>Services</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($promo as $promo)
				@if($promo->promoIsActive==1)
					<tr>
						<?php 
							$price = $promo->promoCost;
							$price = number_format($price,2);
						?>
						<td>{{ $promo->promoName }}</td>
						<td class="right aligned">Php {{ $price }}</td>
						<td>{{ $promo->promoDesc }}</td>
						<td>
							@foreach($promo->product as $pp)
								@if($pp->promoPIsActive==1)
									<li>{{$pp->product->product->brand->brandName}} - {{$pp->product->product->productName}}| {{$pp->product->variance->varianceSize}} - {{$pp->product->variance->unit->unitName}}|{{$pp->product->product->types->typeName}} // {{$pp->promoPQty}} pcs</li>
								@endif
							@endforeach
						</td>
						<td>
							@foreach($promo->service as $ps)
								@if($ps->promoSIsActive==1)
									<li>{{$ps->service->serviceName}} - {{$ps->service->categories->categoryName}}</li>
								@endif
							@endforeach
						</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="modalUpdate" id="{{$promo->promoId}}" onclick="update(this.id),modal(this.name)"><i class="write icon"></i></button>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $promo->promoId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
						<!--Modal for Deactivate-->
						<div class="ui small basic modal" id="del{{ $promo->promoId }}" style="text-align:center">
							<div class="ui icon header">
								<i class="trash icon"></i>
								Deactivate
							</div>
							{!! Form::open(['action' => 'PromoController@destroy']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="delPromoId" value="{{ $promo->promoId }}">
										<p>
											<label>Promo: {{$promo->promoName}}</label><br>
											<label>Description: {{$promo->promoDesc}}</label>
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
	
	<!-- Update Modal -->
	<div class="ui modal" id="modalUpdate">
		<div class="header">Update Promo</div>
		<div class="content">
			<div class="description">
				<div class="ui form">
					{!! Form::open(['action' => 'PromoController@update']) !!}
						<input type="hidden" name="editPromoId" id="editPromoId" readonly>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Promo<span>*</span></label>
	    					</div>
	    					<div class="six wide field">
	    						<input type="text" name="editPromoName" id="editPromoName" placeholder="Promo">
	    					</div>
	    					<div class="two wide field">
	    						<label>Price<span>*</span></label>
	    					</div>
	    					<div class="six wide field">
		    					<div class="ui labeled input">
		    						<div class="ui label">P</div>
		    						<input type="text" name="editPromoCost" id="editPromoCost" placeholder="100">
		    					</div>
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Start Date<span>*</span></label>
	    					</div>
	    					<div class="six wide field">
	    						<input type="date" name="editPromoStart" id="editPromoStart" placeholder="Start Date">
	    					</div>
	    					<div class="two wide field">
	    						<label>End Date</label>
	    					</div>
	    					<div class="six wide field">
	    						<input type="date" name="editPromoEnd" id="editPromoEnd" placeholder="End Date">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Description</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<textarea type="text" name="editPromoDesc" id="editPromoDesc" placeholder="Description"></textarea>
	    					</div>
	    				</div>
	    				<div class="two fields">
	    					<div class="field">
	    						<label>Products:</label>
	    						<div style="width:100%" class="ui multiple update search selection dropdown product">
	    							<input type="hidden" name="editPromoProductId"><i class="dropdown icon"></i>
	    							<input class="search" autocomplete="off" tabindex="0">
	    							<div class="default text">Select Products</div>
	    							<div class="menu edit" tabindex="-1">
	    								@foreach($product as $products)
	    									@if($products->pvIsActive==1)
	    										<div class="item" data-value="{{ $products->pvId }}">{{$products->product->brand->brandName}} - {{$products->product->productName}}| {{$products->variance->varianceSize}} - {{$products->variance->unit->unitName}}| {{$products->product->types->typeName}}</div>
	    									@endif
	    								@endforeach
	    							</div>
	    						</div>
	    						<div class="qty">
	    							<label>Quantity:</label><br>
	    						</div>
	    					</div>
	    					<div class="field">
	    						<label>Services:</label>
	    						<div id="serv" style="width:100%" class="ui multiple update search selection dropdown service">
	    							<input type="hidden" name="editPromoServiceId"><i class="dropdown icon"></i>
	    							<input class="search" autocomplete="off" tabindex="0">
	    							<div class="default text">Select Services</div>
	    							<div class="menu" tabindex="-1">
	    								@foreach($service as $services)
	    									@if($services->serviceIsActive==1)
	    										<div class="item" data-value="{{ $services->serviceId }}">{{$services->serviceName}} - {{$services->categories->categoryName}}</div>
	    									@endif
	    								@endforeach
	    							</div>
	    						</div>
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
	<div class="ui modal" id="modalAdd">
		<div class="header">New Promo</div>
		<div class="content">
			<div class="description">
				<div class="ui form">
					{!! Form::open(['action' => 'PromoController@create']) !!}
						<input type="hidden" name="promoId" value="{{ $newId }}" readonly>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Promo<span>*</span></label>
	    					</div>
	    					<div class="six wide field">
	    						<input type="text" name="promoName" placeholder="Promo">
	    					</div>
	    					<div class="two wide field">
	    						<label>Price<span>*</span></label>
	    					</div>
	    					<div class="six wide field">
		    					<div class="ui labeled input">
		    						<div class="ui label">P</div>
		    						<input type="text" name="promoCost" placeholder="100">
		    					</div>
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Start Date<span>*</span></label>
	    					</div>
	    					<div class="six wide field">
	    						<input type="date" name="promoStart" placeholder="Start Date" min="{{$dateNow}}">
	    					</div>
	    					<div class="two wide field">
	    						<label>End Date</label>
	    					</div>
	    					<div class="six wide field">
	    						<input type="date" name="promoEnd" placeholder="End Date">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Description</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<textarea type="text" name="promoDesc" placeholder="Description"></textarea>
	    					</div>
	    				</div>
	    				<div class="two fields">
	    					<div class="field">
	    						<label>Products:</label>
	    						<div id="add" style="width:100%" class="ui multiple search selection dropdown">
	    							<input type="hidden" name="promoProductId"><i class="dropdown icon"></i>
	    							<input class="search" autocomplete="off" tabindex="0">
	    							<div class="default text">Select Products</div>
	    							<div class="menu" tabindex="-1">
	    								@foreach($product as $product)
	    									@if($product->pvIsActive==1)
	    										<div class="item" title="{{$newId}}" data-value="{{ $product->pvId }}">{{$product->product->brand->brandName}} - {{$product->product->productName}}| {{$product->variance->varianceSize}} - {{$product->variance->unit->unitName}}| {{$product->product->types->typeName}}</div>
	    									@endif
	    								@endforeach
	    							</div>
	    						</div>
	    						<div id="qty{{$newId}}">
	    							<label>Quantity:</label><br>
	    						</div>
	    					</div>
	    					<div class="field">
	    						<label>Services:</label>
	    						<div id="serv" style="width:100%" class="ui multiple search selection dropdown">
	    							<input type="hidden" name="promoServiceId"><i class="dropdown icon"></i>
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
		    $('#listType').DataTable();
		    $('#serv.ui.dropdown').dropdown();
		    $('#add.ui.dropdown').dropdown({
		    	onAdd: function(value,text,$addedChoice){
		    		var prod = $addedChoice.attr('title');
		    		$("#qty"+prod).append('<label id="'+value+'">'+text+'</label><input id="'+value+'" type="text" name="qty[]">');
		    	},
		    	onRemove: function(value, text, $removedChoice){
		    		var prod = $removedChoice.attr('title');
		    		$("#qty"+prod+" input[id="+value+"]").remove();
		    		$("#qty"+prod+" label[id="+value+"]").remove();
		    	}
		    });
		    $('.update.product.ui.dropdown').dropdown({
		    	onAdd: function(value,text,$addedChoice){
		    		var prod = $addedChoice.attr('title');
		    		$("#qty"+prod).append('<label id="'+value+'">'+text+'</label><input id="'+value+'" type="text" name="qtys[]">');
		    	},
		    	onRemove: function(value, text, $removedChoice){
		    		var prod = $removedChoice.attr('title');
		    		$("#qty"+prod+" input[id="+value+"]").remove();
		    		$("#qty"+prod+" label[id="+value+"]").remove();
		    	}
		    });
		});
		function modal(open){
			$('#' + open + '').modal('show');
		}
		function update(id){
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
			});
			$.ajax({
				type: "POST",
				url: "{{url('maintenance/promo/view')}}",
				data: {'id':id},
				dataType: "JSON",
				success:function(promo){
					console.log(promo.$promo[0]);
					$('#editPromoId').attr('value',promo.$promo[0].promoId);
					$('#editPromoName').attr('value',promo.$promo[0].promoName);
					$('#editPromoCost').attr('value',promo.$promo[0].promoCost);
					$('#editPromoStart').attr('value',promo.$promo[0].promoStart);
					$('#editPromoEnd').attr('value',promo.$promo[0].promoEnd);
					$('#editPromoDesc').text(promo.$promo[0].promoDesc);
					$('.update.product').attr('id','add'+id);
					$('.menu.edit').children().attr('title',id);
					$('.qty').attr('id','qty'+id);
					var product = [];
					for(var x=0;x<promo.$promo[0].product.length;x++){
						if(promo.$promo[0].product[x].promoPIsActive==1){
							if(promo.$promo[0].product[x].product.pvIsActive==1){
								product.push(promo.$promo[0].product[x].product.pvId+"");
							}
						}
					}
					$('.update.product').dropdown('clear');
					$('.update.product').dropdown('set selected',product);
					for(var x=0;x<promo.$promo[0].product.length;x++){
						if(promo.$promo[0].product[x].promoPIsActive==1){
							$('#qty'+id+' input[id='+promo.$promo[0].product[x].promoProductId+']').attr('value',promo.$promo[0].product[x].promoPQty);
						}
					}
					$('.update.service').attr('id','serv'+id);
					var service = [];
					for(var x=0;x<promo.$promo[0].service.length;x++){
						if(promo.$promo[0].service[x].promoSIsActive==1){
							if(promo.$promo[0].service[x].service.serviceIsActive==1){
								service.push(promo.$promo[0].service[x].service.serviceId);
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