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

	<h2>Maintenance - Discount</h2>
	<hr><br>
	<button class="ui positive button" name="modalCreate" onclick="modal(this.name)"><i class="plus icon"></i>Add Discount</button>
	<br><br>
	<table id="list" class="ui celled three column table">
		<thead>
			<tr>
				<th>Discount</th>
				<th>Rate</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($discount as $discount)
				@if($discount->discountIsActive==1)
					<tr>
						<td>{{$discount->discountName}}</td>
						<td>{{$discount->discountRate}}%</td>
						<td>
							<button class="ui green basic button" name="edit{{ $discount->discountId }}" onclick="modal(this.name)"><i class="write icon"></i>Edit</button>
							<button class="ui red basic button" name="del{{ $discount->discountId }}" onclick="modal(this.name)"><i class="trash icon"></i>Delete</button>
						</td>
						<!--Modal for Edit-->
						<div class="ui small modal" id="edit{{ $discount->discountId }}">
							<div class="header">Edit Discount</div>
							{!! Form::open(['action' => 'DiscountController@update']) !!}	
								<div class="content">
									<div class="description">
										<div class="ui form">								
											<div class="sixteen wide field">
				        						<input type="hidden" name="editDiscountId" value="{{ $discount->discountId }}">
				        					</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Discount<span>*</span></label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<input type="text" name="editDiscountName" value="{{ $discount->discountName }}" placeholder="Product Type">
					        					</div>
					        				</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Rate<span>*</span></label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<input type="text" name="editDiscountRate" value="{{ $discount->discountRate }}" placeholder="Rate">
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
						</div>
						<!--Modal for Delete-->
						<div class="ui small basic modal" id="del{{ $discount->discountId }}" style="text-align:center">
							<div class="ui icon header">
								<i class="trash icon"></i>
								Delete
							</div>
							{!! Form::open(['action' => 'DiscountController@destroy']) !!}
								<div class="content">
									<div class="description">
										<p>
											<input type="hidden" name="delDiscountId" value="{{ $discount->discountId }}">
											<p>
												<label>Discount: {{$discount->discountName}}</label><br>
												<label>Description: {{$discount->discountRate}}</label><br>
											</p>
										</p>
									</div>									
								</div>
								<div class="actions">
			        				<button type="submit" class="ui negative button"><i class="trash icon"></i>Delete</button>
			        				<button type="reset" class="ui positive button"><i class="plane icon"></i>Cancel</button>
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
		<div class="header">Create Discount</div>
		<div class="content">
			<div class="description">
				<div class="ui form">
					{!! Form::open(['action' => 'DiscountController@create']) !!}
						<div class="inline fields">
	    					<div class="sixteen wide field">
	    						<input type="hidden" name="discountId" value="{{$newId}}" readonly>
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Discount<span>*</span></label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<input type="text" name="discountName" placeholder="Discount">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Rate<span>*</span></label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<input type="text" name="discountRate" placeholder="Rate">
	    					</div>
	    				</div>
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
		});
		/*$('#create').click(function(){
        	$('#modalCreate').modal('show');    
    	});*/
		function modal(open){
			$('#' + open + '').modal('show');
		}
	</script>
@stop