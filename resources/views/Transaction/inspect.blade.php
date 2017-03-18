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
	<a class="ui primary button" href="{{URL::to('/transaction/inspect-form')}}"><i class="plus icon"></i>New Inspection</a>
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
							<button class="ui primary basic circular icon button" data-tooltip="Update Record" data-inverted="" name="edit{{ $inspect->inspectId }}" onclick="modal(this.name)"><i class="write icon"></i></button>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $inspect->inspectId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>
@stop


@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
		    $('#listType').DataTable();
		   	$('#tTitle').attr('class','title header active');
$('#tContent').attr('class','content active');
$('#stTitle').attr('class','title header active');
$('#stContent').attr('class','content active');
$('#tsTitle').attr('class','title active');
			$('#tsContent').attr('class','content active');
			$('#stsTitle').attr('class','title active');
			$('#stsContent').attr('class','content active');
		});
		function modal(open){
			$('#' + open + '').modal('show').modal({
				closable: false,
			});
		}
	</script>
@stop