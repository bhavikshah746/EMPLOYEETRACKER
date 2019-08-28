@extends('admin.layouts.default')

@section('title')
    Designes
@stop

@section('content')
    <div class="content page_tables">

        <!-- PAGE HEADER : STARTS -->
        <div class="page_header clearfix">
            @if(isset($design))
                <h2 class="p_title">Edit {{ucwords($design->name)}} Info</h2>
            @else
                <h2 class="p_title">Create Designs</h2>
            @endif

            <ul class="p_actions ul_reset clearfix">
                <li>
                    <a class="button" type="button" href="{{URL::route('admin.designs.index')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M21 11H6.83l3.58-3.59L9 6l-6 6 6 6 1.41-1.41L6.83 13H21z"/>
                        </svg>
                        Back To Designs
                    </a>
                </li>
            </ul>

        </div>
        <!-- PAGE HEADER : ENDS -->

        <!-- PAGE CONTENT : STARTS -->
        <div class="page_content">
            @if(isset($design))
                {!!Form::model($design,['route'=>['admin.designs.update',$design->id],'method'=>'PUT'])!!}
            @else
                {!!Form::open(['route'=>'admin.designs.store'])!!}
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
@stop