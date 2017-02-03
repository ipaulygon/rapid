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

	<h2>Maintenance - Service Category</h2>
	<hr><br>
	<button class="ui positive button" name="modalCreate" onclick="modal(this.name)"><i class="plus icon"></i>Add Service Category</button>
	<br><br>
	<table id="listType" class="ui celled three column table">
		<thead>
			<tr>
				<th>Service Category</th>
				<th>Description</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($service_category as $category)
				@if($category->categoryIsActive==1)
					<tr>
						<td>{{ $category->categoryName }}</td>
						<td>{{ $category->categoryDesc }}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Data" data-inverted="" name="edit{{ $category->categoryId }}" onclick="modal(this.name)"><i class="write icon"></i></button>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Data" data-inverted="" name="del{{ $category->categoryId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
						<!--Modal for Update-->
						<div class="ui small modal" id="edit{{ $category->categoryId }}">
							<div class="header">Update Service</div>
							{!! Form::open(['action' => 'ServiceCategoryController@update']) !!}	
								<div class="content">
									<div class="description">
										<div class="ui form">								
											<div class="sixteen wide field">
				        						<input type="hidden" name="editCategoryId" value="{{ $category->categoryId }}">
				        					</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Service Category<span>*</span></label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<input type="text" name="editCategoryName" value="{{ $category->categoryName }}" placeholder="Service Category">
					        					</div>
					        				</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Description</label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<textarea type="text" name="editCategoryDesc" placeholder="Description">{{ $category->categoryDesc }}</textarea>
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
						<!--Modal for Deactivate-->
						<div class="ui small basic modal" id="del{{ $category->categoryId }}" style="text-align:center">
							<div class="ui icon header">
								<i class="trash icon"></i>
								Deactivate
							</div>
							{!! Form::open(['action' => 'ServiceCategoryController@destroy']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="delCategoryId" value="{{ $category->categoryId }}">
										<p>
											<label>Service Category: {{$category->categoryName}}</label><br>
											<label>Description: {{$category->categoryDesc}}</label>
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
	
	<!--Create Modal-->
	<div class="ui small modal" id="modalCreate">
		<div class="header">Create Service Category</div>
		<div class="content">
			<div class="description">
				<div class="ui form">
					{!! Form::open(['action' => 'ServiceCategoryController@create']) !!}
						<input type="hidden" name="categoryId" value="{{$newId}}" readonly>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Service Category<span>*</span></label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<input type="text" name="categoryName" placeholder="Service Category">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Description</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<textarea type="text" name="categoryDesc" placeholder="Description"></textarea>
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