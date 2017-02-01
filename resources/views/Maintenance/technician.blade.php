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

	<h2>Maintenance - Technician</h2>
	<hr><br>
	<button class="ui positive button" name="modalCreate" onclick="modal(this.name)"><i class="plus icon"></i>Add Technician</button>
	<br><br>
	
	<!--Create Modal-->
	<div class="ui modal" id="modalCreate">
		<div class="header">Add Technician</div>
		<div class="content">
			<div class="description">
				<div class="ui form">
					{!! Form::open(['action' => 'TechController@create','files' => 'true']) !!}
						<div class="ui small centered card">
							<div class="image">
								<img id="blah" src="{{ asset('pics/steve1.jpg')}}">
							</div>
							<div class="content">
								<input id="imgInp" type="file" name="pic" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|images/*">
							</div>
						</div>
						<div class="three fields">
							<div class="field">
								<label>First Name<span>*</span></label>
								<input type="text" name="firstName" placeholder="First Name">
							</div>
							<div class="field">
								<label>Middle Name</label>
								<input type="text" name="middleName" placeholder="Middle Name">
							</div>
							<div class="field">
								<label>Last Name<span>*</span></label>
								<input type="text" name="lastName" placeholder="Last Name">
							</div>
						</div>
						<div class="three fields">
							<div class="field">
								<label>Street/Block<span>*</span></label>
								<input type="text" name="street" placeholder="Street/Block">
							</div>
							<div class="field">
								<label>Brgy./Subd<span>*</span></label>
								<input type="text" name="brgy" placeholder="Brgy/Subd">
							</div>
							<div class="field">
								<label>City<span>*</span></label>
								<input type="text" name="city" placeholder="City">
							</div>
						</div>
						<div class="two fields">
							<div class="field">
								<label>Contact No.<span>*</span></label>
								<input type="text" name="contact" placeholder="Contact No.">
							</div>
							<div class="field">
								<label>Email</label>
								<input type="text" name="email" placeholder="Email">
							</div>
						</div>
	    				<div class="actions">
	    					<i>Note: All with <span>*</span> are required fields</i>
	    					<button type="reset" class="ui negative button"><i class="remove icon"></i>Clear</button>
	    					<button type="submit" class="ui positive button"><i class="plus icon"></i>Create</button>
	    				</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@stop


@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
		    $('#listType').DataTable();
		});
		function modal(open){
			$('#' + open + '').modal('show');
		}
		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        reader.onload = function (e) {
		            $('#blah').attr('src', e.target.result);
		        }
		        reader.readAsDataURL(input.files[0]);
		    }
		}
		$("#imgInp").change(function(){
		    readURL(this);
		});
	</script>
@stop