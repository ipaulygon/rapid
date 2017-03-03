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

	<h2>Maintenance - New Product</h2>
	<hr><br>

	<div class="ui form">
		{!! Form::open(['action' => 'ProductController@create']) !!}
			<input type="hidden" name="productId" value="{{ $newId }}" readonly>
			<div class="inline fields">
				<div class="two wide field">
					<label>Brand<span>*</span></label>
				</div>
				<div class="six wide field">
					<div id="brand" class="ui search selection dropdown">
						<input type="hidden" name="productBrandId"><i class="dropdown icon"></i>
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
					<div id="type" class="ui search selection dropdown" title="{{$newId}}" onchange="reload(this.title)">
						<input id="drop{{$newId}}" type="hidden" name="productTypeId"><i class="dropdown icon"></i>
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
					<input type="text" name="productName" placeholder="Product">
				</div>
			</div>
			<div class="inline fields">
				<div class="two wide field">
					<label>Description</label>
				</div>
				<div class="fourteen wide field">
					<textarea type="text" name="productDesc" placeholder="Description" rows="3"></textarea>
				</div>
			</div>
			<div class="two fields">
				<div class="field">
					<label>Variances</label>
					<div id="add{{$newId}}" style="width:100%" class="ui multiple add search selection dropdown">
						<input id="variances" type="hidden" name="variance"><i class="dropdown icon"></i>
						<input class="search" autocomplete="off" tabindex="0">
						<div class="default text">Select Variances</div>
						<div id="menu{{$newId}}" class="menu" tabindex="-1"></div>
					</div>
				</div>
				<div id="cost{{$newId}}" class="field">
					
				</div>
			</div>
			<hr>
			<i>Note: All with <span>*</span> are required fields</i>
			<div style="float:right">
				<a href="{{URL::to('/maintenance/product')}}" type="reset" class="ui negative button"><i class="arrow left icon"></i>Back</a>
				<button type="submit" class="ui positive button"><i class="plus icon"></i>Save</button>
			</div>
		{!! Form::close() !!}
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			$('#miTitle').attr('class','title active');
			$('#miContent').attr('class','content active');
			$('#smiTitle').attr('class','title active');
			$('#smiContent').attr('class','content active');
		    $('#brand.ui.dropdown').dropdown();
		    $('#type.ui.dropdown').dropdown();
		    $('.add.ui.dropdown').dropdown({
		    	onAdd: function(value,text,$addedChoice){
		    		var prod = $addedChoice.attr('title');
		    		$("#cost"+prod).append('<div id="'+value+'" class="inline fields"><div class="four wide field"><label id="'+value+'">'+text+'</label></div><div class="twelve wide field"><div class="ui labeled input"><div class="ui label">Php</div><input id="'+value+'" type="text" name="cost[]" required onkeypress="return validate(event,this.id)" maxlength="8" data-content="Only numerical values are allowed"></div></div></div>');
		    	},
		    	onRemove: function(value, text, $removedChoice){
		    		var prod = $removedChoice.attr('title');
		    		$("#cost"+prod+" div[id="+value+"]").remove();
		    		/*$("#cost"+prod+" input[id="+value+"]").remove();
		    		$("#cost"+prod+" label[id="+value+"]").remove();*/
		    	}
		    });
		    $('.ui.form').form({
			    fields: {
			    	productName: 'empty',
			    	productBrandId: 'empty',
			    	productTypeId: 'empty',
			  	}
			});
		});
		function reload(title){
			$(".item#"+title).remove();
			$("#cost"+title+" div").remove();
			$("#cost"+title+" input").remove();
			$("#cost"+title+" label").remove();
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
            var patt = /^\d*\.?\d*$/;
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