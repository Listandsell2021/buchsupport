<!DOCTYPE html>
<html lang='{{ config('app.locale') }}'>
<head>
    <meta charset=utf-8>
    <meta http-equiv=X-UA-Compatible content="IE=edge">
    <meta name=viewport content="width=device-width,initial-scale=1">
    <link rel="icon" type="image/webp" href="{{ asset('assets/frontend/images/favicon.webp') }}">

    @if(str_contains(url()->full(), 'login'))
        <title>Buch Kunst Register | Jetzt in Ihren Kundenbereich einloggen</title>
        <meta name="description" content="Buch Kunst Register | Loggen Sie sich jetzt in Ihren Kundenbereich ein! | Nutzen Sie unsere Plattform zum Handel mit exklusiven Buch- und Kunstsammlungen"/>
    @else
        <title>Bücher-Register</title>
        <meta name="theme-color" content="#d4af37">
        <meta name="description" content="E+K Buch-Kunstregister GmbH">
        <meta name="keywords" content="Online Buch-Kunstregister, Buchregister, Kunstregister">
        <meta name="author" content="Robin Rick - YBM-Deutschland.de">
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
            'getContactPageUrl' => route('frontend.page.contact'),
            'getTelephoneNoLink' => config('buch.company.phone_no_link'),
            'getPreviousUrl' => url()->previous(),
        ]
    ]) !!};
</script>
</body>
</html>
