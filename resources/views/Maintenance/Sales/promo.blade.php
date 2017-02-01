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

	<!--Add Promo-->
	@if(Session::has('add_promo'))
		<div class="ui small modal" id="add_promo">
			<div class="header">Add Promo Items</div>
			{!! Form::open(['action' => 'PromoController@add']) !!}
				<div class="content">
					<div class="description">
						<div class="ui form">						
	    					
						</div>
					</div>
				</div>
				<div class="actions">
					<button type="reset" class="ui negative button"><i class="remove icon"></i>Clear</button>
					<button type="submit" class="ui positive button"><i class="write icon"></i>Add items</button>
				</div>
			{!! Form::close() !!}
		</div>
		<script type="text/javascript">
			$(document).ready(function (){
				$('#add_promo').modal('show');
			});
		</script>
	@endif

	<h2>Maintenance - Promo</h2>
	<hr><br>
	<button style="float:right" class="ui positive button" name="modalCreate" onclick="modal(this.name)"><i class="plus icon"></i>Add Promo</button>
	<br><br>
	<table id="list" class="ui celled table">
		<thead>
			<tr>
				<th>Promo</th>
				<th>Description</th>
				<th>Date Start</th>
				<th>Date End</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($promo as $promo)
				@if($promo->promoIsActive==1)
					<tr>
						<td>{{$promo->promoName}}</td>
						<td>{{$promo->promoDesc}}</td>
						<td>{{$promo->promoStart}}</td>
						<td>{{$promo->promoEnd}}</td>
						<td>
							<a class="ui blue basic button" href="/maintenance/promo/{{ $promo->promoId }}"><i class="plus icon"></i>Add Items</a>
							<button class="ui green basic button" name="edit{{ $promo->promoId }}" onclick="modal(this.name)"><i class="write icon"></i>Edit</button>
							<button class="ui red basic button" name="del{{ $promo->promoId }}" onclick="modal(this.name)"><i class="trash icon"></i>Delete</button>
						</td>
						<!--Modal for Edit-->
						<div class="ui small modal" id="edit{{ $promo->promoId }}">
							<div class="header">Edit Promo</div>
							{!! Form::open(['action' => 'PromoController@update']) !!}
								<div class="content">
									<div class="description">
										<div class="ui form">						
				        					<div class="inline fields">
						    					<div class="sixteen wide field">
						    						<input type="hidden" name="editPromoId" value="{{ $promo->promoId }}" readonly>
						    					</div>
						    				</div>
						    				<div class="inline fields">
						    					<div class="two wide field">
						    						<label>Promo</label>
						    					</div>
						    					<div class="fourteen wide field">
						    						<input type="text" name="editPromoName" value="{{ $promo->promoName }}" placeholder="Promo">
						    					</div>
						    				</div>
						    				<div class="inline fields">
						    					<div class="two wide field">
						    						<label>Description</label>
						    					</div>
						    					<div class="fourteen wide field">
						    						<input type="text" name="editPromoDesc" value="{{ $promo->promoDesc }}" placeholder="Description">
						    					</div>
						    				</div>
						    				<div class="inline fields">
						    					<div class="two wide field">
						    						<label>Start Date</label>
						    					</div>
						    					<div class="six wide field">
						    						<input type="date" name="editPromoStart" value="{{ $promo->promoStart }}" placeholder="Start" min="{{ $dateNow }}">
						    					</div>
						    					<div class="two wide field">
						    						<label>End Date</label>
						    					</div>
						    					<div class="six wide field">
						    						<input type="date" name="editPromoEnd" value="{{ $promo->promoEnd }}" placeholder="End" min="">
						    					</div>
						    				</div>
										</div>
									</div>
								</div>
								<div class="actions">
		        					<button type="reset" class="ui negative button"><i class="remove icon"></i>Clear</button>
		        					<button type="submit" class="ui positive button"><i class="write icon"></i>Update</button>
		        				</div>
							{!! Form::close() !!}
						</div>
						<!--Modal for Delete-->
						<div class="ui small basic modal" id="del{{ $promo->promoId }}" style="text-align:center">
							<div class="ui icon header">
								<i class="trash icon"></i>
								Delete
							</div>
							{!! Form::open(['action' => 'PromoController@destroy']) !!}
								<div class="content">
									<div class="description">
										<p>
											<input type="hidden" name="delPromoId" value="{{ $promo->promoId }}">
											<p>
												<label>Promo: {{$promo->promoName}}</label><br>
												<label>Description: {{$promo->promoDesc}}</label><br>
											</p>
										</p>
									</div>									
								</div>
								<div class="actions">
			        				<button type="submit" class="ui negative button"><i class="trash icon"></i>Delete</button>
			        				<button type="reset" class="ui positive button"><i class="plane icon"></i>Cancel</button>
			        			</div>
							{!! Form::close() !!}
						</div>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>
	
	<!--Create Modal-->
	<div class="ui small modal" id="modalCreate">
		<div class="header">Create Promo</div>
		<div class="content">
			<div class="description">
				<div class="ui form">
					{!! Form::open(['action' => 'PromoController@create']) !!}
						<div class="inline fields">
	    					<div class="sixteen wide field">
	    						<input type="hidden" name="promoId" value="{{$newId}}" readonly>
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Promo</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<input type="text" name="promoName" placeholder="Promo">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Description</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<input type="text" name="promoDesc" placeholder="Description">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Start Date</label>
	    					</div>
	    					<div class="six wide field">
	    						<input type="date" name="promoStart" placeholder="Start" min="{{$dateNow}}">
	    					</div>
	    					<div class="two wide field">
	    						<label>End Date</label>
	    					</div>
	    					<div class="six wide field">
	    						<input type="date" name="promoEnd" placeholder="End" min="">
	    					</div>
	    				</div>
	    				<div class="actions">
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
		    $('#list').DataTable();
		});
		/*$('#create').click(function(){
        	$('#modalCreate').modal('show');    
    	});*/
		function modal(open){
			$('#' + open + '').modal('show');
		}
	</script>
@stop