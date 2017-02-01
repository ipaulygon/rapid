@extends('layouts.master')

@section('content')
	<!--Create Success-->	
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
	<button style="float:right" class="ui green basic button" name="modalCreate" onclick="modal(this.name)"><i class="plus icon"></i>Add Product</button>
	<br><br>
	<table id="list" class="ui celled table">
		<thead>
			<tr>
				<th>Type</th>
				<th>Brand</th>
				<th>Product</th>
				<th>Description</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($product as $prod)
				@if($prod->productIsActive==1)
					<tr>
						<td>{{ $prod->types->typeName }}</td>
						<td>{{ $prod->brand->brandName }}</td>
						<td>{{ $prod->productName }}</td>
						<td>{{ $prod->productDesc }}</td>
						<td>
							<button class="ui green basic button" name="edit{{ $prod->productId }}" onclick="modal(this.name)"><i class="write icon"></i>Edit</button>
							<button class="ui red basic button" name="del{{ $prod->productId }}" onclick="modal(this.name)"><i class="trash icon"></i>Delete</button>
						</td>
						<!--Modal for Edit-->
						<div class="ui small modal" id="edit{{ $prod->productId }}">
							<div class="header">Edit Product</div>
							{!! Form::open(['action' => 'ProductController@update']) !!}
								<div class="content">
									<div class="description">
										<div class="ui form">						
				        					<input type="hidden" name="editId" value="{{ $prod->productId }}">
					        				<div class="inline fields">
					        					<div class="two wide field">
													<label>Brand</label>
												</div>
												<div id="editSearch" class="ui search six wide field">
													<div class="ui icon input">
														<input class="prompt" type="text" name="editProdBrand" value="{{ $prod->brand->brandName }}" placeholder="Brand">
													</div>
													<div class="results"></div>
												</div>
					        					<div class="two wide field">
					        						<label>Product</label>
					        					</div>
					        					<div class="six wide field">
					        						<input type="text" name="editProdName" value="{{ $prod->productName }}" placeholder="Product">
					        					</div>
					        				</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Description</label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<input type="text" name="editProdDesc" value="{{ $prod->productDesc }}" placeholder="Description">
					        					</div>
					        				</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Product Type</label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<div class="ui search selection dropdown">
					        							<input type="hidden" name="editProdType" value="{{$prod->types->typeName}}"><i class="dropdown icon"></i>
					        							<input class="search" autocomplete="off" tabindex="0">
					        							<div class="default text">Select Type</div>
					        							<div class="menu" tabindex="-1">
					        								@foreach($product_type as $type)
					        									@if($type->typeIsActive==1)
					        										<div class="item" data-value="{{ $type->typeId }}">{{ $type->typeName }}</div>
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
		        					<button type="reset" class="ui negative button"><i class="remove icon"></i>Clear</button>
		        					<button type="submit" class="ui green basic button"><i class="write icon"></i>Update</button>
		        				</div>
							{!! Form::close() !!}
						</div>
						<!--Modal for Delete-->
						<div class="ui small basic modal" id="del{{ $prod->productId }}" style="text-align:center">
							<div class="ui icon header">
								<i class="trash icon"></i>
								Delete
							</div>
							{!! Form::open(['action' => 'ProductController@destroy']) !!}
								<div class="content">
									<div class="description">
										<p>
											<input type="hidden" name="delProdId" value="{{ $prod->productId }}">
											<p>
												<label>Brand: {{$prod->brand->brandName}}</label><br>
												<label>Product: {{$prod->productName}}</label><br>
												<label>Description: {{$prod->productDesc}}</label><br>
												<label>Type: {{ $prod->types->typeName }}</label>
											</p>
										</p>
									</div>									
								</div>
								<div class="actions">
			        				<button type="submit" class="ui negative button"><i class="trash icon"></i>Delete</button>
			        				<button type="reset" class="ui green basic button"><i class="plane icon"></i>Cancel</button>
			        			</div>
							{!! Form::close() !!}
						</div>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>
	
	<!--Create Modal-->
	<div class="ui small modal" id="modalCreate">
		<div class="header">Create Product</div>
		<div class="content">
			<div class="description">
				{!! Form::open(['action' => 'ProductController@create']) !!}
					<div class="ui form">
						<div class="inline fields">
	    					<input type="hidden" name="productId" value="{{ $newId }}" readonly>
	    					<div class="two wide field">
								<label>Brand</label>
							</div>
							<div class="ui search selection dropdown">
	    							<input type="hidden" name="productBrandId"><i class="dropdown icon"></i>
	    							<input class="search" autocomplete="off" tabindex="0">
	    							<div class="default text">Select Type</div>
	    							<div class="menu" tabindex="-1">
	    								@foreach($product_type as $type)
	    									@if($type->typeIsActive==1)
	    										<div class="item" data-value="{{ $type->typeId }}">{{ $type->typeName }}</div>
	    									@endif
	    								@endforeach
	    							</div>
	    						</div>
							<div class="two wide field">
	    						<label>Product</label>
	    					</div>
	    					<div class="six wide field">
	    						<input type="text" name="productName" placeholder="Product">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Description</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<input type="text" name="productDesc" placeholder="Description">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Product Type</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<div class="ui search selection dropdown">
	    							<input type="hidden" name="productType"><i class="dropdown icon"></i>
	    							<input class="search" autocomplete="off" tabindex="0">
	    							<div class="default text">Select Type</div>
	    							<div class="menu" tabindex="-1">
	    								@foreach($product_type as $type)
	    									@if($type->typeIsActive==1)
	    										<div class="item" data-value="{{ $type->typeId }}">{{ $type->typeName }}</div>
	    									@endif
	    								@endforeach
	    							</div>
	    						</div>
	    					</div>
	    				</div>
					</div>
					<div class="actions">
						<button type="reset" class="ui negative button"><i class="remove icon"></i>Clear</button>
						<button type="submit" class="ui green basic button"><i class="write icon"></i>Submit</button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop


@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			/*var content = [
				@foreach($brand as $brand)
					{ title: '{{$brand->brandName}}'},
				@endforeach
			];*/
		    $('#list').DataTable();
		    $('.ui.dropdown').dropdown();
		    /*$('#createSearch').search({source: content});
		    $('.ui.search').search({source: content});*/
		});
		/*$('#create').click(function(){
        	$('#modalCreate').modal('show');    
    	});*/
		function modal(open){
			$('#' + open + '').modal('show');
		}

	</script>
@stop