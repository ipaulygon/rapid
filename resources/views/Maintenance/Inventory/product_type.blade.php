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

	<h2>Maintenance - Product Type</h2>
	<hr><br>
	<button class="ui positive button" name="modalCreate" onclick="modal(this.name)"><i class="plus icon"></i>Add Product Type</button>
	<br><br>
	<table id="listType" class="ui celled three column table">
		<thead>
			<tr>
				<th>Product Type</th>
				<th>Description</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($product_type as $type)
				@if($type->typeIsActive==1)
					<tr>
						<td>{{ $type->typeName }}</td>
						<td>{{ $type->typeDesc }}</td>
						<td>
							<button class="ui green basic button" name="edit{{ $type->typeId }}" onclick="modal(this.name)"><i class="write icon"></i>Edit</button>
							<button class="ui red basic button" name="del{{ $type->typeId }}" onclick="modal(this.name)"><i class="trash icon"></i>Delete</button>
						</td>
						<!--Modal for Edit-->
						<div class="ui small modal" id="edit{{ $type->typeId }}">
							<div class="header">Edit Product Type</div>
							{!! Form::open(['action' => 'ProductTypeController@update']) !!}	
								<div class="content">
									<div class="description">
										<div class="ui form">								
											<div class="sixteen wide field">
				        						<input type="hidden" name="editTypeId" value="{{ $type->typeId }}">
				        					</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Product Type<span>*</span></label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<input type="text" name="editTypeName" value="{{ $type->typeName }}" placeholder="Product Type">
					        					</div>
					        				</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Description</label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<textarea type="text" name="editTypeDesc" placeholder="Description">{{ $type->typeDesc }}</textarea>
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
						<div class="ui small basic modal" id="del{{ $type->typeId }}" style="text-align:center">
							<div class="ui icon header">
								<i class="trash icon"></i>
								Delete
							</div>
							{!! Form::open(['action' => 'ProductTypeController@destroy']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="delTypeId" value="{{ $type->typeId }}">
										<p>
											<label>Product Type: {{$type->typeName}}</label><br>
											<label>Description: {{$type->typeDesc}}</label>
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
		<div class="header">Create Product Type</div>
		<div class="content">
			<div class="description">
				<div class="ui form">
					{!! Form::open(['action' => 'ProductTypeController@create']) !!}
						<div class="inline fields">
	    					<div class="sixteen wide field">
	    						<input type="hidden" name="typeId" value="{{ $newId }}" readonly>
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Product Type<span>*</span></label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<input type="text" name="typeName" placeholder="Product Type">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Description</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<textarea type="text" name="typeDesc" placeholder="Description"></textarea>
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
		    $('#listType').DataTable();
		});
		/*$('#create').click(function(){
        	$('#modalCreate').modal('show');    
    	});*/
		function modal(open){
			$('#' + open + '').modal('show');
		}
	</script>
@stop