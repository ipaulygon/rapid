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

	<h2>Transaction - Inspection</h2>
	<hr><br>
	<button class="ui green button" name="modalCreate" onclick="modal(this.name)"><i class="plus icon"></i>New Inspection</button>
	<br><br>
	<table id="listType" class="ui celled table">
		<thead>
			<tr>
				<th>Vehicle</th>
				<th>Customer</th>
				<th>Problem</th>
				<th>Request</th>
				<th>Remarks</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($inspect as $inspect)
				@if($inspect->inspectIsActive==1)
					<tr>
						<td>{{ $inspect->inspectVehicleId }}</td>
						<td>{{ $inspect->inspectCustomerId }}</td>
						<td>{{ $inspect->inspectProblem }}</td>
						<td>{{ $inspect->inspectRequest }}</td>
						<td>{{ $inspect->inspectRemarks }}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="edit{{ $inspect->inspectId }}" onclick="modal(this.name)"><i class="write icon"></i></button>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $inspect->inspectId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>
	
	<!--Create Modal-->
	<div class="ui modal" id="modalCreate">
		<div class="header">Add Inspection</div>
		<div class="content">
			<div class="description">
				<div class="ui form">
					{!! Form::open(['action' => 'InspectController@create']) !!}
						<div class="ui error message"></div>
						<input type="hidden" name="inspectHId" value="{{ $newId }}" readonly>
						<div class="ui stackable container secondary pointing menu">
							<a class="active item" data-tab="third">Inspection Details</a>
							<a class="item" data-tab="first">Vehicle Details</a>
							<a class="item" data-tab="second">Customer Details</a>
						</div>
						<div class="ui tab" data-tab="first">
							<div class="three fields">
								<div class="field">
									<label>Vehicle Plate<span>*</span></label>
									<div id="vehiclePlate" class="ui search selection dropdown">
		    							<input type="hidden" name="vehiclePlateId"><i class="dropdown icon"></i>
		    							<input name="vehiclePlate" class="search" autocomplete="off" tabindex="0">
		    							<div class="default text">XXX 000 / AAA 1234 </div>
		    							<div class="menu" tabindex="-1">
		    								@foreach($vehicle as $vehicle)
		    									<div class="item" data-value="{{ $vehicle->vehiclePlate }}">{{$vehicle->vehiclePlate }}</div>
		    								@endforeach
		    							</div>
		    						</div>
								</div>
								<div class="field">
									<label>Vehicle Make<span>*</span></label>
									<div id="vehicleMake" class="ui search selection dropdown">
		    							<input type="hidden" name="vehicleMakeId"><i class="dropdown icon"></i>
		    							<input name="vehicleMake" class="search" autocomplete="off" tabindex="0">
		    							<div class="default text">Toyota</div>
		    							<div class="menu" tabindex="-1">
		    								@foreach($make as $make)
		    									<div class="item" data-value="{{$make->makeId}}">{{$make->makeName}}</div>
		    								@endforeach
		    							</div>
		    						</div>
								</div>
								<div class="field">
									<label>Vehicle Model<span>*</span></label>
									<div id="vehicleModel" class="ui search selection dropdown">
		    							<input type="hidden" name="vehicleModelId"><i class="dropdown icon"></i>
		    							<input name="vehicleModel" class="search" autocomplete="off" tabindex="0">
		    							<div class="default text">Vios</div>
		    							<div class="menu" tabindex="-1">
		    								@foreach($model as $model)
		    									<div class="item" data-value="{{$model->modelId}}">{{$model->modelName}}</div>
		    								@endforeach
		    							</div>
		    						</div>
								</div>
							</div>
							<div class="three fields">
								<div class="field">
									<label>Vehicle Year<span>*</span></label>
									<div id="vehicleYear" class="ui search selection dropdown">
		    							<input type="hidden" name="vehicleYear"><i class="dropdown icon"></i>
		    							<input class="search" autocomplete="off" tabindex="0">
		    							<div class="default text">2010</div>
		    							<div class="menu" tabindex="-1">
		    								<?php 
		    									$date = date("Y");
		    								?>
		    								@for($dates=$date;$dates>1900;$dates--)
		    									<div class="item" data-value="{{$dates}}">{{$dates}}</div>
		    								@endfor
		    							</div>
		    						</div>
								</div>
								<div class="field">
									<label>Vehicle Type<span>*</span></label>
									<div id="vehicleType" class="ui search selection dropdown">
		    							<input type="hidden" name="vehicleType"><i class="dropdown icon"></i>
		    							<input class="search" autocomplete="off" tabindex="0">
		    							<div class="default text">Automatic/Manual</div>
		    							<div class="menu" tabindex="-1">
		    								<div class="item" data-value="1">Manual</div>
		    								<div class="item" data-value="2">Automatic</div>
		    							</div>
		    						</div>
								</div>
								<div class="field">
									<label>Vehicle Engine<span>*</span></label>
									<div id="vehicleEngine" class="ui search selection dropdown">
		    							<input type="hidden" name="vehicleEngine"><i class="dropdown icon"></i>
		    							<input class="search" autocomplete="off" tabindex="0">
		    							<div class="default text">Diesel/Gas</div>
		    							<div class="menu" tabindex="-1">
		    								<div class="item" data-value="1">Diesel</div>
		    								<div class="item" data-value="2">Gas</div>
		    							</div>
		    						</div>
								</div>
							</div>
							<div class="three fields">
								<div class="field"></div>
								<div class="field">
									<label>Vehicle Mileage</label>
									<input type="text" name="vehicleMileage">
								</div>
								<div class="field"></div>
							</div>
						</div>
						<div class="ui tab" data-tab="second">
							<div class="three fields">
								<div class="field">
									<label>First Name<span>*</span></label>
									<input type="text" name="custFirst">
								</div>
								<div class="field">
									<label>Middle Name</label>
									<input type="text" name="custMiddle">
								</div>
								<div class="field">
									<label>Last Name<span>*</span></label>
									<input type="text" name="custLast">
								</div>
							</div>
							<div class="field">
								<label>Address<span>*</span></label>
								<textarea type="text" name="custAddress" rows="2"></textarea>
							</div>
							<div class="two fields">
								<div class="field">
									<label>Contact<span>*</span></label>
									<input type="text" name="custContact">
								</div>
								<div class="field">
									<label>Email</label>
									<input type="text" name="custEmail">
								</div>
							</div>
						</div>
						<div class="ui active tab" data-tab="third">
							<div class="inline fields">
								<div class="four wide field">
									<label>Assign Technician(s)</label>
								</div>
								<div class="twelve wide field">
									<div style="width:100%" id="technician" class="ui multiple search selection dropdown">
		    							<input type="hidden" name="technician"><i class="dropdown icon"></i>
		    							<input class="search" autocomplete="off" tabindex="0">
		    							<div class="default text">Technician</div>
		    							<div class="menu" tabindex="-1">
		    								@foreach($tech as $tech)
		    									<div class="item" data-value="{{$tech->techId}}">{{$tech->techFirst}} {{$tech->techMiddle}} {{$tech->techLast}}</div>
		    								@endforeach
		    							</div>
		    						</div>
								</div>
							</div>
							@foreach($inspectType as $type)
								<h3>{{$type->inspectTypeName}}</h3>
								<table class="ui celled table">
									<thead>
										<tr>
											<th>Item</th>
											<th>Remarks</th>
											<th>Rating</th>
											<th>Recommendation</th>
										</tr>
									</thead>
									<tbody>
										@foreach($type->item as $inspectItem)
											@if($inspectItem->inspectItemIsActive==1)
												<tr>
													<td>{{$inspectItem->inspectItemName}}</td>
													<td><input type="text" name="remarks[]"></td>
													<td>
														<div class="inline fields">
															<div class="field">
																<div class="ui radio checkbox"><i class="ui big smile green icon"></i><input type="radio" name="rate{{$inspectItem->inspectItemId}}" value="1"></div>
															</div>
															<div class="field">
																<div class="ui radio checkbox"><i class="ui big meh yellow icon"></i><input type="radio" name="rate{{$inspectItem->inspectItemId}}" value="2"></div>
															</div>
															<div class="field">
																<div class="ui radio checkbox"><i class="ui big frown red icon"></i><input type="radio" name="rate{{$inspectItem->inspectItemId}}" value="3"></div>
															</div>
														</div>
													</td>
													<td><input type="text" name="recommendation[]"></td>
												</tr>
											@endif
										@endforeach
									</tbody>
								</table>
							@endforeach
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
		    $('#listType').DataTable();
		    $('.menu .item').tab();
		   	$('#vehiclePlate').dropdown({
		   		allowAdditions: true,
		   	});
		   	$('#vehicleMake').dropdown({
		   		allowAdditions: true,
		   	});
		   	$('#vehicleModel').dropdown({
		   		allowAdditions: true,
		   	});
		   	$('#vehicleYear').dropdown();
		   	$('#vehicleEngine').dropdown();
		   	$('#vehicleType').dropdown();
		   	$('#technician').dropdown();
		   	$('.ui.radio.checkbox').checkbox();
		   	$('#tsTitle').attr('class','title active');
			$('#tsContent').attr('class','content active');
			$('#stsTitle').attr('class','title active');
			$('#stsContent').attr('class','content active');
			$('.ui.form').form({
			    fields: {
			    	vehiclePlate: 'empty',
			    	vehicleMake: 'empty',
			    	vehicleModel: 'empty',
			    	vehicleYear: 'empty',
			    	vehicleType: 'empty',
			    	vehicleEngine: 'empty',
			    	vehicleMileage: 'empty',
			    	custFirst: 'empty',
			    	custLast: 'empty',
			    	custAddress: 'empty',
			    	custContact: 'empty',
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