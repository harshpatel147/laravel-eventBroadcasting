<h1>how to create real time event broadcasting system in Laravel with Redis, Socket.io. without using third party server like pusher</h1>
<p>This is Example Source about real time event broadcasting system in Laravel with Redis, Socket.io. without using third party server like pusher</p>

<h3>-: Requirements :-</h3>
<ol>
    <li>laravel mix</li>
    <li>Redis server</li>
    <li>predis package</li>
    <li>socket.io-client</li>
    <li>laravel-echo-server</li>
    <li>laravel-echo</li>
</ol>
<hr>

<h3 id="test-example-source">Steps for test my example code</h3>
<ol>
<li> first of all, rename **.env.copy file with .env** </li>
<li> run <code>composer install</code> </li>
<li> run <code>npm install</code> </li>
<li> install Redis Server (see below, about how to install) </li>
<li> install laravel-echo-server (see below, about how to install, Initialize(Configuration) </li>
<li> then start laravel development server `php artisan serve` </li>
<li> start Redis Server </li>
<li> then run `laravel-echo-server start` for start laravel echo server(Linux), for **windows** run `npx laravel-echo-server start` </li>

then run following urls in browser 
1. http://localhost:8000/
2. http://localhost:8000/test

<hr>

<p>Now, let's see step by step</p>

<h4>Step 1: </h4> install predis using following command <code>composer require predis/predis</code>
<h4>Step 2: </h4> create even for BroadCasting. in event file you need to set channel & message which you wants to send. run <code>php artisan make:event SendMessage</code>
& then write channel & message in **app/Events/SendMessage.php** as like <a href="https://github.com/harshpatel147/laravel-eventBroadcasting/blob/main/app/Events/SendMessage.php">this app/Events/SendMessage.php</a> file

<h4>Step 3: </h4> Update Configuration in **.env** file

<code>
    BROADCAST_DRIVER=redis
    
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379
    
    LARAVEL_ECHO_PORT=6001
</code>

<h4>Step 4: </h4> Update Configuration in **config/database.php** file

<code>
    ...
    
    'redis' => [
        // 'client' => env('REDIS_CLIENT', 'phpredis'),
        'client' => env('REDIS_CLIENT', 'predis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            // 'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
            'prefix' => env('REDIS_PREFIX', ''),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],
    ]
  ...
</code>

& then run `php artisan migrate` for db table create

<h4>Step 5: </h4> Install laravel-echo-server using following command <code>npm install -g laravel-echo-server</code>
 after installing the laravel-echo-server run <code>laravel-echo-server init</code> for Init Laravel Echo Server (command works only in Linux) & You have to setup your configuration.
 
 **Note:- If you are using the Windows OS then use <code>npx laravel-echo-server init</code>**

above Init laravel-echo-server command will create new file laravel-echo-server.json file as like bellow:

<code>
    {
	"authHost": "http://localhost:8000",
	"authEndpoint": "/broadcasting/auth",
	"clients": [],
	"database": "redis",
	"databaseConfig": {
		"redis": {
			"port": "6379",
	        "host": "127.0.0.1"
		},
		"sqlite": {
			"databasePath": "/database/laravel-echo-server.sqlite"
		}
	},
	"devMode": true,
	"host": null,
	"port": "6001",
	"protocol": "http",
	"socketio": {},
	"secureOptions": 67108864,
	"sslCertPath": "",
	"sslKeyPath": "",
	"sslCertChainPath": "",
	"sslPassphrase": "",
	"subscribers": {
		"http": true,
		"redis": true
	},
	"apiOriginAllow": {
		"allowCors": false,
		"allowOrigin": "",
		"allowMethods": "",
		"allowHeaders": ""
	}
}
</code>

<h4>Step 6: </h4> now install npm , run <code>npm install</code>
<h4>Step 7: </h4> install laravel-echo & socket.io-client using below command

<code>npm install laravel-echo</code> & <code> npm install socket.io-client@2.4.0 </code>

<h4>Step 8: </h4> create <a href="https://github.com/harshpatel147/laravel-eventBroadcasting/blob/main/resources/js/laravel-echo-setup.js">resources/js/laravel-echo-setup.js file </a>

& then add on mix file 

<h5>webpack.mix.js</h5>

<code>mix.js('resources/js/laravel-echo-setup.js', 'public/js');</code>

& then afer compile it using <code>npm run dev</code> command

then create View File as like this <a href="https://github.com/harshpatel147/laravel-eventBroadcasting/blob/main/resources/views/notification-test.blade.php">resources/views/notification-test.blade.php</a> my view file

<p>create route in routes/web.php file</p>

<code>Route::get('/', function () {
    return view('notification-test');
    // return view('welcome');
});

Route::get('/test', function () {
    event(new \App\Events\SendMessage());
    echo 'Event Run Successfully.';
});

</code>

<h4> Step 9: </h4> install redis server using <code>sudo apt install redis-server</code> (for Linux).
    
<p><strong>NOTE: if you are Windows OS user, then visit https://github.com/microsoftarchive/redis/releases then download .zip & extract that zip file to specific location & then you need to run 1. redis-server.exe & 2. redis-cli.exe OR set that extracted file location path in windows environment variables globally : </strong></p>
        
<p>for my case I put extracted folder in C:\redis\Redis-x64-3.0.504 dir ... & I set that path C:\redis\Redis-x64-3.0.504 in environment variables in windows globally then I need to run only `redis-server` for start redis-server command (we can run that command from any location) & run only `redis-cli` for start redis-cli </p>
    
<p>for more details about redis in windows see <a href="https://stackoverflow.com/questions/6476945/how-do-i-run-redis-on-windows">https://stackoverflow.com/questions/6476945/how-do-i-run-redis-on-windows</a></p>
    

<p>Now, we need to start laravel development server, laravel-echo-server, & redis server for Run Project <a href="#test-example-source">see above steps</p> 
    
<h4>If you face any problem, <a href="https://github.com/harshpatel147/laravel-eventBroadcasting/blob/main/IMP/imp-notes.txt">This Text Note of this Repository</a></h4>
    
I hope this helps to someone...
