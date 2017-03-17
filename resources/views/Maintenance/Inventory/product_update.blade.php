@extends('layouts.master')

@section('content')
	<h2>Maintenance - Update Product</h2>
	<hr><br>

	<div class="ui form">
		{!! Form::open(['action' => 'ProductController@update']) !!}
			<input type="hidden" name="editProductId" value="{{$product[0]->productId}}" readonly>
			<div class="ui error message"></div>
			@if(Session::has('update_error'))
				@if($errors->any())
					<div class="ui negative message">
						<h3>Something went wrong!</h3>
						{!! implode('', $errors->all(
							'<li>:message</li>'
						)) !!}
					</div>
				@endif
			@endif
			@if(Session::has('update_unique'))
				<div class="ui negative message">
					<h3>Something went wrong!</h3>
					<li>Brand already exists. Update failed.</li>
				</div>
			@endif
			<div class="inline fields">
				<div class="two wide field">
					<label>Brand<span>*</span></label>
				</div>
				<div class="six wide field">
					<div id="brand" class="ui search selection dropdown">
						<input type="hidden" name="editProductBrandId" value="{{$product[0]->productBrandId}}"><i class="dropdown icon"></i>
						<input class="search" autocomplete="off" tabindex="0">
						<div class="default text">Select Brand</div>
						<div class="menu" tabindex="-1">
							@foreach($brand as $brand)
								@if($brand->brandIsActive==1)
									<div class="item" data-value="{{ $brand->brandId }}">{{ $brand->brandName }}</div>
								@endif
							@endforeach
						</div>
					</div>
				</div>
				<div class="two wide field">
					<label>Type<span>*</span></label>
				</div>
				<div class="six wide field">
					<div id="type" class="ui search selection dropdown" title="{{$product[0]->productId}}" onchange="reload(this.title)">
						<input id="drop{{$product[0]->productId}}" type="hidden" name="editProductTypeId" value="{{$product[0]->productTypeId}}"><i class="dropdown icon"></i>
						<input class="search" autocomplete="off" tabindex="0">
						<div class="default text">Select Type</div>
						<div class="menu" tabindex="-1">
							@foreach($type as $type)
								@if($type->typeIsActive==1)
									<div class="item" data-value="{{ $type->typeId }}">{{ $type->typeName }}</div>
								@endif
							@endforeach
						</div>
					</div>
				</div>
			</div>
			<div class="inline fields">
				<div class="two wide field">
					<label>Product<span>*</span></label>
				</div>
				<div class="fourteen wide field">
					<input maxlength="255" type="text" name="editProductName" value="{{$product[0]->productName}}" placeholder="Product">
				</div>
			</div>
			<div class="inline fields">
				<div class="two wide field">
					<label>Description</label>
				</div>
				<div class="fourteen wide field">
					<textarea maxlength="255" type="text" name="editProductDesc" placeholder="Description" rows="3">{{$product[0]->productDesc}}</textarea>
				</div>
			</div>
			<div class="three fields">
				<div class="field">
					<label>Variances</label>
					<div id="add{{$product[0]->productId}}" style="width:100%" class="ui multiple add search selection dropdown">
						<input id="variances" type="hidden" name="editVariance"><i class="dropdown icon"></i>
						<input class="search" autocomplete="off" tabindex="0">
						<div class="default text">Select Variances</div>
						<div id="menu{{$product[0]->productId}}" class="menu" tabindex="-1">
							@foreach($tv as $tv)
								@if($tv->tvIsActive==1 && $tv->tvTypeId==$product[0]->productTypeId)
									<div class="item" data-value="{{$tv->tvVarianceId}}" id="{{$product[0]->productId}}" title="{{$product[0]->productId}}">{{$tv->variance->varianceSize}}|{{$tv->variance->unit->unitName}}</div>
								@endif
							@endforeach
						</div>
					</div>
				</div>
				<div id="cost{{$product[0]->productId}}" class="field">
					<label>Price</label>
				</div>
				<div id="qty{{$product[0]->productId}}" class="field">
					<label>Threshold</label>
				</div>
			</div>
			<hr>
			<i>Note:<br> All with <span>*</span> are required fields. <br>All variances that are removed will also be removed in packages and promos.<br>Items inside the transaction will not be deleted.</i>
			<div style="float:right">
				<a href="{{URL::to('/maintenance/product')}}" type="reset" class="ui negative button"><i class="arrow left icon"></i>Back</a>
				<button type="submit" class="ui primary button"><i class="plus icon"></i>Update</button>
			</div>
		{!! Form::close() !!}
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			$('#mTitle').attr('class','title header active');
$('#mContent').attr('class','content active');
$('#smTitle').attr('class','title header active');
$('#smContent').attr('class','content active');
$('#miTitle').attr('class','title active');
			$('#miContent').attr('class','content active');
			$('#smiTitle').attr('class','title active');
			$('#smiContent').attr('class','content active');
		    $('#brand.ui.dropdown').dropdown();
		    $('#type.ui.dropdown').dropdown();
		    $('.add.ui.dropdown').dropdown({
		    	onAdd: function(value,text,$addedChoice){
		    		var prod = $addedChoice.attr('title');
		    		$("#cost"+prod).append('<div id="'+value+'" class="inline fields"><label id="'+value+'">'+text+'</label><div class="ui labeled input"><div class="ui label">Php</div><input style="text-align:right" id="Cost'+value+'" type="text" name="costs[]" required onchange="change(this.id)" onkeypress="return validate(event,this.id)" maxlength="8" data-content="Only numerical values are allowed"></div></div>');
		    		$("#cost"+prod).append('<input id="hiddenCost'+value+'" type="hidden" name="cost'+value+'">');
					$("#qty"+prod).append('<div id="'+value+'" class="inline fields"><label id="'+value+'">'+text+'</label><div class="ui right labeled input"><input style="text-align:right" id="Qty'+value+'" type="text" name="qtys[]" required onchange="changed(this.id)" onkeypress="return validated(event,this.id)" maxlength="3" data-content="Only numerical values are allowed"><div class="ui label">pcs</div></div></div>');
					$("#qty"+prod).append('<input id="hiddenQty'+value+'" type="hidden" name="qty'+value+'">');
				},
		    	onRemove: function(value, text, $removedChoice){
		    		var prod = $removedChoice.attr('title');
		    		$("#cost"+prod+" div[id="+value+"]").remove();
		    		$("#cost"+prod+" input[id=hiddenCost"+value+"]").remove();
					$("#qty"+prod+" div[id="+value+"]").remove();
		    		$("#qty"+prod+" input[id=hiddenQty"+value+"]").remove();
		    		// $("#cost"+prod+" label[id="+value+"]").remove();
		    	}
		    });
		    $('.ui.form').form({
			    fields: {
			    	editProductName: 'empty',
			    	editProductBrandId: 'empty',
			    	editProductTypeId: 'empty',
			  	}
			});
		    var variances = [
		    	@foreach($pv as $var)
		    		@if($var->pvIsActive==1)
		    			'{{$var->pvVarianceId}}',
		    		@endif
		    	@endforeach
		    ];
		    $('#add{{$product[0]->productId}}').dropdown('set selected',variances);
		    @foreach($pv as $var)
	    		@if($var->pvIsActive==1)
	    			$('#cost{{$product[0]->productId}} input[id=Cost{{$var->pvVarianceId}}]').val({{$var->pvCost}});
	    			$('#cost{{$product[0]->productId}} input[id=hiddenCost{{$var->pvVarianceId}}]').val({{$var->pvCost}});
					$('#qty{{$product[0]->productId}} input[id=Qty{{$var->pvVarianceId}}]').val({{$var->pvThreshold}});
	    			$('#qty{{$product[0]->productId}} input[id=hiddenQty{{$var->pvVarianceId}}]').val({{$var->pvThreshold}});
	    		@endif
	    	@endforeach
		});
		function change(id){
			var value = $("input[id="+id+"]").val();
			$("input[id=hidden"+id+"]").attr("value",value);
		}
		function changed(id){
			var value = $("input[id="+id+"]").val();
			$("input[id=hidden"+id+"]").attr("value",value);
		}
		function reload(title){
			$(".item#"+title).remove();
			$("#cost"+title+" div").remove();
			$("#cost"+title+" input").remove();
			// $("#cost"+title+" label").remove();
			$("#add"+title).dropdown('clear');
			var id = $("#drop"+title).val();
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
			});
			$.ajax({
				type: "POST",
				url: "{{url('maintenance/product/type')}}",
				data: {'id':id},
				dataType: "JSON",
				success:function(data){
					for(var x=0;x<data.data.length;x++){
						$("#menu"+title).append('<div class="item" data-value="'+data.data[x].variance["varianceId"]+'" id="'+title+'" title="'+title+'">'+data.data[x].variance["varianceSize"]+'|'+data.data[x].variance.unit["unitName"]+'</div>');
					}
				}
			});
		}
		function validate(event, idx) {
            var char = String.fromCharCode(event.which);
            var patt = /^\d*\.?\d*$/g;
            var res = patt.test(char);
            if (!res) {
                $("input[id="+idx+"]").popup('show');
                return false;
            }
            else {
                $("input[id="+idx+"]").popup('hide');
                
            }
        }
		function validated(event, idx) {
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