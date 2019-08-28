@if(Session::has('message') && Session::has('class'))
    <script type="text/javascript">
        notification.create({
            text:"{!! Session::get('message') !!}",
            type:'{!! Session::get('class') !!}'
        });
    </script>
@endif