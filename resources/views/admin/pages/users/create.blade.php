@extends('admin.layouts.default')

@section('title')
Users Create
@stop

@section('content')

<div class="content page_tables">

	<!-- PAGE HEADER : STARTS -->
	<div class="page_header clearfix">
		@if(isset($user))
		<h2 class="p_title">Edit {{ucwords($user->first_name)}} Info</h2>
		@else
		<h2 class="p_title">Create User</h2>
			{{--{{dd(Sentinel::getUser()->first_name)}}--}}
		@endif

		<ul class="p_actions ul_reset clearfix">
			<li>
				<a class="button" type="button" href="{{URL::route('admin.users.index')}}">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
						<path d="M21 11H6.83l3.58-3.59L9 6l-6 6 6 6 1.41-1.41L6.83 13H21z"/>
					</svg>
					Back To Users
				</a>
			</li>
		</ul>

	</div>
	<!-- PAGE HEADER : ENDS -->

	<!-- PAGE CONTENT : STARTS -->
	<div class="page_content">
		@if(isset($user))
		{!!Form::model($user,['route'=>['admin.users.update',$user->id],'method'=>'PUT'])!!}
		@else
		{!!Form::open(['route'=>'admin.users.store'])!!}
		@endif
		<ul class="ss_form">
			<li class="row">
				<div class="col-xs-6">
					{!!Form::label('first_name','First Name')!!}
					{!!Form::text('first_name', old('first_name'), ['placeholder'=>'First Name'])!!}
					@if(count($errors)>0)
					<span class="ss_error">{{$errors->first('first_name')}}</span>
					@endif
				</div>
			</li>
			<li class="row">
				<div class="col-xs-6">
					{!!Form::label('last_name','Last Name')!!}
					{!!Form::text('last_name', old('last_name'), ['placeholder'=>'Last Name'])!!}
				</div>
			</li>
			<li class="row">
				<div class="col-xs-6">
					{!!Form::label('email','Email')!!}
					{!!Form::text('email', old('email'), ['placeholder'=>'Email'])!!}
					@if(count($errors)>0)
					<span class="ss_error">{{$errors->first('email')}}</span>
					@endif
				</div>
			</li>

			<li class="row">
				<div class="col-xs-6">
					{!!Form::label('username','username')!!}
					{!!Form::text('username', old('username'), ['placeholder'=>'Username'])!!}
					@if(count($errors)>0)
					<span class="ss_error">{{$errors->first('username')}}</span>
					@endif
				</div>
			</li>
			<li class="row">
				<div class="col-xs-6">
					{!!Form::label('phone','Phone')!!}
					{!!Form::text('phone',old('phone'),['placeholder'=>'Phone'])!!}
					@if(count($errors)>0)
					<span class="ss_error">{!!$errors->first('phone')!!}</span>
					@endif
				</div>
			</li>
			<li class="row">
				<div class="col-xs-6">
					{!!Form::label('address','Address')!!}
					{!!Form::textarea('address',old('address'),['placeholder'=>'Address'])!!}
					@if(count($errors)>0)
					<span class="ss_error">{!!$errors->first('address')!!}</span>
					@endif
				</div>
			</li>
			<li class="row">
				<div class="col-xs-6">
					{!!Form::label('role','User Role')!!}
					{!!Form::select('role',config('site.user_roles'),old('role'),['placeholder'=>'User Role','id'=>'role'])!!}
					@if(count($errors)>0)
					<span class="ss_error">{{$errors->first('role')}}</span>
					@endif
				</div>
			</li>
			<li class="row" id="areas">
				<div class="col-xs-6">
					{!! Form::label('area_id','Area') !!}
					@if(isset($areasUsers))
					{!! Form::select('area_id[]',$areas,$areasUsers,['placeholder'=>'Select Area','id'=>'area_id','multiple'=>'multiple']) !!}

					@else
					{!! Form::select('area_id[]',[],old('area_id[]'),['placeholder'=>'Select Area','id'=>'area_id','multiple'=>'multiple']) !!}
					@endif
					@if(count($errors)>0)
					<span class="ss_error">{{$errors->first('area_id')}}</span>
					@endif
				</div>
			</li>
			<li class="row" id="salesperson">
				<div class="col-xs-6">
					{!! Form::label('salesperson_id','Salespersons') !!}
					@if(isset($userssalesperson))
					{!! Form::select('salesperson_id[]',$salespersons,$userssalesperson,['placeholder'=>'Select Salesperson','id'=>'salesperson_id','multiple'=>'multiple']) !!}
					@else
					{!! Form::select('salesperson_id[]',[],old('salesperson_id[]'),['placeholder'=>'Select Salesperson','id'=>'salesperson_id','multiple'=>'multiple']) !!}
					@endif
					@if(count($errors)>0)
					<span class="ss_error">{{$errors->first('salesperson_id')}}</span>
					@endif
				</div>
			</li>
			<li class="row" id="permissions">
				<div class="col-xs-6 permissions">
					{!!Form::label('','Screen Permissions')!!}
					<div class="row">
						<div class="col-xs-4">
							@if(isset($user) && in_array('users',$user->permissions))
							{!!Form::checkbox('permissions[]','users',true,['id'=>'users-checkbox'])!!}
							@else
							{!!Form::checkbox('permissions[]','users',false,['id'=>'users-checkbox'])!!}
							@endif
							{!!Form::label('users-checkbox','Users')!!}
						</div>
						<div class="col-xs-4">
							@if(isset($user) && in_array('clients',$user->permissions))
							{!!Form::checkbox('permissions[]','clients',true,['id'=>'clients-checkbox'])!!}
							@else
							{!!Form::checkbox('permissions[]','clients',false,['id'=>'clients-checkbox'])!!}
							@endif
							{!!Form::label('clients-checkbox','Clients')!!}
						</div>
						<div class="col-xs-4">
							@if(isset($user) && in_array('products',$user->permissions))
							{!!Form::checkbox('permissions[]','products',true,['id'=>'products-checkbox'])!!}
							@else
							{!!Form::checkbox('permissions[]','products',false,['id'=>'products-checkbox'])!!}
							@endif
							{!!Form::label('products-checkbox','Products')!!}
						</div>

						<div class="col-xs-4">
							@if(isset($user) && in_array('tasks',$user->permissions))
							{!!Form::checkbox('permissions[]','tasks',true,['id'=>'tasks-checkbox'])!!}
							@else
							{!!Form::checkbox('permissions[]','tasks',false,['id'=>'tasks-checkbox'])!!}
							@endif
							{!!Form::label('tasks-checkbox','Tasks')!!}
						</div>
					<!-- </div>

					<div class="row"> -->
						<div class="col-xs-4">
							@if(isset($user) && in_array('orders',$user->permissions))
							{!!Form::checkbox('permissions[]','orders',true,['id'=>'orders-checkbox'])!!}
							@else
							{!!Form::checkbox('permissions[]','orders',false,['id'=>'orders-checkbox'])!!}
							@endif
							{!!Form::label('orders-checkbox','Orders')!!}
						</div>
						<div class="col-xs-4">
							@if(isset($user) && in_array('attendence',$user->permissions))
							{!!Form::checkbox('permissions[]','attendence',true,['id'=>'attendence-checkbox'])!!}
							@else
							{!!Form::checkbox('permissions[]','attendence',false,['id'=>'attendence-checkbox'])!!}
							@endif
							{!!Form::label('attendence-checkbox','Attendance')!!}
						</div>
						<div class="col-xs-4">
							@if(isset($user) && in_array('expenses',$user->permissions))
							{!!Form::checkbox('permissions[]','expenses',true,['id'=>'expenses-checkbox'])!!}
							@else
							{!!Form::checkbox('permissions[]','expenses',false,['id'=>'expenses-checkbox'])!!}
							@endif
							{!!Form::label('expenses-checkbox','Expenses')!!}
						</div>
						<div class="col-xs-4">
							@if(isset($user) && in_array('areas',$user->permissions))
							{!!Form::checkbox('permissions[]','areas',true,['id'=>'areas-checkbox'])!!}
							@else
							{!!Form::checkbox('permissions[]','areas',false,['id'=>'areas-checkbox'])!!}
							@endif
							{!!Form::label('areas-checkbox','User\'s Pin')!!}
						</div>
					</div>


				</div>
			</li>
			<li class="row" id="type">
			<div class="col-xs-6">

			{!!Form::hidden('type', '1', array('id' => 'type'))!!}


			</div>
			</li>
			<li class="row" id="expance_limit">
				<div class="col-xs-6">
					{!!Form::label('expance_limit','Expense Limit')!!}
					{!!Form::text('expance_limit',old('expance_limit'),['placeholder'=>'Expense Limit'])!!}
					@if(count($errors)>0)
					<span class="ss_error">{!!$errors->first('expance_limit')!!}</span>
					@endif
				</div>
			</li>
			<li class="row">
				<div class="col-xs-6">
					{!!Form::label('expance_limit','Employee Id')!!}
					{!!Form::text('employ_id',old('employ_id'),['placeholder'=>'Employee Id'])!!}
					@if(count($errors)>0)
					<span class="ss_error">{!!$errors->first('employ_id')!!}</span>
					@endif
				</div>
			</li>
			@if(!isset($user))
			<li class="row">
				<div class="col-xs-6">
					{!!Form::label('password','Password')!!}
					{!!Form::password('password', ['placeholder'=>'password'])!!}
					@if(count($errors)>0)
					<span class="ss_error">{{$errors->first('password')}}</span>
					@endif
				</div>
			</li>
			<li class="row">
				<div class="col-xs-6">
					{!!Form::label('password_confirmation','Confirm Password')!!}
					{!!Form::password('password_confirmation', ['placeholder'=>'Confirm Password'])!!}
				</div>
			</li>
			@else
			<h4>Change Password</h4>
			<li class="row">
				<div class="col-xs-6">
					{!!Form::label('password','Password')!!}
					{!!Form::password('password', ['placeholder'=>'password'])!!}
					@if(count($errors)>0)
					<span class="ss_error">{{$errors->first('password')}}</span>
					@endif
				</div>
			</li>
			<li class="row">
				<div class="col-xs-6">
					{!!Form::label('password_confirmation','Confirm Password')!!}
					{!!Form::password('password_confirmation', ['placeholder'=>'Confirm Password'])!!}
				</div>
			</li>
			@endif
			<li class="row">
				<div class="col-xs-6">
					{!!Form::submit('Save Data',['class'=>'button'])!!}
				</div>
			</li>
		</ul>
		{!!Form::close()!!}
	</div>
	<!-- PAGE CONTENT : ENDS -->
</div>
@stop

@section('footer')
<script type="text/javascript">
	$('#role').select2();
        // $('#area_id').select2();
        $("#area_id").select2({
        	ajax: {
        		url: "{!!URL::to('admin/ajax/areas')!!}",
        		dataType: 'json',
        		delay: 250,
        		data: function (params) {
        			return {
                term: params.term, // search term
                page: params.page
            };
        },
        processResults: function (data) {
        	return {
        		results: $.map(data.items, function (item) {
        			return {
        				text: item.text,
        				id: item.id
        			}
        		})
        	};
        },
        cache: true
    },
    minimumInputLength: 3
});
        $('#salesperson_id').select2();
        $('#s_type').select2();

        if($('#role').val()=="1" || $('#role').val()==""){
        	$('#type').hide();
        	$('#areas').hide();
        	$('#expance_limit').hide();
        }else{
        	$('#type').show();
        	$('#areas').show();
        	$('#expance_limit').show();
        }
        if($('#role').val()=="2"){
        	$('#type').hide();
        	$('#salesperson').show();
        	$('#permissions').show();
        	$('#expance_limit').hide();
        }else{
        	$('#permissions').hide();
        	$('#salesperson').hide();
        }
        @if(!isset($userssalesperson))
        $.ajax({
        	dataType:'json',
        	method:'get',
        	url:'{!!URL::to('admin/ajax/users/areas')!!}',
        	data:{
        		area_id:$('#area_id').val()
        	},
        	success:function(data){
        		$('#salesperson_id').text('');
        		for (var i = 0; i < data['salesperson'].length; i++) {
        			$('#salesperson_id').append($('<option>',
        			{
        				value: data['salesperson'][i]['id'],
        				text : data['salesperson'][i]['name']
        			}));
        		}
        		$('#salesperson_id').trigger('select2:update');
        	}
        });
        @endif

        $(document).on('change','#area_id',function(){
        	$.ajax({
        		dataType:'json',
        		method:'get',
        		url:'{!!URL::to('admin/ajax/users/areas')!!}',
        		data:{
        			area_id:$('#area_id').val()
        		},
        		success:function(data){
        			$('#salesperson_id').text('');
        			for (var i = 0; i < data['salesperson'].length; i++) {
        				$('#salesperson_id').append($('<option>',
        				{
        					value: data['salesperson'][i]['id'],
        					text : data['salesperson'][i]['name']
        				}));
        			}
        			$('#salesperson_id').trigger('select2:update');
        		}
        	});
        });

        $('#role').change(function(){

        	if($('#role').val()=="1" || $('#role').val()==""){
        		$('#type').hide();
        		$('#areas').hide();
        		$('#expance_limit').hide();
        	}else{
        		$('#type').show();
        		$('#areas').show();
        		$('#expance_limit').show();
        	}
        	if($('#role').val()=="2"){
        		$('#salesperson').show();
        		$('#type').hide();
        		$('#expance_limit').hide();
        		$('#permissions').show();
        	}else{
        		$('#permissions').hide();
        		$('#salesperson').hide();
        	}

        });
    </script>
    @stop