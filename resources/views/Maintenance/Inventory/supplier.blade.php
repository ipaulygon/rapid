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

	<h2>Maintenance - Supplier</h2>
	<hr><br>
	<button class="ui green button" name="modalNew" onclick="modal(this.name)"><i class="plus icon"></i>New Supplier</button>
	<br><br>
	<table id="listType" class="ui celled three column table">
		<thead>
			<tr>
				<th>Supplier</th>
				<th>Description</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($supplier as $supplier)
				@if($supplier->supplierIsActive==1)
					<tr>
						<td>{{ $supplier->supplierName }}</td>
						<td>{{ $supplier->supplierDesc }}</td>
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
											<div class="sixteen wide field">
				        						<input type="hidden" name="editSupplierId" value="{{ $supplier->supplierId }}">
				        					</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Supplier<span>*</span></label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<input type="text" name="editSupplierName" value="{{ $supplier->supplierName }}" placeholder="Supplier">
					        					</div>
					        				</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Description</label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<textarea type="text" name="editSupplierDesc" placeholder="Description">{{ $supplier->supplierDesc }}</textarea>
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
											<label>Description: {{$supplier->supplierDesc}}</label>
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
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Supplier<span>*</span></label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<input type="text" name="supplierName" placeholder="Supplier">
	    					</div>
	    				</div>
	    				<div class="inline fields">
	    					<div class="two wide field">
	    						<label>Description</label>
	    					</div>
	    					<div class="fourteen wide field">
	    						<textarea type="text" name="supplierDesc" placeholder="Description"></textarea>
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
			  	}
			});
			$('.ui.small.modal').form({
			    fields: {
			    	editSupplierName: 'empty',
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