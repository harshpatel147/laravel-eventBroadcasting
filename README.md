# Real-time Event Broadcasting System in Laravel with Redis and Socket.io

This is an example source for a real-time event broadcasting system in Laravel using Redis and Socket.io without relying on third-party servers like Pusher.

## Requirements:

- Laravel Mix
- Redis Server
- Predis Package
- Socket.io-client
- Laravel-echo-server
- Laravel-echo

## Steps to Test the Example Code:

1. Clone this repository and rename the **`.env.copy` file to `.env`**
2. Run the following commands:
    ```bash
    composer install
    npm install
    ```
3. Install **Redis Server** [see below, point number 9 about how to Install Redis Server](#step-by-step-explanation)
4. Install **laravel-echo-server** [see below, point number 5 about how to install, Initialize(Configuration)](#step-by-step-explanation)
5. Start the Laravel development server using the command: 
   ```bash
   php artisan serve
   ```
6. Start Redis Server
7. Start laravel echo server by following command:
   - for Linux: Run `laravel-echo-server start`
   - for Windows: Run `npx laravel-echo-server start`
8. Open following urls in browser:
   -  http://localhost:8000/
   -  http://localhost:8000/test


## Step by step explanation

1. Install **Predis** using the following command: 
    ```bash
    composer require predis/predis
    ```
2. Create an event for broadcasting. Run the command:
    ```bash
    php artisan make:event SendMessage
    ```
    Then, set the channel and message in **app/Events/SendMessage.php** as shown in [this example file](./app/Events/SendMessage.php).

3. Update the configuration in the **`.env`** file:
    ```.env
    BROADCAST_DRIVER=redis
    
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379
    
    LARAVEL_ECHO_PORT=6001
    ```
4. Update the configuration in **`config/database.php`** and run:
    ```bash
    php artisan migrate
    ```
   ```php
    // config/database.php
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
   ```
5. Install **laravel-echo-server** using the following command:
    ```bash
    npm install -g laravel-echo-server
    ```
    After installing, run `laravel-echo-server init` (Linux) or `npx laravel-echo-server init` (Windows) to initialize Laravel Echo Server and set up configurations. The configurations will be saved in laravel-echo-server.json.

    ```json
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
    ```
6. Install Node Modules by running: 
    ```bash
    npm install
    ```
7. Install Laravel Echo and Socket.io-client:
    ```bash
    npm install laravel-echo socket.io-client@2.4.0
    ```
8. Create the [resources/js/laravel-echo-setup.js file](./resources/js/laravel-echo-setup.js). Add the following to webpack.mix.js and compile using `npm run dev`:

    ```js
    mix.js('resources/js/laravel-echo-setup.js', 'public/js');
    ```

    - Create a view file like [resources/views/notification-test.blade.php](./resources/views/notification-test.blade.php).
    - Create a route in routes/web.php:

        ```php
        Route::get('/', function () {
            return view('notification-test');
            // return view('welcome');
        });

        Route::get('/test', function () {
            event(new \App\Events\SendMessage());
            echo 'Event Run Successfully.';
        });
        ```
9. Install **Redis Server** using:
    - For Linux: `sudo apt install redis-server`
    - For Windows: [Download from Microsoft Archive Redis Releases](https://github.com/microsoftarchive/redis/releases) and extract zip file to specific location. Follow the instructions for installation. You can either run `redis-server.exe` and `redis-cli.exe` directly or set the extracted folder location in the Windows environment variables globally.
       > for my case: I put extracted folder in **C:\redis\Redis-x64-3.0.504** directory & I set that path `C:\redis\Redis-x64-3.0.504` in the Windows environment variables globally. then I need to run only `redis-server` command for start the redis-server (we can run that command from any location) & run only `redis-cli` command for start redis-cli
    
    > Note: For more details about Redis on Windows, [refer to this Stack Overflow question](https://stackoverflow.com/q/6476945).

All Done! Now, start the Laravel development server, Laravel Echo Server, and Redis Server to run the project [See above steps](#steps-to-test-the-example-code).

If you encounter any issues, [refer to this text note in the repository](./IMP/imp-notes.txt).

I hope this helps! Happy coding!