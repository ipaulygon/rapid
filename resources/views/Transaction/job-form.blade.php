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

	<h2>Transaction - New Job Order</h2>
	<hr><br>

	<div class="ui form">
		{!! Form::open(['action' => 'JobController@create']) !!}
			<input type="hidden" name="jobId" value="{{$newId}}" readonly>
			<div class="field">
				<h3>No. {{$newId}}</h3>
			</div>
            <div class="ui stackable container secondary pointing menu">
                <a class="active item" data-tab="first">Primary Details</a>
                <a class="item" data-tab="second">Job Order Details</a>
            </div>
            <div class="ui active tab" data-tab="first">
                <div class="ui inverted segment top attached">
                    <h3 class="ui yellow header">Customer Information</h3>
                </div>
                <div class="ui attached segment">
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
                <div class="ui inverted segment top attached">
                    <h3 class="ui yellow header">Vehicle Information</h3>
                </div>
                <div class="ui attached segment">
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
                                <div class="default text">Toyota / Honda</div>
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
                                <div class="default text">Vios / WIGO</div>
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
            </div>
			<div class="ui tab" data-tab="second">
                <div class="inline fields">
                    <div class="two wide field">
                        <label>Description</label>
                    </div>
                    <div class="fourteen wide field">
                        <textarea name="jobDesc" placeholder="Description" rows="3"></textarea>
                    </div>
                </div>
                <div class="inline fields">
                    <div class="two wide field">
                        <label>Total cost: PhP</label>
                    </div>
                    <div class="eight wide field">
                        <input id="totalCost" style="border:none;font-weight: bold" type="text" name="totalCost" value="0.00" readonly>
                        <input id="totalCosts" style="border:none;font-weight: bold" type="hidden" name="totalCosts" value="0" readonly>
                    </div>
                </div>
                <!-- items -->
                <div class="ui inverted segment top attached">
                    <h3 class="ui yellow header">Items</h3>
                </div>
                <div class="ui attached segment">
                    <div class="inline fields">
                        <div class="two wide field">
                            <label>Items</label>
                        </div>
                        <div class="fourteen wide field">
                            <div style="width:100%" id="product" class="ui search multiple selection dropdown">
                                <input type="hidden" name="jobItemsId"><i class="dropdown icon"></i>
                                <input class="search" autocomplete="off" tabindex="0">
                                <div class="default text">Select Items</div>
                                <div class="menu" tabindex="-1">
                                    @foreach($promo as $promo)
                                        <div class="item" data-name="promo" title="{{$promo->promoCost}}" data-value="{{ $promo->promoId }}">{{$promo->promoName}}</div>
                                    @endforeach
                                    @foreach($package as $package)
                                        <div class="item" data-name="package" title="{{$package->packageCost}}" data-value="{{ $package->packageId }}">{{$package->packageName}}</div>
                                    @endforeach
                                    @foreach($products as $product)
                                        <div class="item" data-name="product" title="{{$product->pvCost}}" data-value="{{ $product->pvId }}">{{$product->product->brand->brandName}} - {{$product->product->productName}}| {{$product->variance->varianceSize}} - {{$product->variance->unit->unitName}}| {{$product->product->types->typeName}}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="list" class="ui celled table">
                        <thead>
                            <tr>
                                <th>Quantity</th>
                                <th>Items</th>
                                <th>Unit Price</th>
                                <th>Total Cost</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableInsert"></tbody>
                    </table>
                </div>
                 <div class="ui inverted segment top attached">
                    <h3 class="ui yellow header">Services</h3>
                </div>
                <div class="ui attached segment">
                    <div class="inline fields">
                        <div class="two wide field">
                            <label>Services</label>
                        </div>
                        <div class="fourteen wide field">
                            <div style="width:100%" id="service" class="ui search multiple selection dropdown">
                                <input type="hidden" name="jobServicesId"><i class="dropdown icon"></i>
                                <input class="search" autocomplete="off" tabindex="0">
                                <div class="default text">Select Services</div>
                                <div class="menu" tabindex="-1">
                                    @foreach($service as $service)
                                        <?php
                                            $serviceSize = "";
                                            if($service->serviceSize==1){
                                                $serviceSize = "Sedan";
                                            }else{
                                                $serviceSize = "Large Vehicle";
                                            }
                                        ?>
                                        <div class="item" data-name="service" title="{{$service->servicePrice}}" data-value="{{ $service->serviceId }}">{{$service->serviceName}} - {{$serviceSize}}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="list1" class="ui celled table">
                        <thead>
                            <tr>
                                <th>Services</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableInsert1"></tbody>
                    </table>
                </div>
            </div>
			<br>
			<hr>
			<i>Note: All with <span>(*)</span> are required fields</i>
			<div style="float:right">
				<a href="{{URL::to('/transaction/job')}}" type="reset" class="ui negative button"><i class="arrow left icon"></i>Back</a>
				<button type="submit" class="ui primary button"><i class="plus icon"></i>Save</button>
                <a href="{{URL::to('/transaction/payment-form')}}" type="reset" class="ui secondary button">Proceed to Payment<i class="arrow right icon"></i></a>
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
			$('#tTitle').attr('class','title header active');
$('#tContent').attr('class','content active');
$('#stTitle').attr('class','title header active');
$('#stContent').attr('class','content active');
$('#tsTitle').attr('class','title active');
            $('#tsContent').attr('class','content active');
            $('#stsTitle').attr('class','title active');
            $('#stsContent').attr('class','content active');
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