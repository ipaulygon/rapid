@extends('layouts.master')

@section('content')
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

	<h2>Maintenance - New Promo</h2>
	<hr><br>

	<div class="ui form">
		{!! Form::open(['action' => 'PromoController@create']) !!}
			<input type="hidden" name="promoId" value="{{ $newId }}" readonly>
			<div class="inline fields">
				<div class="two wide field">
					<label>Promo<span>*</span></label>
				</div>
				<div class="six wide field">
					<input type="text" name="promoName" placeholder="Promo">
				</div>
				<div class="two wide field">
					<label>Price<span>*</span></label>
				</div>
				<div class="six wide field">
					<div class="ui labeled input">
						<div class="ui label">Php</div>
						<input type="text" name="promoCost" placeholder="100">
					</div>
				</div>
			</div>
			<div class="inline fields">
				<div class="two wide field">
					<label>Promo Type</label>
				</div>
				<div class="six wide field">
					<div class="grouped fields">
						<div class="field">
							<div class="ui radio checkbox">
								<input type="radio" name="promoType" value="1" checked="" onchange="types(this.value)">
								<label>Date based</label>
							</div>
						</div>
						<div class="field">
							<div class="ui radio checkbox">
								<input type="radio" name="promoType" value="2" onchange="types(this.value)">
								<label>Supply based</label>
							</div>
						</div>
						<div class="field">
							<div class="ui radio checkbox">
								<input type="radio" name="promoType" value="3" onchange="types(this.value)">
								<label>Date and supply based</label>
							</div>
						</div>
					</div>
				</div>
				<div class="two wide field">
					<label>Supply</label>
				</div>
				<div class="six wide field">
					<div class="ui right labeled input">
						<input id="supplies" type="text" name="promoSupplies" placeholder="Pieces">
						<div class="ui label">
							pcs.
						</div>
					</div>
				</div>
			</div>
			<div class="inline fields">
				<div class="two wide field">
					<label>Start Date<span>*</span></label>
				</div>
				<div class="six wide field">
					<input id="start" type="hidden" name="promoStart">
					<input class="start" type="text" name="start" placeholder="Start Date" onchange="date(this.value,this.name)">
				</div>
				<div class="two wide field">
					<label>End Date</label>
				</div>
				<div class="six wide field">
					<input id="end" type="hidden" name="promoEnd">
					<input class="end" type="text" name="end" placeholder="End Date" onchange="date(this.value,this.name)">
				</div>
			</div>
			<div class="inline fields">
				<div class="two wide field">
					<label>Description</label>
				</div>
				<div class="fourteen wide field">
					<textarea type="text" name="promoDesc" placeholder="Description" rows="2"></textarea>
				</div>
			</div>
			<div class="three fields">
				<div class="field">
					<label>Products:</label>
					<div id="add" style="width:100%" class="ui multiple search selection dropdown">
						<input type="hidden" name="promoProductId"><i class="dropdown icon"></i>
						<input class="search" autocomplete="off" tabindex="0">
						<div class="default text">Select Products</div>
						<div class="menu" tabindex="-1">
							@foreach($product as $product)
								@if($product->pvIsActive==1)
									<div class="item" title="{{$newId}}" data-value="{{ $product->pvId }}">{{$product->product->brand->brandName}} - {{$product->product->productName}}| {{$product->variance->varianceSize}} - {{$product->variance->unit->unitName}}| {{$product->product->types->typeName}}</div>
								@endif
							@endforeach
						</div>
					</div>
				</div>
				<div class="field" id="qty{{$newId}}">
					<label>Quantity:</label>
				</div>
				<div class="field">
					<label>Services:</label>
					<div id="serv" style="width:100%" class="ui multiple search selection dropdown">
						<input type="hidden" name="promoServiceId"><i class="dropdown icon"></i>
						<input class="search" autocomplete="off" tabindex="0">
						<div class="default text">Select Services</div>
						<div class="menu" tabindex="-1">
							@foreach($service as $service)
								@if($service->serviceIsActive==1)
									<div class="item" data-value="{{ $service->serviceId }}">{{$service->serviceName}} - {{$service->categories->categoryName}}</div>
								@endif
							@endforeach
						</div>
					</div>
				</div>
			</div>
			<hr>
			<i>Note: All with <span>*</span> are required fields</i>
			<div style="float:right">
				<a href="{{URL::to('/maintenance/promo')}}" type="reset" class="ui negative button"><i class="arrow left icon"></i>Back</a>
				<button type="submit" class="ui positive button"><i class="plus icon"></i>Save</button>
			</div>
		{!! Form::close() !!}
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
		    $('#listType').DataTable();
		    $('#serv.ui.dropdown').dropdown();
		    $('#supplies').attr("disabled",true);
		    $('#supplies').val(0);
		    $('#add.ui.dropdown').dropdown({
		    	onAdd: function(value,text,$addedChoice){
		    		var prod = $addedChoice.attr('title');
		    		$("#qty"+prod).append('<div id="'+value+'"><label id="'+value+'">'+text+'</label><div class="ui right labeled input"><input id="'+value+'" type="text" name="qty[]"><div class="ui label">pieces</div></div></div>');
		    	},
		    	onRemove: function(value, text, $removedChoice){
		    		var prod = $removedChoice.attr('title');
		    		$("#qty"+prod+" div[id="+value+"]").remove();
				}
		    });
		    $( function() {
			    var dateFormat = "MM d, yy",
			    	from = $( ".start" ).datepicker({
			    		dateFormat: "MM d, yy",
			    		changeMonth: true,
			          	minDate: new Date(),
			        }).on( "change", function() {
						to.datepicker( "option", "minDate", getDate( this ) );
			        }),
			    	to = $( ".end" ).datepicker({
			    		minDate: new Date(),
			        	changeMonth: true,
			        	dateFormat: "MM d, yy",
			     	}).on( "change", function() {
			        	from.datepicker( "option", "maxDate", getDate( this ) );
			      	});
			 
			    function getDate( element ) {
			    	var date;
			      	try {
			        	date = $.datepicker.parseDate( dateFormat, element.value );
			      	} catch( error ) {
			        	date = null;
			      	}
			      return date;
			    }
			});
		});
		function date(date,name){
			var oldDate = new Date(date);
			var month = oldDate.getMonth()+1;
			if(month<10){
				month = "0"+month;
			}
			var day = oldDate.getDate();
			if(day<10){
				day = "0"+day;
			}
			var year = oldDate.getFullYear();
			var newDate = year+"-"+month+"-"+day;
			$("#"+name).val(newDate);
		}
		function types(type){
			if(type==1){
				$('#supplies').attr("disabled",true);
				$('#supplies').attr("value",0);
				$('.start').attr("disabled",false);
				$('.end').attr("disabled",false);
				$('#supplies').val('');
				$('.start').val('');
				$('.end').val('');
			}if(type==2){
				$('#supplies').attr("disabled",false);
				$('.start').attr("disabled",true);
				$('#start').val('');
				$('.end').attr("disabled",true);
				$('#end').val('');
			}if(type==3){
				$('#supplies').attr("disabled",false);
				$('.start').attr("disabled",false);
				$('.end').attr("disabled",false);
			}
		}
	</script>
@stop