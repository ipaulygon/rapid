@extends('layouts.maintenance')

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

	@if(Session::has('warning_message'))
		<div class="ui small basic modal" style="text-align:center" id="warning_message">
			<div class="ui icon header">
				<i class="warning sign icon"></i>
				Warning
			</div>
			<div class="content">
				<em>{!! session('warning_message') !!}</em>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function (){
				$('#warning_message').modal('show');
			});
		</script>
	@endif

	<h2>Maintenance - Product Variance</h2>
	<hr><br>
	<button class="ui positive button" name="modalNew" onclick="modal(this.name)"><i class="plus icon"></i>New Variance</button>
	<br><br>
	<table id="list" class="ui celled five column table">
		<thead>
			<tr>
				<th>Variance Size</th>
				<th>Variance Unit</th>
				<th>Description</th>
				<th>Limited to</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($variance as $variance)
				@if($variance->varianceIsActive==1)
					<tr>
						<td>{{ $variance->varianceSize }}</td>
						<td>{{ $variance->unit->unitName }}</td>
						<td>{{ $variance->varianceDesc }}</td>
						<td>
							@foreach($variance->type as $type)
								@if($type->tvIsActive==1)
									<li>{{$type->type->typeName}}</li>
								@endif
							@endforeach
						</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="edit{{ $variance->varianceId }}" onclick="modal(this.name)"><i class="write icon"></i></button>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $variance->varianceId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
						<!--Modal for Update-->
						<div class="ui small modal" id="edit{{ $variance->varianceId }}">
							<div class="header">Update Variance</div>
							{!! Form::open(['action' => 'VarianceController@update']) !!}	
								<div class="content">
									<div class="description">
										<div class="ui form">								
											<div class="sixteen wide field">
				        						<input type="hidden" name="editVarianceId" value="{{ $variance->varianceId }}">
				        					</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Variance<span>*</span></label>
					        					</div>
					        					<div class="six wide field">
					        						<input type="text" name="editVarianceSize" value="{{ $variance->varianceSize }}" placeholder="Variance">
					        					</div>
					        					<div class="two wide field">
						    						<label>Unit<span>*</span></label>
						    					</div>
						    					<div class="six wide field">
						    						<div class="ui search selection dropdown">
						    							<input type="hidden" name="editVarianceUnitId" value="{{$variance->unit->unitName}}"><i class="dropdown icon"></i>
					        							<input class="search" autocomplete="off" tabindex="0">
					        							<div class="default text">Select Type</div>
					        							<div class="menu" tabindex="-1">
					        								@foreach($unit as $units)
					        									@if($units->unitIsActive==1)
					        										<div class="item" data-value="{{ $units->unitId }}">{{ $units->unitName }}</div>
					        									@endif
					        								@endforeach
					        							</div>
						    						</div>
						    					</div>
					        				</div>
					        				<div class="inline fields">
						    					<div class="two wide field">
						    						<label>Limit Variance to type(s)</label>
						    					</div>
						    					<div class="fourteen wide field">
						    						<div id="editType{{$variance->varianceId}}" style="width:100%" class="ui multiple search selection dropdown">
						    							<input type="hidden" name="editTypes"><i class="dropdown icon"></i>
						    							<input class="search" autocomplete="off" tabindex="0">
						    							<div class="default text">Limit to Types</div>
						    							<div class="menu" tabindex="-1">
						    								@foreach($types as $type)
						    									@if($type->typeIsActive==1)
						    										<div class="item" data-value="{{ $type->typeId }}">{{ $type->typeName }}</div>
						    									@endif
						    								@endforeach
						    							</div>
						    						</div>
						    					</div>
						    				</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Description</label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<textarea type="text" name="editVarianceDesc" placeholder="Description">{{ $variance->varianceDesc }}</textarea>
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
		        				<script type="text/javascript">
		        					var array=[
		        						@foreach($variance->type as $type)
											@if($type->tvIsActive==1)
												'{{$type->type->typeId}}',
											@endif
										@endforeach
		        					];
		        					$('#editType{{$variance->varianceId}}').dropdown('set selected',array);
		        				</script>
	        				{!! Form::close() !!}
						</div>
						<!--Modal for Deactivate-->
						<div class="ui small basic modal" id="del{{ $variance->varianceId }}" style="text-align:center">
							<div class="ui icon header">
								<i class="trash icon"></i>
								Deactivate
							</div>
							{!! Form::open(['action' => 'VarianceController@destroy']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="delVarianceId" value="{{ $variance->varianceId }}">
										<p>
											<label>Size: {{$variance->varianceSize}}</label><br>
											<label>Unit: {{$variance->unit->unitName}}</label><br>
											<label>Description: {{$variance->varianceDesc}}</label>
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
		<div class="header">New Variance</div>
		<div class="content">
			<div class="description">
				<div class="ui form">
					{!! Form::open(['action' => 'VarianceController@create']) !!}
						<input type="hidden" name="varianceId" value="{{ $newId }}" readonly>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Size<span>*</span></label>
	    					</div>
	    					<div class="six wide field">
	    						<input type="text" name="varianceSize" placeholder="Variance">
	    					</div>
	    					<div class="two wide field">
	    						<label>Unit<span>*</span></label>
	    					</div>
	    					<div class="six wide field">
	    						<div class="ui search selection dropdown">
	    							<input type="hidden" name="varianceUnitId"><i class="dropdown icon"></i>
	    							<input class="search" autocomplete="off" tabindex="0">
	    							<div class="default text">Select Unit</div>
	    							<div class="menu" tabindex="-1">
	    								@foreach($unit as $unit)
	    									@if($unit->unitIsActive==1)
	    										<div class="item" data-value="{{ $unit->unitId }}">{{ $unit->unitName }}</div>
	    									@endif
	    								@endforeach
	    							</div>
	    						</div>
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Limit Variance to type(s)</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<div style="width:100%" class="ui multiple search selection dropdown">
	    							<input type="hidden" name="types"><i class="dropdown icon"></i>
	    							<input class="search" autocomplete="off" tabindex="0">
	    							<div class="default text">Limit to Types</div>
	    							<div class="menu" tabindex="-1">
	    								@foreach($types as $types)
	    									@if($types->typeIsActive==1)
	    										<div class="item" data-value="{{ $types->typeId }}">{{ $types->typeName }}</div>
	    									@endif
	    								@endforeach
	    							</div>
	    						</div>
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Description</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<textarea type="text" name="varianceDesc" placeholder="Description"></textarea>
	    					</div>
	    				</div>
	    				<div class="actions">
	    					<i>Note: All with <span>*</span> are required fields</i>
	    					<button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
	    					<button type="submit" class="ui positive button"><i class="plus icon"></i>Save</button>
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
		    $('.ui.dropdown').dropdown();
		});
		function modal(open){
			$('#' + open + '').modal('show');
		}
	</script>
@stop