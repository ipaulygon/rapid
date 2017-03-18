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

	<h2>Transaction - Receive Delivery</h2>
	<hr><br>
	<a class="ui primary button" href="{{URL::to('/transaction/receive-delivery-form')}}"><i class="plus icon"></i>New Delivery</a>
	<br><br>
	<table id="listType" class="ui celled three column table">
		<thead>
			<tr>
				<th>Reference No.</th>
				<th>Supplier</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($delivery as $delivery)
				<tr>
					<td>{{$delivery->deliveryHId}}</td>
					<td>{{$delivery->supplier->supplierName}}</td>
					<td>
						<a href="receive-delivery-pdf/{{$delivery->deliveryHId}}" class="ui secondary basic circular icon button" data-tooltip="View PDF" data-inverted="" name="{{$delivery->deliveryHId }}"><i class="eye icon"></i></a>
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
$('#tiTitle').attr('class','title active');
			$('#tiContent').attr('class','content active');
			$('#stiTitle').attr('class','title active');
			$('#stiContent').attr('class','content active');
		    $('#listType').DataTable();
		});
		function modal(open){
			$('#' + open + '').modal('show').modal({
				closable: false,
			});
		}
	</script>
@stop