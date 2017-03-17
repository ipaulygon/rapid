@extends('layouts.master')

@section('content')
	<h2>Queries</h2>
	<hr><br>
	
	<div class="ui segment top attached">
		<h3 class="ui header">Queries</h3>
	</div>
	<div class="ui attached segment">
		<div class="ui form">
			<div class="inline fields">
				<div class="two wide field">
					<label>Select a query:</label>
				</div>
				<div class="twelve wide field">
					<div style="width:100%" id="vehiclePlate" class="ui selection dropdown" tabindex="0">
						<input type="hidden" name="vehiclePlateId"><i class="dropdown icon"></i>
						<div class="default text">Select a query</div>
						<div class="menu" tabindex="-1">
							<div class="item" data-value="1">Most availed parts/supplies</div>
							<div class="item" data-value="2">Most availed services</div>
							<div class="item" data-value="3">Top customers</div>
							<div class="item" data-value="4">Top Technicians</div>
							<div class="item" data-value="5">Customers who have balance(s)</div>
							<div class="item" data-value="6">Most vehicle repaired</div>
						</div>
					</div>
				</div>
				<div class="two wide field">
					<button class="ui primary button">Submit</button>
				</div>
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			$('#vehiclePlate.ui.dropdown').dropdown();
		});
	</script>
@stop