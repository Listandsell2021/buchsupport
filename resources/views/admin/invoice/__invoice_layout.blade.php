<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ ucfirst(config('app.name')) }}</title>
    <link rel="stylesheet" href="{{ isset($check) ? asset('admin/css/customer_invoice.css') : public_path('admin/css/customer_invoice.css') }}">
    @if(isset($check))
    <style>
        body {
            min-height: 2000px;
        }
    </style>
    @endif
</head>
<body>
<div class="invoice-cover m-t-15">

    @yield('content')

</div>
</body>
</html>