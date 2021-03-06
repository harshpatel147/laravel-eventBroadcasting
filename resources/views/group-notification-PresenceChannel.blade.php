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
        var i = 0;
        
        var PresenceChannelCount = 0;
        var PrivateChannelCount = 0;

        if(authsession !== ''){
            companyId = "{{ (Auth::check()) ? auth()->user()->company_id : '' }}";
            var companySubscribePresenceChannel = window.Echo.join('companySubscribe.'+companyId) // Presence Channel
            .here( console.log("here event") )
            .joining( console.log("joining event") )
            .leaving( console.log("leaving event") )
            
            companySubscribePresenceChannel.listen('.App\\Events\\CompanySubscriberRoom', (data) => {
                console.log(data);
                i++;
                $("#notification").append('<div class="alert alert-success">'+i+'.'+data.title+'</div>');
                PresenceChannelCount++;
                if(PresenceChannelCount == 3){
                    companySubscribePresenceChannel.stopListening('.App\\Events\\CompanySubscriberRoom'); // for stop listening to a given event without leaving the channel
                }
            });
            
            var companySubscribePrivateChannel = window.Echo.private('companySubscribe.'+companyId);
            
            companySubscribePrivateChannel.listen('.App\\Events\\NotifyCompanySubscriber', (data) => {
                console.log(data);
                i++;
                $("#notification").append('<div class="alert alert-success">'+i+'.'+data.title+'</div>');
                PrivateChannelCount++;
                if(PrivateChannelCount == 5){
                    debugger;
                    window.Echo.leave('companySubscribe.'+companyId); // to leave a channel and also its associated private and presence channels
                }
            })
            .listen('.App\\Events\\OrderStatus', (data) => {
                console.log(data);
                i++;
                $("#notification").append('<div class="alert alert-success">'+i+'.'+data.title+'</div>');
                PrivateChannelCount++;
                if(PrivateChannelCount == 5){
                    window.Echo.leave('companySubscribe.'+companyId); // to leave a channel and also its associated private and presence channels
                }
            });
        }
    </script>
</html>