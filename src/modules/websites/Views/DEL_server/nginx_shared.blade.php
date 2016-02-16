    server_name {{ $data->server_name }};
    client_max_body_size    100M;

    charset utf-8;

    sendfile off;

    add_header X-Powered-By "Plus 3 Interactive LLC";
    add_header X-Frame-Options SAMEORIGIN;
    add_header Cache-control "no-cache; no-store; max-age";
    expires -1;

    access_log off;
    error_log  {{ $data->error_log_path }} error;

    root   {{ $data->document_root }};

    location ~* \.(?:css)$ {
        # Some basic cache-control for static files to be sent to the browser
         expires max;
         add_header Pragma public;
         add_header Cache-Control "public, must-revalidate, proxy-revalidate";
    }

    location /assets {

        # Some basic cache-control for static files to be sent to the browser
        # expires max;
        # add_header Pragma public;
        # add_header Cache-Control "public, must-revalidate, proxy-revalidate";

        add_header Access-Control-Allow-Origin $server_name;
        add_header Access-Control-Allow-Headers "X-Requested-With, content-type";
        add_header Access-Control-Allow-Methods "GET, HEAD, OPTIONS";

        if ( $request_method = OPTIONS ) {
            return 200;
        }

        proxy_set_header Server-Name $http_host;
        proxy_set_header Host $server_name;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_send_timeout 36000;
        proxy_read_timeout 36000;
        proxy_pass  {{ $data->proxy_url }}/assets/;
    }

    location /  {
        add_header Access-Control-Allow-Origin $server_name;
        add_header Access-Control-Allow-Headers "X-Requested-With, content-type";
        add_header Access-Control-Allow-Methods "GET, POST, HEAD, OPTIONS";

        if ( $request_method = OPTIONS ) {
            return 200;
        }

        proxy_set_header Server-Name $http_host;
        proxy_set_header Host $server_name;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header Site-Name '{{ $data->site_name }}';
        proxy_send_timeout 36000;
        proxy_read_timeout 36000;
        proxy_pass  {{ $data->proxy_url }}/render-page/;
    }
