server {
    # @TODO: listen_ip (none if left empty for any on server)
    # @TODO: conditional based on scheme: listen_port
    listen       172.24.16.210:80;
    # @TODO: append: server_names
    server_name  {{$website->host}};

    root {{$storage->getConfig('root')}}/dist/;

    location ~ /.well-known {
            allow all;
    }

    return 301 {{$website->scheme}}://{{$website->host}}$request_uri;
}

server {
    # @TODO: listen_ip (none if left empty for any on server)
    # @TODO: conditional based on scheme: listen_port
    listen       172.24.16.210:443 ssl http2;
    # @TODO: append server_names
    server_name  {{$website->host}};

    if ($host != {{$website->host}}) {
        return 301 {{$website->scheme}}://{{$website->host}}$request_uri;
    }

    ssl on;
    ssl_certificate /etc/letsencrypt/live/{{$website->host}}/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/{{$website->host}}/privkey.pem;
    ssl_trusted_certificate /etc/letsencrypt/live/{{$website->host}}/fullchain.pem;
    ssl_dhparam {{$storage->getConfig('root')}}/ssl/dhparam.pem;
    ssl_ciphers "ECDHE-RSA-AES256-SHA384:DHE-RSA-AES256-SHA384:ECDHE-RSA-AES256-SHA256:DHE-RSA-AES256-SHA256:ECDHE-RSA-AES128-SHA256:DHE-RSA-AES128-SHA256:HIGH:!aNULL:!eNULL:!EXPORT:!DES:!RC4:!MD5:!PSK:!SRP:!CAMELLIA";
    ssl_protocols TLSv1.1 TLSv1.2;
    ssl_prefer_server_ciphers on;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 5m;
    ssl_session_tickets off;
    ssl_stapling on;
    ssl_stapling_verify on;

    resolver 8.8.8.8 8.8.4.4;

    add_header Strict-Transport-Security "max-age=63072000; includeSubdomains" always;
    add_header X-Frame-Options DENY;
    add_header X-XSS-Protection "1; mode=block";
    # add_header X-Content-Type-Options nosniff;
    add_header Access-Control-Allow-Origin "*";
    add_header Access-Control-Allow-Headers "Access-Control-Allow-Origin, Access-Control-Allow-Headers, Origin, Accept, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers, X-CSRF-TOKEN, X-Requested-With, corssDomain, Authorization, Lang";
    add_header Access-Control-Allow-Methods "GET, POST, HEAD, OPTIONS, PUT";
    add_header X-Powered-By 'Plus 3 Interactive LLC';

    if ( $request_method = OPTIONS ) {
        return 200;
    }

    # client_max_body_size 100M;
    client_max_body_size {{$website->getConfig('deployment.client_max_body_size')}};
    root {{$storage->getConfig('root')}}/dist/;

    access_log {{$storage->getConfig('root')}}/logs/www-access.log;
    error_log {{$storage->getConfig('root')}}/logs/www-error.log;

    location /api/ {
        proxy_set_header Server-Name $http_host;
        proxy_set_header Site-Host $host;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;

        proxy_read_timeout 3600;
        proxy_send_timeout 3600;

        proxy_pass {{$website->getConfig('deployment.api_url')}}/;
        # proxy_pass https://api.p3in.com/;
    }

    location /sitemap. {
        proxy_set_header Server-Name $http_host;
        proxy_set_header Site-Host $host;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;

        proxy_read_timeout 3600;
        proxy_send_timeout 3600;

        proxy_pass {{$website->getConfig('deployment.api_url')}}/render/sitemap.;
        # proxy_pass https://api.p3in.com/render/sitemap.;
    }

    location /robots.txt {
        proxy_set_header Server-Name $http_host;
        proxy_set_header Site-Host $host;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;

        proxy_read_timeout 3600;
        proxy_send_timeout 3600;

        proxy_pass {{$website->getConfig('deployment.api_url')}}/render/robots.txt;
        # proxy_pass https://api.p3in.com/render/robots.txt;
    }

    location ~ /.well-known {
            allow all;
    }

    location / {
        try_files $uri @ssr;
    }

    location @ssr {
        proxy_set_header Server-Name $http_host;
        proxy_set_header Site-Host $http_host;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;

        proxy_read_timeout 3600;
        proxy_send_timeout 3600;

        proxy_pass {{$website->getConfig('deployment.ssr_url')}};
        # proxy_pass http://127.0.0.1:3000;
    }

    include {{$storage->getConfig('root')}}/nginx-redirects.conf;
}