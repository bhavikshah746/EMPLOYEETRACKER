@extends('admin.layouts.default')

@section('title')
    Designs
@stop

@section('content')
    <div class="content page_tables">

        <!-- PAGE HEADER : STARTS -->
        <div class="page_header clearfix">
            
            <h2 class="p_title">Add Designs Excel</h2>

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
            
            {!!Form::open(['route'=>'admin.designs.excelStore','enctype'=>"multipart/form-data"])!!} 
            
            <ul class="ss_form">
                <li class="row">
                    <div class="col-xs-6">
                        {!!Form::label('file','Add Excel File')!!}
                        {!!Form::file('file')!!}
                        @if(count($errors)>0)
                            <span class="ss_error">{{$errors->first('file')}}</span>
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