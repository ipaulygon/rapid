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
	<button class="ui positive button" name="modalCreate" onclick="modal(this.name)"><i class="plus icon"></i>Add Inspection</button>
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
						<input type="hidden" name="inspectHId" value="{{ $newId }}" readonly>
						<div class="ui stackable container secondary pointing menu">
							<a class="active item" data-tab="first">Vehicle Details</a>
							<a class="item" data-tab="second">Customer Details</a>
							<a class="item" data-tab="third">Inspection Details</a>
						</div>
						<div class="ui active tab" data-tab="first">
							<div class="three fields">
								<div class="field">
									<label>Vehicle Id<span>*</span></label>
									<div id="vehicleId" class="ui search">
										<input type="text" name="vehicleId" placeholder="WMX-289" autocomplete="off">
										<div class="results"></div>
									</div>
								</div>
								<div class="field">
									<label>Vehicle Make<span>*</span></label>
									<div id="vehicleMake" class="ui search">
										<input type="text" name="vehicleMake" placeholder="Toyota" autocomplete="off">
										<div class="results"></div>
									</div>
								</div>
								<div class="field">
									<label>Vehicle Model<span>*</span></label>
									<div id="vehicleModel" class="ui search">
										<input type="text" name="vehicleModel" placeholder="Liteace" autocomplete="off">
										<div class="results"></div>
									</div>
								</div>
							</div>
							<div class="three fields">
								<div class="field">
									<label>Vehicle Year<span>*</span></label>
									<input type="text" name="vehicleYear">
								</div>
								<div class="field">
									<label>Vehicle Type<span>*</span></label>
									<select name="vehicleType" class="ui dropdown">
										<option value="1">Automatic</option>
										<option value="2">Manual</option>
									</select>
								</div>
								<div class="field">
									<label>Vehicle Engine<span>*</span></label>
									<select name="vehicleEngine" class="ui dropdown">
										<option value="1">Gas Engine</option>
										<option value="2">Diesel Engine</option>
									</select>
								</div>
							</div>
							<div class="three fields">
								<div class="field"></div>
								<div class="field">
									<label>Vehicle Mileage<span>*</span></label>
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
							<div class="sixteen wide fields">
								<label>Address<span>*</span></label>
								<textarea type="text" name="custAddress"></textarea>
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
						<div class="ui tab" data-tab="third">
							@foreach($inspectType as $type)
								@if($type->inspectTypeIsActive==1)
									<div class="ui segment">
										{{$type->inspectTypeName}}<br>
										@foreach($type->item as $item)
											@if($item->inspectItemIsActive==1)
												<div class="four fields">
													<div class="field">
														<label>{{$item->inspectItemName}}</label>												
													</div>
													<div class="field">
														<input type="text" name="remarks{{$item->inspectItemName}}">
													</div>
													<div class="field">
														<input type="radio" name="rate" value="sad">Sad
														<input type="radio" name="rate" value="poker">Poker
														<input type="radio" name="rate" value="happy">Happy
													</div>
													<div class="field">
														<input type="text" name="recommend">
													</div>
												</div>
											@endif
										@endforeach
									</div>
								@endif
							@endforeach
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
			var contentVehicle = [
				@foreach($vehicle as $vehicle)
					"{title:"+{{$vehicle->vehicleId}}+"},"
				@endforeach
			];
			var contentMake = [
				@foreach($make as $make)
					"{title:"+{{$make->makeName}}+"},"
				@endforeach
			];
			var contentModel = [
				@foreach($model as $model)
					"{title:"+{{$model->modelName}}+"},"
				@endforeach
			];
		    $('#listType').DataTable();
		    $('.menu .item').tab();
		    $('.ui.search #vehicleMake').search({source: contentMake});
		    $('.ui.search #vehicleModel').search({source: contentModel});
		});
		/*$('#create').click(function(){
        	$('#modalCreate').modal('show');    
    	});*/
		function modal(open){
			$('#' + open + '').modal('show');
		}
	</script>
@stop