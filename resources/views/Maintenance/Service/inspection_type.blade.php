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
				$('#modalNewType').modal('show');
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

	<h2>Maintenance - Inspection Type</h2>
	<hr><br>
	<button class="ui primary button" name="modalNewType" onclick="modal(this.name)"><i class="plus icon"></i>New Inspection Type</button>
	<br><br>
	<table id="list" class="ui celled three column table">
		<thead>
			<tr>
				<th>Inspection Type</th>
				<th>Description</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($inspect_type as $inspectType)
				@if($inspectType->inspectTypeIsActive==1)
					<tr>
						<td>{{ $inspectType->inspectTypeName }}</td>
						<td>{{ $inspectType->inspectTypeDesc }}</td>
						<td>
							<button class="ui primary basic circular icon button" data-tooltip="Update Record" data-inverted="" name="edit{{ $inspectType->inspectTypeId }}" onclick="modal(this.name)"><i class="write icon"></i></button>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $inspectType->inspectTypeId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
						<!--Modal for Update-->
						<div class="ui small modal" id="edit{{ $inspectType->inspectTypeId }}">
							<div class="header">Update Inspection Type</div>
							{!! Form::open(['action' => 'InspectTypeController@update']) !!}	
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
													<li>Inspection Type already exists. Update failed.</li>
												</div>
											@endif								
											<div class="sixteen wide field">
				        						<input type="hidden" name="editInspectTypeId" value="{{ $inspectType->inspectTypeId }}">
				        					</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Inspect Type<span>*</span></label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<input maxlength="255" type="text" name="editInspectTypeName" value="{{ $inspectType->inspectTypeName }}" placeholder="Inspect Type">
					        					</div>
					        				</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Description</label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<textarea maxlength="255" type="text" name="editInspectTypeDesc" placeholder="Description">{{ $inspectType->inspectTypeDesc }}</textarea>
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
						<div class="ui small basic modal" id="del{{ $inspectType->inspectTypeId }}" style="text-align:center">
							<div class="ui icon header">
								<i class="trash icon"></i>
								Deactivate
							</div>
							{!! Form::open(['action' => 'InspectTypeController@destroy']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="delInspectTypeId" value="{{ $inspectType->inspectTypeId }}">
										<p>
											<label>Inspect Type: {{$inspectType->inspectTypeName}}</label><br>
											<label>Description: {{$inspectType->inspectTypeDesc}}</label>
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
	<div class="ui small modal" id="modalNewType">
		<div class="header">New Inspection Type</div>
		<div class="content">
			<div class="description">
				<div class="ui form">
					{!! Form::open(['action' => 'InspectTypeController@create']) !!}
						<div class="ui error message"></div>
						@if($errors->any())
							<div class="ui negative message">
								<h3>Something went wrong!</h3>
								{!! implode('', $errors->all(
									'<li>:message</li>'
								)) !!}
							</div>
						@endif
						<input type="hidden" name="inspectTypeId" value="{{$newIdType}}" readonly>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Inspection Type<span>*</span></label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<input maxlength="255" type="text" name="inspectTypeName" placeholder="Inspection Type" value="{{old('inspectTypeName')}}">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Description</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<textarea maxlength="255" type="text" name="inspectTypeDesc" placeholder="Description">{{old('inspectTypeDesc')}}</textarea>
	    					</div>
	    				</div>
	    				<div class="actions">
	    					<i>Note: All with <span>(*)</span> are required fields</i>
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
			$('#msTitle').attr('class','title active');
			$('#msContent').attr('class','content active');
			$('#smsTitle').attr('class','title active');
			$('#smsContent').attr('class','content active');
		    $('#list').DataTable();
		    $('#listItem').DataTable();
		    $('.menu .item').tab();
		    $('.ui.dropdown').dropdown();
		    $('.ui.form').form({
			    fields: {
			    	inspectTypeName: 'empty',
			  	}
			});
			$('.ui.small.modal').form({
			    fields: {
			    	editInspectTypeName: 'empty',
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