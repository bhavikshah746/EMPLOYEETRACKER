@extends('admin.layouts.default')

@section('title')
    Create User's Pin
@stop

@section('content')
    <div class="content page_tables">

        <!-- PAGE HEADER : STARTS -->
        <div class="page_header clearfix">
            @if(isset($area))
                <h2 class="p_title">Edit {{ucwords($area->name)}} Info</h2>
            @else
                <h2 class="p_title">Create User Pin</h2>
            @endif

            <ul class="p_actions ul_reset clearfix">
                <li>
                    <a class="button" type="button" href="{{URL::route('admin.areas.index')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M21 11H6.83l3.58-3.59L9 6l-6 6 6 6 1.41-1.41L6.83 13H21z"/>
                        </svg>
                        Back To User Pin
                    </a>
                </li>
            </ul>

        </div>
        <!-- PAGE HEADER : ENDS -->

        <!-- PAGE CONTENT : STARTS -->
        <div class="page_content">
            @if(isset($area))
                {!!Form::model($area,['route'=>['admin.areas.update',$area->id],'method'=>'PUT'])!!}
            @else
                {!!Form::open(['route'=>'admin.areas.store'])!!}
            @endif
            <ul class="ss_form">
             <li class="row">
                    <div class="col-xs-6">
                        {!!Form::label('name','Name')!!}
                        {!!Form::text('name', old('name'), ['placeholder'=>'Name'])!!}
                        @if(count($errors)>0)
                            <span class="ss_error">{{$errors->first('name')}}</span>
                        @endif
                    </div>
                </li>
               <!--  <li class="row">
                    <div class="col-xs-6">
                        {!!Form::label('pincode','Pincode')!!}
                        {!!Form::text('pincode', old('pincode'), ['placeholder'=>'Pincode','id'=>'pincode'])!!}
                        @if(count($errors)>0)
                            <span class="ss_error">{{$errors->first('pincode')}}</span>
                        @endif
                    </div>
                </li> -->
                <li class="row">
                    <div class="col-xs-6">
                        {!!Form::label('country','Country')!!}
                        {!!Form::text('country',old('country'),['placeholder'=>'Country','id'=>'country'])!!}
                        @if(count($errors)>0)
                            <span class="ss_error">{{$errors->first('country')}}</span>
                        @endif
                    </div>
                </li>
                <li class="row">
                    <div class="col-xs-6">
                        {!!Form::label('state','State')!!}
                        {!!Form::text('state',old('state'),['placeholder'=>'State','id'=>'state'])!!}
                        @if(count($errors)>0)
                            <span class="ss_error">{{$errors->first('state')}}</span>
                        @endif
                    </div>
                </li>
                <li class="row">
                    <div class="col-xs-6">
                        {!!Form::label('city','City')!!}
                        {!!Form::text('city',old('city'),['placeholder'=>'City','id'=>'city'])!!}
                        @if(count($errors)>0)
                            <span class="ss_error">{{$errors->first('city')}}</span>
                        @endif
                    </div>
                </li>
                <!-- <li class="row">
                    <div class="col-xs-6">
                        {!!Form::label('state','State')!!}
                        {!!Form::select('state_id',$states,old('state_id'),['placeholder'=>'State','id'=>'state_change'])!!}
                        @if(count($errors)>0)
                            <span class="ss_error">{{$errors->first('state_id')}}</span>
                        @endif
                    </div>
                </li>
                <li class="row">
                    <div class="col-xs-6">
                        {!!Form::label('city','City')!!}
                        {!!Form::select('city_id',$cities,old('city_id'),['placeholder'=>'City','id'=>'city'])!!}
                        @if(count($errors)>0)
                            <span class="ss_error">{{$errors->first('city_id')}}</span>
                        @endif
                    </div>
                </li> -->
                <li class="row">
                    <div class="col-xs-6">
                        {!!Form::label('pincode','Pincode')!!}
                        {!!Form::text('pincode', old('pincode'), ['placeholder'=>'Pincode','id'=>'pincode'])!!}
                        @if(count($errors)>0)
                            <span class="ss_error">{{$errors->first('pincode')}}</span>
                        @endif
                    </div>
                </li>
                <!-- <li class="row">
                    <div class="col-xs-6">
                        {!!Form::label('name','Name')!!}
                        {!!Form::text('name', old('name'), ['placeholder'=>'Name'])!!}
                        @if(count($errors)>0)
                            <span class="ss_error">{{$errors->first('name')}}</span>
                        @endif
                    </div>
                </li> -->
                <li class="row">
                    <div class="col-xs-6">
                        {!!Form::submit('Save',['class'=>'button'])!!}
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
        $('#pincode').blur(function(){
            var zip = $(this).val();
            var city = '';
            var state = '';
            var country = '';
            
            //make a request to the google geocode api
            $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address='+zip).success(function(response){
                var address_components = response.results[0].address_components;
                $.each(address_components, function(index, component){
                    var types = component.types;
                    $.each(types, function(index, type){
                        if(type=='country'){
                            country=component.long_name;
                        }
                        if(type == 'locality') {
                          city = component.long_name;
                        }
                        if(type == 'administrative_area_level_2'){
                            city=component.long_name;
                        }
                        if(type == 'administrative_area_level_1') {
                          state = component.long_name;
                        }
                    });
                });
                //pre-fill the city and state
                $('#city').val(city);
                $('#state').val(state);
                $('#country').val(country);
            });
        });









        // $('#state_change').select2();
        // $('#city').select2();
        // @if(isset($area))
        //     $("#city option").remove(); 
        //     $.ajax({
        //         dataType:'json',
        //         method:'get',
        //         url:'{!!URL::to('admin/ajax/areas/cities')!!}',
        //         data:{
        //             state_id:$('#state_change').val()
        //         }, 
        //         success:function(data){
                    // for (var i = 0; i < data['cities'].length; i++) {
                    //     $('#city').append($('<option>',
                    //      {
                    //         value: data['cities'][i]['citid'],
                    //         text : data['cities'][i]['citname']
                    //     }));
                    // }
                    // $('#city').trigger('select2:update');   
        //         }
        //     });
        // @endif  
        // $('#state_change').change(function(){
        //     $("#city option").remove(); 
        //     $.ajax({
        //         dataType:'json',
        //         method:'get',
        //         url:'{!!URL::to('admin/ajax/areas/cities')!!}',
        //         data:{
        //             state_id:$(this).val()
        //         }, 
        //         success:function(data){
        //             for (var i = 0; i < data['cities'].length; i++) {
        //                 $('#city').append($('<option>',
        //                  {
        //                     value: data['cities'][i]['citid'],
        //                     text : data['cities'][i]['citname']
        //                 }));
        //             }
        //             $('#city').trigger('select2:update');   
        //         }
        //     });
        // });
    </script>
@stop