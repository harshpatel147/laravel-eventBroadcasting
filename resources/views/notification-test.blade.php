<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel Broadcast Redis Socket io Tutorial</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1>Laravel Broadcast Redis Socket io Tutorial</h1>
            @if(Auth::check())
            <a class="btn btn-dark login-register-btn mt-1 mb-3" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Log Out
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf   <!--use @csrf OR csrf_field() -->
                </form>
            </a>
            @else
            <a href="{{ route('login') }}" class="btn btn-primary mt-1 mb-3">Login</a>
            @endif
            <div id="notification"></div>
        </div>
    </body>
  
    <script>
            window.laravel_echo_port='{{env("LARAVEL_ECHO_PORT")}}';
            var authsession = '{{ Auth::check() }}'; 
    </script>
    <script src="//{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script>
    <script src="{{ url('/js/laravel-echo-setup.js') }}" type="text/javascript"></script>
      
    <script type="text/javascript">
        window.Echo.connector.socket.on('connect', () => {
            console.log('Connected to WebSocket');
        });

        window.Echo.connector.socket.on('reconnecting', () => {
            console.log('ReConnecting to WebSocket');
        });

        window.Echo.connector.socket.on('disconnect', () => {
            console.log('Disconnected from WebSocket');
        });

        var i = 0;
        window.Echo.channel('user-channel') // public channel
         .listen('.UserEvent', (data) => {
            console.log(data);
            i++;
            $("#notification").append('<div class="alert alert-success">'+i+'.'+data.title+'</div>');
            window.Echo.leaveChannel('user-channel'); // to leave a channel 
        });
        if(authsession !== ''){
            var privateChannel = window.Echo.private('message.1'); // private channel
            privateChannel.listen('.App\\Events\\NotifyUser', (data) => {
                console.log(data);
                i++;
                $("#notification").append('<div class="alert alert-success">'+i+'.'+data.title+'</div>');
            });

            companyId = "{{ (Auth::check()) ? auth()->user()->company_id : '' }}";
            var companySubscribeChannel = window.Echo.private('companySubscribe.'+companyId);
            companySubscribeChannel.listen('.App\\Events\\NotifyCompanySubscriber', (data) => {
                console.log(data);
                i++;
                $("#notification").append('<div class="alert alert-success">'+i+'.'+data.title+'</div>');
                window.Echo.leave('companySubscribe.'+companyId); // to leave a channel and also its associated private and presence channels
            });
        }
    </script>
</html>