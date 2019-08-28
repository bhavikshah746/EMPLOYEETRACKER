@extends('admin.layouts.login')

@section('title')
    Login
@sto
@section('content')
    <div class="content page_login">
        <ul class="tbl login_wrap">
            <li class="tblcl">
                <ul class="ul_reset lw_box">
                    <li class="lw_image clearfix">
                        <img src="{{URL::to('/')}}/img/admin/logo.png" style="width: 70px !important;">
                    </li>
                    {!!Form::open(['route'=>'login.store'])!!}
                    <li class="">
                        {!!Form::text('login', old('login'), ['class'=>'lw_username','placeholder'=>'Email'])!!}
                        {!!Form::password('password', ['class'=>'lw_password','placeholder'=>'Password'])!!}
                        @if(count($errors)>0)
                            <span class="ss_error">{{$errors->first('login')}}</span>
                            <span class="ss_error">{{$errors->first('password')}}</span>
                        @endif
                    </li>
                    <li class="lw_more clearfix">
                        <div class="lw_remember left">
                            <input id="remember" type="checkbox" name="remember_me" value="1" class="ss_checkbox"/>
                            <label for="remember">Remember Me</label>
                        </div>
                        <div class="lw_forgot right">
                            <a href="#forgot">Forgot Password ?</a>
                        </div>
                    </li>
                    <li>
                        <button type="submit" class="button">Login</button>
                    </li>
                    {!!Form::close()!!}
                </ul>
            </li>
        </ul>
    </div>
@stop

@section('footer')
    
@stop