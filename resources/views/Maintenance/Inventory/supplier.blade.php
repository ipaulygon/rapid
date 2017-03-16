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

	@if(Session::has('new_error'))
		<script type="text/javascript">
			$(document).ready(function (){
				$('#modalNew').modal('show');
			});
		</script>
	@endif

	@if(Session::has('update_error'))
		<script type="text/javascript">
			$(document).ready(function (){
				$("#edit{!! session('update_error') !!}").modal('show');
			});
		</script>
	@endif

	<h2>Maintenance - Supplier</h2>
	<hr><br>
	<button class="ui green button" name="modalNew" onclick="modal(this.name)"><i class="plus icon"></i>New Supplier</button>
	<br><br>
	<table id="listType" class="ui celled five column table">
		<thead>
			<tr>
				<th>Supplier</th>
				<th>Contact Person</th>
				<th>Contact No.</th>
				<th>Address</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($supplier as $supplier)
				@if($supplier->supplierIsActive==1)
					<tr>
						<td>{{ $supplier->supplierName }}</td>
						<td>{{ $supplier->supplierPerson }}</td>
						<td>{{ $supplier->supplierContact }}</td>
						<td>{{ $supplier->supplierAddress }}</td>
						<td>
							<button class="ui green basic circular icon button" data-tooltip="Update Record" data-inverted="" name="edit{{ $supplier->supplierId }}" onclick="modal(this.name)"><i class="write icon"></i></button>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $supplier->supplierId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
						<!--Modal for Update-->
						<div class="ui small modal" id="edit{{ $supplier->supplierId }}">
							<div class="header">Update Supplier</div>
							{!! Form::open(['action' => 'SupplierController@update']) !!}
								<div class="content">
									<div class="description">
										<div class="ui form">
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
													<li>Supplier already exists. Update failed.</li>
												</div>
											@endif							
											<div class="sixteen wide field">
				        						<input type="hidden" name="editSupplierId" value="{{ $supplier->supplierId }}">
				        					</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Supplier<span>*</span></label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<input maxlength="255" type="text" name="editSupplierName" value="{{ $supplier->supplierName }}" placeholder="Supplier">
					        					</div>
					        				</div>
					        				<div class="inline fields">
						    					<div class="two wide field">
						    						<label>Contact Person<span>*</span></label>
						    					</div>
						    					<div class="six wide field">
						    						<input maxlength="255" type="text" name="editSupplierPerson" value="{{ $supplier->supplierPerson }}" placeholder="Contact Person">
						    					</div>
						    					<div class="two wide field">
						    						<label>Contact No.<span>*</span></label>
						    					</div>
						    					<div class="six wide field">
						    						<input maxlength="255" type="text" name="editSupplierContact" value="{{ $supplier->supplierContact }}" placeholder="Contact No.">
						    					</div>
						    				</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Address</label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<textarea maxlength="255" type="text" name="editSupplierAddress" placeholder="Address">{{ $supplier->supplierAddress }}</textarea>
					        					</div>
					        				</div>
										</div>
									</div>
								</div>
								<div class="actions">
									<i>Note: All with <span>*</span> are required fields</i>
		        					<button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
		        					<button type="submit" class="ui green button"><i class="write icon"></i>Update</button>
		        				</div>
	        				{!! Form::close() !!}
						</div>
						<!--Modal for Deactivate-->
						<div class="ui small basic modal" id="del{{ $supplier->supplierId }}" style="text-align:center">
							<div class="ui icon header">
								<i class="trash icon"></i>
								Deactivate
							</div>
							{!! Form::open(['action' => 'SupplierController@destroy']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="delSupplierId" value="{{ $supplier->supplierId }}">
										<p>
											<label>Supplier: {{$supplier->supplierName}}</label><br>
											<label>Contact Person: {{$supplier->supplierPerson}}</label>
											<label>Contact No: {{$supplier->supplierContact}}</label>
											<label></label>
											<label>Address: {{$supplier->supplierAddress}}</label>
										</p>
									</div>
								</div>
								<div class="actions">
			        				<button type="submit" class="ui negative button"><i class="trash icon"></i>Deactivate</button>
			        				<button type="reset" class="ui positive button"><i class="remove icon"></i>Cancel</button>
			        			</div>
							{!! Form::close() !!}
						</div>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>
	
	<!--New Modal-->
	<div class="ui small modal" id="modalNew">
		<div class="header">New Supplier</div>
		<div class="content">
			<div class="description">
				<div class="ui form">
					{!! Form::open(['action' => 'SupplierController@create']) !!}
						<input type="hidden" name="supplierId" value="{{ $newId }}" readonly>
						<div class="ui error message"></div>
						@if($errors->any())
							<div class="ui negative message">
								<h3>Something went wrong!</h3>
								{!! implode('', $errors->all(
									'<li>:message</li>'
								)) !!}
							</div>
						@endif
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Supplier<span>*</span></label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<input maxlength="255" type="text" name="supplierName" value="{{old('supplierName')}}" placeholder="Supplier">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Contact Person<span>*</span></label>
	    					</div>
	    					<div class="six wide field">
	    						<input maxlength="255" type="text" name="supplierPerson" value="{{old('supplierPerson')}}" placeholder="Contact Person">
	    					</div>
	    					<div class="two wide field">
	    						<label>Contact No.<span>*</span></label>
	    					</div>
	    					<div class="six wide field">
	    						<input maxlength="255" type="text" name="supplierContact" value="{{old('supplierContact')}}"  placeholder="Contact No.">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Address</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<textarea maxlength="255" type="text" name="supplierAddress" placeholder="Address" rows="2">{{old('supplierAddress')}}</textarea>
	    					</div>
	    				</div>
	    				<div class="actions">
	    					<i>Note: All with <span>*</span> are required fields</i>
	    					<button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
	    					<button type="submit" class="ui green button"><i class="plus icon"></i>Save</button>
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
			$('#miTitle').attr('class','title active');
			$('#miContent').attr('class','content active');
			$('#smiTitle').attr('class','title active');
			$('#smiContent').attr('class','content active');
		    $('#listType').DataTable();
		    $('.ui.form').form({
			    fields: {
			    	supplierName: 'empty',
					supplierPerson: 'empty',
					supplierContact: 'empty',
			  	}
			});
			$('.ui.small.modal').form({
			    fields: {
			    	editSupplierName: 'empty',
					editSupplierPerson: 'empty',
					editSupplierContact: 'empty',
			  	}
			});
		});
		function modal(open){
			$('#' + open + '').modal('show').modal({
				closable: false,
			});
		}
	</script>
@stop