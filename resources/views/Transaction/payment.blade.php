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

	<h2>Transaction - Payments</h2>
	<hr><br>
	<table id="listType" class="ui celled three column table">
		<thead>
			<tr>
				<th>Job No.</th>
				<th>Vehicle</th>
                <th>Customer</th>
                <th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($jobs as $job)
                <tr>
                	<td>{{$job->jobId}}</td>
                    <td>{{$job->vehicle->vehiclePlate}}</td>
                    <td>{{$job->customer->customerFirst}} {{$job->customer->customerMiddle}} {{$job->customer->customerLast}}</td>
                    <td>
                        <a href="order-supply-pdf/{{$order->purchaseHId}}" class="ui blue basic circular icon button" data-tooltip="View PDF" data-inverted="" name="{{$job->jobHId}}"><i class="eye icon"></i></a>
						<a href="order-supply-form/{{$order->purchaseHId}}" class="ui primary basic circular icon button" data-tooltip="Update Record" data-inverted=""><i class="write icon"></i></a>
                    </td>
                </tr>
            @endforeach
		</tbody>
	</table>
@stop


@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			$('#tTitle').attr('class','title header active');
			$('#tContent').attr('class','content active');
			$('#stTitle').attr('class','title header active');
			$('#stContent').attr('class','content active');
		    $('#listType').DataTable();
		});
		function modal(open){
			$('#' + open + '').modal('show').modal({
				closable: false,
			});
		}
	</script>
@stop