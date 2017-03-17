@extends('layouts.master')

@section('content')
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

    <style type="text/css">
        .ui.form input{
            border: none;
        }
    </style>

	<h2>Transaction - New Payment</h2>
	<hr><br>

	<div class="ui form">
		{!! Form::open(['action' => 'PaymentController@create']) !!}
			<input type="hidden" name="jobId" value="{{$newId}}" readonly>
			<div class="field">
				<h3>No. {{$newId}}</h3>
			</div>
            <div class="ui two fields">
                <div class="field">
                    <div class="ui inverted segment top attached">
                        <h3 class="ui yellow header">Customer Information</h3>
                    </div>
                    <div class="ui attached segment">
                        <label>Customer Name:</label><br>
                        <label>Address:</label><br>
                        <label>Contact No.:</label><br>
                        <label>Email:</label><br>
                    </div>
                </div>
                <div class="field">
                    <div class="ui inverted segment top attached">
                        <h3 class="ui yellow header">Vehicle Information</h3>
                    </div>
                    <div class="ui attached segment">
                        <label>Vehicle: </label><br>
                        <label>Type:</label><br>
                        <label>Engine:</label><br>
                        <label>Mileage:</label><br>
                    </div>
                </div>
            </div>
            <div class="ui inverted segment top attached">
                <h3 class="ui yellow header">Order Information</h3>
            </div>
            <div class="ui attached segment">
                <label>Description:</label><br>

                <table id="list" class="ui celled table">
                    <thead>
                        <tr>
                            <th>Quantity</th>
                            <th>Product</th>
                            <th>Description</th>
                            <th>Unit Price(PhP)</th>
                            <th>Total Cost(PhP)</th>
                        </tr>
                    </thead>
                    <tbody id="tableInsert"></tbody>
                </table>
                <h3>Total Cost:</h3>
            </div>
			<hr>
			<i>Note: All with <span>(*)</span> are required fields</i>
			<div style="float:right">
				<a href="{{URL::to('/transaction/payment')}}" type="reset" class="ui negative button"><i class="arrow left icon"></i>Back</a>
				<button type="submit" class="ui primary button"><i class="plus icon"></i>Save</button>
			</div>
		{!! Form::close() !!}
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
            $('.menu .item').tab();
			var t = $('#list').DataTable({
				pageLength: 100,
				paging: false,
				info: false,
                ordering: false,
                searching: false,
			});
            var t1 = $('#list1').DataTable({
				pageLength: 100,
				paging: false,
				info: false,
                ordering: false,
			});
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
			$('#supplier.ui.dropdown').dropdown();
			$('#product.ui.dropdown').dropdown({
				onAdd:function(value,text,$addedChoice){
					var cost = $addedChoice.attr('title');
                    var named = $addedChoice.attr('data-name');
					addRow(value,text,cost,named);
				},
				onRemove:function(value,text,$removedChoice){
					removeRow(value);
				}
			});
            $('#service.ui.dropdown').dropdown({
				onAdd:function(value,text,$addedChoice){
					var cost = $addedChoice.attr('title');
					addRowS(value,text,cost);
				},
				onRemove:function(value,text,$removedChoice){
					removeRowS(value);
				}
			});
			$('.ui.form').form({
			    fields: {
			    	jobSupplierId: 'empty',
			    	jobProductId: 'empty',
			  	}
			});
		});
		function addRow(value,text,cost,named){
			var t = $('#list').DataTable();
			t.row.add( [
	            '<div class="ui fluid input"><input id="'+value+'" name="'+named+'qty[]" onchange="compute(this.value,this.id)" onkeypress="return validate(event,this.id)" type="text" maxlength="3" data-content="Only numerical values are allowed" required></div>',
	            text,
	            '<div class="ui fluid input"><input id="cost'+value+'" style="border:none" type="text" value="'+cost+'" readonly></div>',
	            '<div class="ui fluid input"><input id="total'+value+'" style="border:none" type="text" value="0" readonly></div>',
	            '<span id="'+value+'" onclick="removeRowd(this.id)" class="ui circular icon negative button deleteRow"><i class="ui remove icon"></i></span>',
	        ] ).draw( false );
		}
        function addRowS(value,text,cost){
			var t = $('#list1').DataTable();
			t.row.add( [
	            text,
	            '<div class="ui fluid input"><input id="cost'+value+'" style="border:none" type="text" value="'+cost+'" readonly></div>',
	            '<span id="'+value+'" onclick="removeRowdS(this.id)" class="ui circular icon negative button deleteRow"><i class="ui remove icon"></i></span>',
	        ] ).draw( false );
            var total = $('#totalCosts').val();
            total = eval(cost+"+"+total);
            $('#totalCost').val(total.toFixed(2));
			$('#totalCosts').val(total.toFixed(2));
		}
		function compute(value,idx){
			var cost = $('input[id=cost'+idx+']').val();
			var computed = cost*value;
			var minus = $('input[id=total'+idx+']').val();
			$('input[id=total'+idx+']').val(computed);
			var total = eval($('#totalCosts').val()+"+"+computed+"-"+minus).toFixed(2);
			$('#totalCost').val(total.toLocaleString('en_PH'));
			$('#totalCosts').val(total);
		}
		function removeRow(value){
			var totalCost = $('#totalCosts').val();
			var cost = $('input[id=total'+value+']').val();
			totalCost = eval(totalCost+"-"+cost).toFixed(2);
			$('#totalCost').val(totalCost);
			$('#totalCosts').val(totalCost);
			var t = $('#list').DataTable();
		    t.row( $('input#'+value).parents('tr') ).remove().draw();
		}
        function removeRowS(value){
			var totalCost = $('#totalCosts').val();
			var cost = $('input[id=cost'+value+']').val();
			totalCost = eval(totalCost+"-"+cost).toFixed(2);
			$('#totalCost').val(totalCost);
			$('#totalCosts').val(totalCost);
			var t = $('#list1').DataTable();
		    t.row( $('input#cost'+value).parents('tr') ).remove().draw();
		}
		function removeRowd(value){
			var array = [value,"hello"];
			$('#product').dropdown('remove selected',array);
		}
        function removeRowdS(value){
			var array = [value,"hello"];
			$('#service').dropdown('remove selected',array);
		}
		function validate(event, idx){
			var char = String.fromCharCode(event.which);
            var patt = /\d/;
            var res = patt.test(char);
            if (!res) {
                $("input[id="+idx+"]").popup('show');
                return false;
            }
            else {
                $("input[id="+idx+"]").popup('hide');
            }
		}
	</script>
@stop