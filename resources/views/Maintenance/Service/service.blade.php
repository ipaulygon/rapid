@extends('layouts.mcarcare')

@section('content')	
	<!--New-->	
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

	<h2>Maintenance - Service</h2>
	<hr><br>
	<button class="ui positive button" name="modalNew" onclick="modal(this.name)"><i class="plus icon"></i>New Service</button>
	<br><br>
	<table id="list" class="ui celled table">
		<thead>
			<tr>
				<th>Service</th>
				<th>Description</th>
				<th>Category</th>
				<th>Price</th>
				<th class="four wide">Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($service as $serv)
				@if($serv->serviceIsActive==1)
				<?php  
					$price = $serv->servicePrice;
					$price = number_format($price,2);
				?>
					<tr>
						<td>{{ $serv->serviceName }}</td>
						<td>{{ $serv->serviceDesc }}</td>
						<td>{{ $serv->categories->categoryName }}</td>
						<td>Php {{ $price }}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="edit{{ $serv->serviceId }}" onclick="modal(this.name)"><i class="write icon"></i></button>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $serv->serviceId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
						<!--Modal for Update-->
						<div class="ui small modal" id="edit{{ $serv->serviceId }}">
							<div class="header">Update Service</div>
							{!! Form::open(['action' => 'ServiceController@update']) !!}	
								<div class="content">
									<div class="description">
										<div class="ui form">								
											<div class="inline fields">
						    					<input type="hidden" name="editServiceId" value="{{ $serv->serviceId }}" readonly>
						    					<div class="two wide field">
													<label>Service<span>*</span></label>
												</div>
												<div class="fourteen wide field">
						    						<input type="text" name="editServiceName" value="{{ $serv->serviceName }}" placeholder="Service">
						    					</div>
						    				</div>
						    				<div class="inline fields">
						    					<div class="two wide field">
						    						<label>Service Category<span>*</span></label>
						    					</div>
						    					<div class="six wide field">
						    						<div class="ui search selection dropdown">
						    							<input type="hidden" name="editServiceCategoryId" value="{{ $serv->categories->categoryName }}"><i class="dropdown icon"></i>
						    							<input class="search" autocomplete="off" tabindex="0">
						    							<div class="default text">Select Category</div>
						    							<div class="menu" tabindex="-1">
						    								@foreach($category as $cat)
						    									@if($cat->categoryIsActive==1)
						    										<div class="item" data-value="{{ $cat->categoryId }}">{{ $cat->categoryName }}</div>
						    									@endif
						    								@endforeach
						    							</div>
						    						</div>
						    					</div>
						    					<div class="two wide field">
													<label>Price<span>*</span></label>
												</div>
												<div class="six wide field">
													<div class="ui labeled input">
														<div class="ui label">P</div>
														<input type="text" name="editServicePrice" value="{{ $serv->servicePrice }}" placeholder="Price">
														<input type="hidden" name="currentServicePrice" value="{{$serv->service}}">
													</div>
												</div>
						    				</div>
						    				<div class="inline fields">
						    					<div class="two wide field">
						    						<label>Description</label>
						    					</div>
						    					<div class="fourteen wide field">
						    						<textarea type="text" name="editServiceDesc">{{ $serv->serviceDesc }}</textarea>
						    					</div>
						    				</div>
										</div>
									</div>
								</div>
								<div class="actions">
									<i>Note: All with <span>*</span> are required fields</i>
		        					<button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
		        					<button type="submit" class="ui positive button"><i class="write icon"></i>Update</button>
		        				</div>
	        				{!! Form::close() !!}
						</div>
						<!--Modal for Deactivate-->
						<div class="ui small basic modal" id="del{{ $serv->serviceId }}" style="text-align:center">
							<div class="ui icon header">
								<i class="trash icon"></i>
								Deactivate
							</div>
							{!! Form::open(['action' => 'ServiceController@destroy']) !!}
								<div class="content">
									<div class="description">
										<p>
											<input type="hidden" name="delServiceId" value="{{ $serv->serviceId }}">
											<p>
												<label>Service: {{$serv->serviceName}}</label><br>
												<label>Description: {{$serv->serviceDesc}}</label><br>
												<label>Category: {{ $serv->categories->categoryName }}</label>
												<label>Price: {{$serv->servicePrice}}</label><br>
											</p>
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
	
	<!--New Modal-->
	<div class="ui small modal" id="modalNew">
		<div class="header">New Service</div>
		<div class="content">
			<div class="description">
				{!! Form::open(['action' => 'ServiceController@create']) !!}
					<div class="ui form">
						<div class="inline fields">
	    					<input type="hidden" name="serviceId" value="{{ $newId }}" readonly>
	    					<div class="two wide field">
								<label>Service<span>*</span></label>
							</div>
							<div class="fourteen wide field">
	    						<input type="text" name="serviceName" placeholder="Service">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Service Category<span>*</span></label>
	    					</div>
	    					<div class="six wide field">
	    						<div class="ui search selection dropdown">
	    							<input type="hidden" name="serviceCategoryId"><i class="dropdown icon"></i>
	    							<input class="search" autocomplete="off" tabindex="0">
	    							<div class="default text">Select Category</div>
	    							<div class="menu" tabindex="-1">
	    								@foreach($category as $cat)
	    									@if($cat->categoryIsActive==1)
	    										<div class="item" data-value="{{ $cat->categoryId }}">{{ $cat->categoryName }}</div>
	    									@endif
	    								@endforeach
	    							</div>
	    						</div>
	    					</div>
	    					<div class="two wide field">
								<label>Price<span>*</span></label>
							</div>
							<div class="six wide field">
								<div class="ui labeled input">
									<div class="ui label">P</div>
									<input type="text" name="servicePrice" placeholder="Price">
								</div>
							</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Description</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<textarea type="text" name="serviceDesc"></textarea>
	    					</div>
	    				</div>
					</div>
					<div class="actions">
						<i>Note: All with <span>*</span> are required fields</i>
						<button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
						<button type="submit" class="ui positive button"><i class="write icon"></i>Save</button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop


@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
		    $('#list').DataTable();
		    $('.ui.dropdown').dropdown();
		});
		/*$('#create').click(function(){
        	$('#modalNew').modal('show');    
    	});*/
		function modal(open){
			$('#' + open + '').modal('show');
		}
	</script>
@stop