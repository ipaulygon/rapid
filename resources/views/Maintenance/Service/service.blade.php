@extends('layouts.master')

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

	@if(Session::has('new_error'))
		<script type="text/javascript">
			$(document).ready(function (){
				$('#modalNew').modal('show');
			});
		</script>
	@endif

	@if(Session::has('update_error'))
		<script type="text/javascript">
			$(document).ready(function (){
				$("#edit{!! session('update_error') !!}").modal('show');
			});
		</script>
	@endif


	<h2>Maintenance - Service</h2>
	<hr><br>
	<button class="ui primary button" name="modalNew" onclick="modal(this.name)"><i class="plus icon"></i>New Service</button>
	<br><br>
	<table id="list" class="ui six column celled table">
		<thead>
			<tr>
				<th>Service</th>
				<th>Description</th>
				<th>Service Size</th>
				<th>Category</th>
				<th class="right aligned">Price (Php)</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($service as $serv)
				@if($serv->serviceIsActive==1)
				<?php  
					$price = $serv->servicePrice;
					$price = number_format($price,2);
					$size = $serv->serviceSize;
					if($size==1){
						$size = "Sedan";
					}else{
						$size = "Large Vehicle";
					}
				?>
					<tr>
						<td>{{ $serv->serviceName }}</td>
						<td>{{ $serv->serviceDesc }}</td>
						<td>{{ $size }}</td>
						<td>{{ $serv->categories->categoryName }}</td>
						<td class="right aligned">{{ $price }}</td>
						<td>
							<button class="ui primary basic circular icon button" data-tooltip="Update Record" data-inverted="" name="edit{{ $serv->serviceId }}" onclick="modal(this.name)"><i class="write icon"></i></button>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $serv->serviceId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
						<!--Modal for Update-->
						<div class="ui small modal" id="edit{{ $serv->serviceId }}">
							<div class="header">Update Service</div>
							{!! Form::open(['action' => 'ServiceController@update']) !!}	
								<div class="content">
									<div class="description">
										<div class="ui form">
											@if(Session::has('update_error'))
												@if($errors->any())
													<div class="ui negative message">
														<h3>Something went wrong!</h3>
														{!! implode('', $errors->all(
															'<li>:message</li>'
														)) !!}
													</div>
												@endif
											@endif
											@if(Session::has('update_unique'))
												<div class="ui negative message">
													<h3>Something went wrong!</h3>
													<li>Service already exists. Update failed.</li>
												</div>
											@endif									
											<div class="inline fields">
						    					<input type="hidden" name="editServiceId" value="{{ $serv->serviceId }}" readonly>
						    					<div class="two wide field">
													<label>Service<span>*</span></label>
												</div>
												<div class="fourteen wide field">
						    						<input maxlength="140" type="text" name="editServiceName" value="{{ $serv->serviceName }}" placeholder="Service">
						    					</div>
						    				</div>
						    				<div class="three fields">
												<div class="field">
													<label>Service Category<span>*</span></label>
													<div class="ui search selection dropdown">
														<input type="hidden" name="editServiceCategoryId" value="{{ $serv->serviceCategoryId }}"><i class="dropdown icon"></i>
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
												<div class="field">
													<label>Price<span>*</span></label>
													<div class="ui labeled input">
														<div class="ui label">P</div>
														<input style="text-align:right" type="text" id="editServicePrice" name="editServicePrice" value="{{ $serv->servicePrice }}" onkeypress="return validated(event,this.id)" data-content="Only numerical values are allowed" placeholder="Price" maxlength="8">
													</div>
												</div>
												<div class="field">
													<label>Service Size<span>*</span></label>
													<div class="ui search selection dropdown">
														<input type="hidden" name="editServiceSize" value="{{ $serv->serviceSize }}"><i class="dropdown icon"></i>
														<input class="search" autocomplete="off" tabindex="0">
														<div class="default text">Select Size</div>
														<div class="menu" tabindex="-1">
															<div class="item" data-value="1">Sedan</div>
															<div class="item" data-value="2">Large Vehicle</div>
														</div>
													</div>
												</div>
											</div>
						    				<div class="inline fields">
						    					<div class="two wide field">
						    						<label>Description</label>
						    					</div>
						    					<div class="fourteen wide field">
						    						<textarea maxlength="140" type="text" name="editServiceDesc">{{ $serv->serviceDesc }}</textarea>
						    					</div>
						    				</div>
										</div>
									</div>
								</div>
								<div class="actions">
									<i>Note: All with <span>(*)</span> are required fields</i>
		        					<button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
		        					<button type="submit" class="ui primary button"><i class="write icon"></i>Update</button>
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
			        				<button type="reset" class="ui positive button"><i class="arrow left icon"></i>Cancel</button>
			        			</div>
							{!! Form::close() !!}
						</div>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>
	
	<!--New Modal-->
	<div class="ui modal" id="modalNew">
		<div class="header">New Service</div>
		<div class="content">
			<div class="description">
				<div class="ui form">
					{!! Form::open(['action' => 'ServiceController@create']) !!}
						<div class="ui error message"></div>
						@if($errors->any())
							<div class="ui negative message">
								<h3>Something went wrong!</h3>
								{!! implode('', $errors->all(
									'<li>:message</li>'
								)) !!}
							</div>
						@endif
						<div class="inline fields">
	    					<input type="hidden" name="serviceId" value="{{ $newId }}" readonly>
	    					<div class="two wide field">
								<label>Service<span>*</span></label>
							</div>
							<div class="fourteen wide field">
	    						<input maxlength="140" type="text" name="serviceName" placeholder="Service" value="{{old('serviceName')}}">
	    					</div>
	    				</div>
	    				<div class="three fields">
	    					<div class="field">
								<label>Service Category<span>*</span></label>
	    						<div class="ui search selection dropdown">
	    							<input type="hidden" name="serviceCategoryId" value="{{old('serviceCategoryId')}}"><i class="dropdown icon"></i>
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
							<div class="field">
								<label>Price<span>*</span></label>
								<div class="ui labeled input">
									<div class="ui label">P</div>
									<input style="text-align:right" type="text" id="servicePrice" name="servicePrice" value="{{old('servicePrice')}}" onkeypress="return validated(event,this.id)" data-content="Only numerical values are allowed" placeholder="Price" maxlength="8">
								</div>
							</div>
							<div class="field">
								<label>Service Size<span>*</span></label>
								<div class="ui search selection dropdown">
	    							<input type="hidden" name="serviceSize" value="{{old('serviceSize')}}"><i class="dropdown icon"></i>
	    							<input class="search" autocomplete="off" tabindex="0">
	    							<div class="default text">Select Size</div>
	    							<div class="menu" tabindex="-1">
	    								<div class="item" data-value="1">Sedan</div>
		    							<div class="item" data-value="2">Large Vehicle</div>
	    							</div>
	    						</div>
							</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Description</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<textarea maxlength="140" type="text" name="serviceDesc">{{old('serviceDesc')}}</textarea>
	    					</div>
	    				</div>
	    				<div class="actions">
							<i>Note: All with <span>(*)</span> are required fields</i>
							<button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
							<button type="submit" class="ui primary button"><i class="write icon"></i>Save</button>
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
			$('#mTitle').attr('class','title header active');
$('#mContent').attr('class','content active');
$('#smTitle').attr('class','title header active');
$('#smContent').attr('class','content active');
$('#msTitle').attr('class','title active');
			$('#msContent').attr('class','content active');
			$('#smsTitle').attr('class','title active');
			$('#smsContent').attr('class','content active');
		    $('#list').DataTable();
		    $('.ui.dropdown').dropdown();
		    $('.ui.form').form({
			    fields: {
			    	serviceName: 'empty',
			    	serviceCategoryId: 'empty',
			    	servicePrice: 'empty',
					serviceSize: 'empty'
			  	}
			});
			$('.ui.small.modal').form({
			    fields: {
			    	editServiceName: 'empty',
			    	editServiceCategoryId: 'empty',
			    	editServicePrice: 'empty',
					editServiceSize: 'empty'
			  	}
			});
		});
		function modal(open){
			$('#' + open + '').modal('show').modal({
				closable: false,
			});
		}
		function validated(event, idx) {
            var char = String.fromCharCode(event.which);
            var patt = /^\d*\.?\d*$/;
            var res = patt.test(char);
            if (!res) {
                $("input[id="+idx+"]").popup('show');
                return false;
            }
            else {
                $("input[id="+idx+"]").popup('hide');
            }
        }
	</script>
@stop