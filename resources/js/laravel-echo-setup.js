import Echo from 'laravel-echo';
window.io = require("socket.io-client");

if (typeof window.io !== "undefined") {
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname + ":" + window.laravel_echo_port,
        /* csrfToken: $('meta[name="csrf-token"]').attr("content"),
        auth: {headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content"),
        }}, */
    });
    console.log('Connected to socket.io');
}else{
    console.log('Not connected to socket.io');
}