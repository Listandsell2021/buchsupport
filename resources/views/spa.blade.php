<!DOCTYPE html>
<html lang='{{ config('app.locale') }}'>
<head>
    <meta charset=utf-8>
    <meta http-equiv=X-UA-Compatible content="IE=edge">
    <meta name=viewport content="width=device-width,initial-scale=1">
    <link rel="icon" type="image/webp" href="{{ asset('assets/frontend/images/favicon.png') }}">

    @if(str_contains(url()->full(), 'login'))
        <title>{{ getAppName() }} | Login</title>
    @else
        <title>{{ getAppName() }}</title>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
</head>
<body>

<app id="app">
    <root-component></root-component>
</app>

@vite(['resources/jsBundler/spa/app.js'])
<script>
    window.Laravel = {!! json_encode([
        'config' => [
            'homePageUrl' => url('/'),
            'getPreviousUrl' => url()->previous(),
        ]
    ]) !!};
</script>
</body>
</html>
