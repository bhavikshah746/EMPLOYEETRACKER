<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<title> 
			@section('title') 
			@show 
		</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @if(!isset($cities))
            <meta name="_token" content="{!! csrf_token() !!}"/>
        @endif
        @include('admin.includes.head')
	</head>

	<body>
        <div class="wrap">
            @include('admin.includes.header')
            @include('admin.includes.sidebar')
			@yield('content')
            @include('admin.includes.common_elements')
            @include('admin.popup.createtask')
            @include('admin.popup.mapshow')
            @include('admin.popup.responce')
            @include('admin.popup.orderShow')
            @include('admin.popup.login_user_list')
            @include('admin.includes.footer_script')
            <script type="text/javascript">
                $.ajaxSetup({
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                });
            </script>
			@yield('footer')
            @include('admin.partials.notifications')
        </div>
	</body>
</html>
