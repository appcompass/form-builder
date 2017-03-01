server {
    listen 80;
    server_name {{ $data->server_name }};

@if(!empty($data->server_ssl))
    return 301 https://$server_name$request_uri;
@else
    @include('websites::server.nginx_shared',['data' => $data])
@endif
}
@if(!empty($data->server_ssl->cert_path) && !empty($data->server_ssl->cert_key_path))
server {
    listen 443 ssl;
    ssl on;
    ssl_certificate     {{ $data->server_ssl->cert_path }};
    ssl_certificate_key {{ $data->server_ssl->cert_key_path }};

    @if(!empty($data->server_ssl->strict))
        ssl_ciphers "EECDH+AESGCM:EDH+AESGCM:AES256+EECDH:AES256+EDH";
        ssl_protocols TLSv1.1 TLSv1.2;
        ssl_prefer_server_ciphers on;
        ssl_session_cache shared:SSL:10m;
        add_header Strict-Transport-Security "max-age=63072000; includeSubdomains; preload";
        #add_header X-Frame-Options DENY;
        add_header X-Content-Type-Options nosniff;
        ssl_session_tickets off;
        ssl_stapling on;
        ssl_stapling_verify on;

        @if(!empty($data->server_ssl->ssl_dhparam))
            ssl_dhparam {{ $data->server_ssl->ssl_dhparam }};
        @endif
    @endif

    @include('websites::server.nginx_shared',['data' => $data])
}
@endif