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
	<button class="ui positive button" name="modalNew" onclick="modal(this.name)"><i class="plus icon"></i>New Technician</button>
	<br><br>
	
	<table id="listType" class="ui celled definition five column table">
		<thead>
			<th></th>
			<th>Name</th>
			<th>Skills</th>
			<th>Contact</th>
			<th>Actions</th>
		</thead>
		<tbody>
			@foreach($technician as $tech)
				@if($tech->techIsActive==1)
					<tr>
						<td><img style="width: 150px;height:150px; object-fit: contain;" src="{{URL::asset($tech->techPic)}}"></td>
						<td>{{$tech->techFirst}} {{$tech->techMiddle}} {{$tech->techLast}}</td>
						<td>
							@foreach($tech->skill as $skill)
								@if($skill->tsIsActive==1)
									<li>{{$skill->skill->serviceName}}</li>
								@endif
							@endforeach
						</td>
						<td>{{$tech->techContact}}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="edit{{ $tech->techId }}" onclick="modal(this.name)"><i class="write icon"></i></button>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $tech->techId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
						<div class="ui modal" id="edit{{ $tech->techId }}">
							<div class="header">Update Technician</div>
							{!! Form::open(['action' => 'TechController@update','files'=>true]) !!}	
								<div class="content">
									<div class="description">
										<div class="ui form">								
											<input type="hidden" name="editTechId" value="{{$tech->techId}}">
											<div class="two fields">
												<div class="field" style="width:30%">
													<div class="ui centered card">
														<div class="image">
															<img id="{{$tech->techId}}" style="width:200px;height:200px;" src="{{URL::asset($tech->techPic)}}">
														</div>
														<div class="content">
															<input type="file" name="editTechPic" id="{{$tech->techId}}" onchange="readURLS(this,this.id)">
															<input type="hidden" name="currentPic" value="{{$tech->techPic}}">
														</div>
													</div>
												</div><br><br><br>
												<div class="field" style="width:70%">
													<div class="three fields">
														<div class="field">
															<label>First Name<span>*</span></label>
															<input type="text" name="editTechFirst" placeholder="John" value="{{$tech->techFirst}}">
														</div>
														<div class="field">
															<label>Middle Name</label>
															<input type="text" name="editTechMiddle" placeholder="Cena" value="{{$tech->techMiddle}}">
														</div>
														<div class="field">
															<label>Last Name<span>*</span></label>
															<input type="text" name="editTechLast" placeholder="Doe" value="{{$tech->techLast}}">
														</div>
													</div>
													<div class="three fields">
														<div class="field">
															<label>Street/Block<span>*</span></label>
															<input type="text" name="editStreet" placeholder="Baker St." value="{{$tech->techStreet}}">
														</div>
														<div class="field">
															<label>Brgy./Subd<span>*</span></label>
															<input type="text" name="editBrgy" placeholder="Brgy. 546" value="{{$tech->techBrgy}}">
														</div>
														<div class="field">
															<label>City<span>*</span></label>
															<input type="text" name="editCity" placeholder="Manila City" value="{{$tech->techCity}}">
														</div>
													</div>
													<div class="two fields">
														<div class="field">
															<label>Contact No.<span>*</span></label>
															<input type="text" name="editTechContact" placeholder="Contact No." value="{{$tech->techContact}}">
														</div>
														<div class="field">
															<label>Email</label>
															<input type="email" name="editTechEmail" placeholder="Email" value="{{$tech->techEmail}}">
														</div>
													</div>
													<div class="field">
														<label>Skills</label>
														<div id="editSkill{{$tech->techId}}" class="ui multiple search selection dropdown">
							    							<input type="hidden" name="editTechSkillId"><i class="dropdown icon"></i>
							    							<input class="search" autocomplete="off" tabindex="0">
							    							<div class="default text">Select Skills</div>
							    							<div class="menu" tabindex="-1">
							    								@foreach($skills as $skill)
							    									@if($skill->serviceIsActive==1)
							    										<div class="item" data-value="{{ $skill->serviceId }}">{{ $skill->serviceName }}</div>
							    									@endif
							    								@endforeach
							    							</div>
							    						</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="actions">
									<i>Note: All with <span>*</span> are required fields</i>
		        					<button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
		        					<button type="submit" class="ui positive button"><i class="write icon"></i>Update</button>
		        				</div>
		        				<script type="text/javascript">
		        					var array=[
		        						@foreach($tech->skill as $skill)
											@if($skill->tsIsActive==1)
												'{{$skill->skill->serviceId}}',
											@endif
										@endforeach
		        					];
		        					$('#editSkill{{$tech->techId}}').dropdown('set selected',array);
		        				</script>
	        				{!! Form::close() !!}
						</div>
						<div class="ui basic modal" id="del{{ $tech->techId }}" style="text-align:center">
							<div class="ui icon header">
								<i class="trash icon"></i>
								Deactivate
							</div>
							{!! Form::open(['action' => 'TechController@destroy']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="delTechId" value="{{ $tech->techId }}">
										<div class="ui small centered card">
											<div class="image">
												<img src="{{asset($tech->techPic)}}">
											</div>
										</div>
										<p>{{$tech->techFirst}} {{$tech->techMiddle}} {{$tech->techLast}}</p>
										<p>{{$tech->techContact}}</p>
									</div>
								</div>
								<div class="actions">
			        				<button type="submit" class="ui negative button"><i class="trash icon"></i>Deactivate</button>
			        				<button type="reset" class="ui positive button"><i class="plane icon"></i>Cancel</button>
			        			</div>
							{!! Form::close() !!}
						</div>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>

	<!--New Modal-->
	<div class="ui modal" id="modalNew">
		<div class="header">New Technician</div>
		<div class="content">
			<div class="description">
				<div class="ui form">
					{!! Form::open(['action' => 'TechController@create','files'=>true]) !!}
						<input type="hidden" name="techId" value="{{$newId}}">
						<div class="two fields">
							<div class="field" style="width:30%">
								<div class="ui centered card">
									<div class="image">
										<img id="blah" style="width:200px;height:200px" src="{{ asset('pics/steve1.jpg')}}">
									</div>
									<div class="content">
										<input id="imgInp" type="file" name="techPic">
									</div>
								</div>
							</div><br><br><br>
							<div class="field" style="width:70%">
								<div class="three fields">
									<div class="field">
										<label>First Name<span>*</span></label>
										<input type="text" name="techFirst" placeholder="John">
									</div>
									<div class="field">
										<label>Middle Name</label>
										<input type="text" name="techMiddle" placeholder="Cena">
									</div>
									<div class="field">
										<label>Last Name<span>*</span></label>
										<input type="text" name="techLast" placeholder="Doe">
									</div>
								</div>
								<div class="three fields">
									<div class="field">
										<label>Street/Block<span>*</span></label>
										<input type="text" name="street" placeholder="Baker St.">
									</div>
									<div class="field">
										<label>Brgy./Subd<span>*</span></label>
										<input type="text" name="brgy" placeholder="Brgy. 546">
									</div>
									<div class="field">
										<label>City<span>*</span></label>
										<input type="text" name="city" placeholder="Manila City">
									</div>
								</div>
								<div class="two fields">
									<div class="field">
										<label>Contact No.<span>*</span></label>
										<input type="text" name="techContact" placeholder="0905xxxxxxx">
									</div>
									<div class="field">
										<label>Email</label>
										<input type="text" name="techEmail" placeholder="example@yahoo.com">
									</div>
								</div>
								<div class="field">
									<label>Skills</label>
									<div class="ui multiple search selection dropdown">
		    							<input type="hidden" name="techSkillId"><i class="dropdown icon"></i>
		    							<input class="search" autocomplete="off" tabindex="0">
		    							<div class="default text">Select Skills</div>
		    							<div class="menu" tabindex="-1">
		    								@foreach($skills as $skill)
		    									@if($skill->serviceIsActive==1)
		    										<div class="item" data-value="{{ $skill->serviceId }}">{{ $skill->serviceName }}</div>
		    									@endif
		    								@endforeach
		    							</div>
		    						</div>
								</div>
							</div>
						</div>
	    				<div class="actions">
	    					<i>Note: All with <span>*</span> are required fields</i>
	    					<button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
	    					<button type="submit" class="ui positive button"><i class="plus icon"></i>Save</button>
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
		    $('.ui.dropdown').dropdown();
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
		function readURLS(input,id) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        reader.onload = function (e) {
		            $('#'+id+'').attr('src', e.target.result);
		        }
		        reader.readAsDataURL(input.files[0]);
		    }
		}
	</script>
@stop