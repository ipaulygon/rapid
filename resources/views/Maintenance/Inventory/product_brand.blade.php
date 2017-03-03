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

	<h2>Maintenance - Brand</h2>
	<hr><br>
	<button class="ui green button" name="modalNew" onclick="modal(this.name)"><i class="plus icon"></i>New Brand</button>
	<br><br>
	<table id="listType" class="ui celled three column table">
		<thead>
			<tr>
				<th>Brand</th>
				<th>Description</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($brand as $brand)
				@if($brand->brandIsActive==1)
					<tr>
						<td>{{ $brand->brandName }}</td>
						<td>{{ $brand->brandDesc }}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="edit{{ $brand->brandId }}" onclick="modal(this.name)"><i class="write icon"></i></button>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $brand->brandId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
						<!--Modal for Update-->
						<div class="ui small modal" id="edit{{ $brand->brandId }}">
							<div class="header">Update Brand</div>
							{!! Form::open(['action' => 'BrandController@update']) !!}	
								<div class="content">
									<div class="description">
										<div class="ui form">								
											<div class="sixteen wide field">
				        						<input type="hidden" name="editBrandId" value="{{ $brand->brandId }}">
				        					</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Brand<span>*</span></label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<input type="text" name="editBrandName" value="{{ $brand->brandName }}" placeholder="Brand">
					        					</div>
					        				</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Description</label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<textarea type="text" name="editBrandDesc" placeholder="Description">{{ $brand->brandDesc }}</textarea>
					        					</div>
					        				</div>
										</div>
									</div>
								</div>
								<div class="actions">
									<i>Note: All with <span>*</span> are required fields</i>
		        					<button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
		        					<button type="submit" class="ui green button"><i class="write icon"></i>Update</button>
		        				</div>
	        				{!! Form::close() !!}
						</div>
						<!--Modal for Deactivate-->
						<div class="ui small basic modal" id="del{{ $brand->brandId }}" style="text-align:center">
							<div class="ui icon header">
								<i class="trash icon"></i>
								Deactivate
							</div>
							{!! Form::open(['action' => 'BrandController@destroy']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="delBrandId" value="{{ $brand->brandId }}">
										<p>
											<label>Brand: {{$brand->brandName}}</label><br>
											<label>Description: {{$brand->brandDesc}}</label>
										</p>
									</div>
								</div>
								<div class="actions">
			        				<button type="submit" class="ui negative button"><i class="trash icon"></i>Deactivate</button>
			        				<button type="reset" class="ui positive button"><i class="remove icon"></i>Cancel</button>
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
		<div class="header">New Brand</div>
		<div class="content">
			<div class="description">
				<div class="ui form">
					{!! Form::open(['action' => 'BrandController@create']) !!}
						<input type="hidden" name="brandId" value="{{ $newId }}" readonly>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Brand<span>*</span></label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<input type="text" name="brandName" placeholder="Brand">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Description</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<textarea type="text" name="brandDesc" placeholder="Description"></textarea>
	    					</div>
	    				</div>
	    				<div class="actions">
	    					<i>Note: All with <span>*</span> are required fields</i>
	    					<button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
	    					<button type="submit" class="ui green button"><i class="plus icon"></i>Save</button>
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
			$('#miTitle').attr('class','title active');
			$('#miContent').attr('class','content active');
			$('#smiTitle').attr('class','title active');
			$('#smiContent').attr('class','content active');
		    $('#listType').DataTable();
		    $('.ui.form').form({
			    fields: {
			    	brandName: 'empty',
			  	}
			});
			$('.ui.small.modal').form({
			    fields: {
			    	editBrandName: 'empty',
			  	}
			});
		});
		function modal(open){
			$('#' + open + '').modal('show').modal({
				closable: false,
			});
		}
	</script>
@stop