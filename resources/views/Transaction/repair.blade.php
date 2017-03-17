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

	<h2>Transaction - Estimate Cost</h2>
	<hr><br>
	<a class="ui positive button" href="{{URL::to('/transaction/estimate-form')}}"><i class="plus icon"></i>New Estimates</a>
	<br><br>
	<table id="listType" class="ui celled three column table">
		<thead>
			<tr>
				<th>Estimate No.</th>
				<th>Vehicle</th>
                <th>Customer</th>
                <th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($estimates as $estimate)
                <tr>
                	<td>{{$estimate->estimateHId}}</td>
                    <td>{{$estimate->vehicle->vehiclePlate}}</td>
                    <td>{{$estimate->customer->customerFirst}} {{$estimate->customer->customerMiddle}} {{$estimate->customer->customerLast}}</td>
                    <td>
                        <a href="order-supply-pdf/{{$order->purchaseHId}}" class="ui blue basic circular icon button" data-tooltip="View PDF" data-inverted="" name="{{$estimate->estimateHId}}"><i class="eye icon"></i></a>
						<a href="order-supply-form/{{$order->purchaseHId}}" class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted=""><i class="write icon"></i></a>
                    </td>
                </tr>
            @endforeach
		</tbody>
	</table>
@stop


@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			$('#tsTitle').attr('class','title active');
			$('#tsContent').attr('class','content active');
			$('#stsTitle').attr('class','title active');
			$('#stsContent').attr('class','content active');
		    $('#listType').DataTable();
		});
		function modal(open){
			$('#' + open + '').modal('show').modal({
				closable: false,
			});
		}
	</script>
@stop