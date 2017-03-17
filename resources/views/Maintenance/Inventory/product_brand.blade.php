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

	<h2>Maintenance - Brand</h2>
	<hr><br>
	<button class="ui primary button" name="modalNew" onclick="modal(this.name)"><i class="plus icon"></i>New Brand</button>
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
							<button class="ui primary basic circular icon button" data-tooltip="Update Record" data-inverted="" name="edit{{ $brand->brandId }}" onclick="modal(this.name)"><i class="write icon"></i></button>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $brand->brandId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
						<!--Modal for Update-->
						<div class="ui small modal" id="edit{{ $brand->brandId }}">
							<div class="header">Update Brand</div>
							{!! Form::open(['action' => 'BrandController@update']) !!}	
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
													<li>Brand already exists. Update failed.</li>
												</div>
											@endif								
											<div class="sixteen wide field">
				        						<input type="hidden" name="editBrandId" value="{{ $brand->brandId }}">
				        					</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Brand<span>*</span></label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<input maxlength="255" type="text" name="editBrandName" value="{{ $brand->brandName }}" placeholder="Brand">
					        					</div>
					        				</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Description</label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<textarea maxlength="255" type="text" name="editBrandDesc" placeholder="Description">{{ $brand->brandDesc }}</textarea>
					        					</div>
					        				</div>
										</div>
									</div>
								</div>
								<div class="actions">
									<i>Note: All with <span>*</span> are required fields</i>
		        					<button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
		        					<button type="submit" class="ui primary button"><i class="write icon"></i>Update</button>
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
			        				<button type="reset" class="ui primary button"><i class="remove icon"></i>Cancel</button>
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
	    					<div class="two wide field">
	    						<label>Brand<span>*</span></label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<input maxlength="255" type="text" name="brandName" placeholder="Brand" value="{{old('brandName')}}">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Description</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<textarea maxlength="255" type="text" name="brandDesc" placeholder="Description">{{old('brandDesc')}}</textarea>
	    					</div>
	    				</div>
	    				<div class="actions">
	    					<i>Note: All with <span>*</span> are required fields</i>
	    					<button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
	    					<button type="submit" class="ui primary button"><i class="plus icon"></i>Save</button>
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