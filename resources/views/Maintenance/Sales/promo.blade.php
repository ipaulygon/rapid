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
	<table id="listType" class="ui celled six column table">
		<thead>
			<tr>
				<th>Promo</th>
				<th>Price</th>
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
						<td>{{ $promo->promoName }}</td>
						<td class="right aligned">Php {{ $promo->promoCost }}</td>
						<td>{{ $promo->promoDesc }}</td>
						<td>
							@foreach($promo->product as $pp)
								@if($pp->promoPIsActive==1)
									<li>{{$pp->product->product->brand->brandName}} - {{$pp->product->product->productName}}| {{$pp->product->variance->varianceSize}} - {{$pp->product->variance->unit->unitName}}|{{$pp->product->product->types->typeName}}</li>
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
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="edit{{ $promo->promoId }}" onclick="modal(this.name)"><i class="write icon"></i></button>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $promo->promoId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
						<!--Modal for Update-->
						<div class="ui small modal" id="edit{{ $promo->promoId }}">
							<div class="header">Update Promo</div>
							{!! Form::open(['action' => 'PromoController@update']) !!}	
								<div class="content">
									<div class="description">
										<div class="ui form">								
											<input type="hidden" name="editPromoId" value="{{ $promo->promoId }}" readonly>
						    				<div class="inline fields">
						    					<div class="two wide field">
						    						<label>Promo<span>*</span></label>
						    					</div>
						    					<div class="six wide field">
						    						<input type="text" name="editPromoName" value="{{ $promo->promoName }}" placeholder="Promo">
						    					</div>
						    					<div class="two wide field">
						    						<label>Price<span>*</span></label>
						    					</div>
						    					<div class="six wide field">
							    					<div class="ui labeled input">
							    						<div class="ui label">P</div>
							    						<input type="text" name="editPromoCost" value="{{ $promo->promoCost }}" placeholder="100">
							    					</div>
						    					</div>
						    				</div>
						    				<div class="inline fields">
						    					<div class="two wide field">
						    						<label>Start Date<span>*</span></label>
						    					</div>
						    					<div class="six wide field">
						    						<input type="date" name="editPromoStart" placeholder="Start Date" min="{{$dateNow}}" value="{{ $promo->promoStart }}">
						    					</div>
						    					<div class="two wide field">
						    						<label>End Date</label>
						    					</div>
						    					<div class="six wide field">
						    						<input type="date" name="editPromoEnd" placeholder="End Date" value="{{ $promo->promoEnd }}">
						    					</div>
						    				</div>
						    				<div class="inline fields">
						    					<div class="two wide field">
						    						<label>Description</label>
						    					</div>
						    					<div class="fourteen wide field">
						    						<textarea type="text" name="editPromoDesc" placeholder="Description">{{ $promo->promoDesc }}</textarea>
						    					</div>
						    				</div>
						    				<div class="two fields">
						    					<div class="field">
						    						<label>Products:</label>
						    						<div id="add{{$promo->promoId}}" style="width:100%" class="ui multiple search selection dropdown">
						    							<input type="hidden" name="editPromoProductId"><i class="dropdown icon"></i>
						    							<input class="search" autocomplete="off" tabindex="0">
						    							<div class="default text">Select Products</div>
						    							<div class="menu" tabindex="-1">
						    								@foreach($product as $products)
						    									@if($products->pvIsActive==1)
						    										<div class="item" title="{{$promo->promoId}}" data-value="{{ $products->pvId }}">{{$products->product->brand->brandName}} - {{$products->product->productName}}| {{$products->variance->varianceSize}} - {{$products->variance->unit->unitName}}| {{$products->product->types->typeName}}</div>
						    									@endif
						    								@endforeach
						    							</div>
						    						</div>
						    						<div id="qty{{$promo->promoId}}">
						    							<label>Quantity:</label><br>
						    						</div>
						    					</div>
						    					<div class="field">
						    						<label>Services:</label>
						    						<div id="serv{{$promo->promoId}}" style="width:100%" class="ui multiple search selection dropdown">
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
										</div>
									</div>
								</div>
								<div class="actions">
									<i>Note: All with <span>*</span> are required fields</i>
		        					<button type="reset" class="ui negative button"><i class="remove icon"></i>Clear</button>
		        					<button type="submit" class="ui positive button"><i class="write icon"></i>Update</button>
		        				</div>
	        				{!! Form::close() !!}
	        				<script type="text/javascript">
	        					var array = [
	        						@foreach($product as $products)
	        							@if($products->pvIsActive==1)
	        								'{{$products->pvId}}',
	        							@endif
	        						@endforeach
	        					];
	        					$('#add{{$promo->promoId}}').dropdown('set selected',array);
	        				</script>
						</div>
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
	    					<button type="reset" class="ui negative button"><i class="remove icon"></i>Clear</button>
	    					<button type="submit" class="ui positive button"><i class="plus icon"></i>Add</button>
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
		});
		function modal(open){
			$('#' + open + '').modal('show');
		}
		
	</script>
@stop