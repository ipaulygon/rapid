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
				$('#modalNewItem').modal('show');
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

	<h2>Maintenance - Inspection Item</h2>
	<hr><br>
	<button class="ui primary button" name="modalNewItem" onclick="modal(this.name)"><i class="plus icon"></i>New Inspection Item</button>
	<br><br>
	<table id="list" class="ui celled four column table">
		<thead>
			<tr>
				<th>Inspection Item</th>
				<th>Description</th>
				<th>Inspection Type</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($inspect_item as $inspectItem)
				@if($inspectItem->inspectItemIsActive==1)
					<tr>
						<td>{{ $inspectItem->inspectItemName }}</td>
						<td>{{ $inspectItem->inspectItemDesc }}</td>
						<td>{{ $inspectItem->type->inspectTypeName }}</td>
						<td>
							<button class="ui primary basic circular icon button" data-tooltip="Update Record" data-inverted="" name="edit{{ $inspectItem->inspectItemId }}" onclick="modal(this.name)"><i class="write icon"></i></button>
							<button class="ui red basic circular icon button" data-tooltip="Deactivate Record" data-inverted="" name="del{{ $inspectItem->inspectItemId }}" onclick="modal(this.name)"><i class="trash icon"></i></button>
						</td>
						<!--Modal for Update-->
						<div class="ui small modal" id="edit{{ $inspectItem->inspectItemId }}">
							<div class="header">Update Inspection Type</div>
							{!! Form::open(['action' => 'InspectItemController@update']) !!}	
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
													<li>Inspection Item already exists. Update failed.</li>
												</div>
											@endif								
											<div class="sixteen wide field">
				        						<input type="hidden" name="editInspectItemId" value="{{ $inspectItem->inspectItemId }}">
				        					</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Inspect Item<span>*</span></label>
					        					</div>
					        					<div class="six wide field">
					        						<input maxlength="255" type="text" name="editInspectItemName" value="{{ $inspectItem->inspectItemName }}" placeholder="Inspect Item">
					        					</div>
					        					<div class="two wide field">
					                                <label>Inspection Type<span>*</span></label>
					                            </div>
					                            <div class="six wide field">
					                                <div class="ui search selection dropdown">
					                                    <input type="hidden" name="editInspectItemTypeId" value="{{ $inspectItem->type->inspectTypeName }}"><i class="dropdown icon"></i>
					                                    <input class="search" autocomplete="off" tabindex="0">
					                                    <div class="default text">Select Type</div>
					                                    <div class="menu" tabindex="-1">
					                                        @foreach($inspect_type as $types)
					                                            @if($types->inspectTypeIsActive==1)
					                                                <div class="item" data-value="{{ $types->inspectTypeId }}">{{ $types->inspectTypeName }}</div>
					                                            @endif
					                                        @endforeach
					                                    </div>
					                                </div>
					                            </div>
					        				</div>
					        				<div class="inline fields">
					        					<div class="two wide field">
					        						<label>Description</label>
					        					</div>
					        					<div class="fourteen wide field">
					        						<textarea maxlength="255" type="text" name="editInspectItemDesc" placeholder="Description">{{ $inspectItem->inspectItemDesc }}</textarea>
					        					</div>
					        				</div>
										</div>
									</div>
								</div>
								<div class="actions">
									<i>Note: All with <span>(*)</span> are required fields</i>
		        					<button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
		        					<button type="submit" class="ui primary button"><i class="write icon"></i>Update</button>
		        				</div>
	        				{!! Form::close() !!}
						</div>
						<!--Modal for Deactivate-->
						<div class="ui small basic modal" id="del{{ $inspectItem->inspectItemId }}" style="text-align:center">
							<div class="ui icon header">
								<i class="trash icon"></i>
								Deactivate
							</div>
							{!! Form::open(['action' => 'InspectItemController@destroy']) !!}
								<div class="content">
									<div class="description">
										<input type="hidden" name="delInspectItemId" value="{{ $inspectItem->inspectItemId }}">
										<p>
											<label>Inspection Item: {{$inspectItem->inspectItemName}}</label><br>
											<label>Inspection Type: {{$inspectItem->type->inspectTypeName}}</label><br>
											<label>Description: {{$inspectItem->inspectItemDesc}}</label>
										</p>
									</div>
								</div>
								<div class="actions">
			        				<button type="submit" class="ui negative button"><i class="trash icon"></i>Deactivate</button>
			        				<button type="reset" class="ui primary button"><i class="remove icon"></i>Cancel</button>
			        			</div>
							{!! Form::close() !!}
						</div>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>

	<!--New Modal-->
	<div class="ui small modal" id="modalNewItem">
        <div class="header">New Inspection Item</div>
        <div class="content">
            <div class="description">
                <div class="ui form">
                    {!! Form::open(['action' => 'InspectItemController@create']) !!}
                        <div class="ui error message"></div>
						@if($errors->any())
							<div class="ui negative message">
								<h3>Something went wrong!</h3>
								{!! implode('', $errors->all(
									'<li>:message</li>'
								)) !!}
							</div>
						@endif
                        <input type="hidden" name="inspectItemId" value="{{$newIdItem}}" readonly>
                        <div class="inline fields">
                            <div class="two wide field">
                                <label>Inspection Item<span>*</span></label>
                            </div>
                            <div class="six wide field">
                                <input maxlength="255" type="text" name="inspectItemName" placeholder="Inspection Item" value="{{old('inspectItemName')}}">
                            </div>
                            <div class="two wide field">
                                <label>Inspection Type<span>*</span></label>
                            </div>
                            <div class="six wide field">
                                <div class="ui search selection dropdown">
                                    <input type="hidden" name="inspectItemTypeId" value="{{old('inspectItemTypeId')}}"><i class="dropdown icon"></i>
                                    <input class="search" autocomplete="off" tabindex="0">
                                    <div class="default text">Select Type</div>
                                    <div class="menu" tabindex="-1">
                                        @foreach($inspect_type as $types)
                                            @if($types->inspectTypeIsActive==1)
                                                <div class="item" data-value="{{ $types->inspectTypeId }}">{{ $types->inspectTypeName }}</div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="inline fields">
                            <div class="two wide field">
                                <label>Description</label>
                            </div>
                            <div class="fourteen wide field">
                                <textarea maxlength="255" type="text" name="inspectItemDesc" placeholder="Description">{{old('inspectItemDesc')}}</textarea>
                            </div>
                        </div>
                        <div class="actions">
                            <i>Note: All with <span>(*)</span> are required fields</i>
                            <button type="reset" class="ui negative button"><i class="remove icon"></i>Close</button>
                            <button type="submit" class="ui primary button"><i class="plus icon"></i>Save</button>
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
			$('#msTitle').attr('class','title active');
			$('#msContent').attr('class','content active');
			$('#smsTitle').attr('class','title active');
			$('#smsContent').attr('class','content active');
		    $('#list').DataTable();
		    $('#listItem').DataTable();
		    $('.menu .item').tab();
		    $('.ui.dropdown').dropdown();
		    $('.ui.form').form({
			    fields: {
			    	inspectItemName: 'empty',
			    	inspectItemTypeId: 'empty',
			  	}
			});
			$('.ui.small.modal').form({
			    fields: {
			    	editInspectItemName: 'empty',
			    	editInspectItemTypeId: 'empty',
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