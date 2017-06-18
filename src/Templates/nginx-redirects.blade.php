@foreach($redirects as $redirect)
    rewrite ^{{$redirect->from}}$ {{$website->url}}{{$redirect->to}} {{$redirect->nginx_type}}
@endforeach
