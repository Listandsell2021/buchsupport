<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ ucfirst(config('app.name')) }}</title>
    <link rel="stylesheet" href="{{ isset($check) ? asset('assets/admin/css/customer_invoice.css') : public_path('assets/admin/css/customer_invoice.css') }}">
    <style>
        body {
            font-size: 11px;
            line-height: 1.1;
        }
        .common-box {
            background-color: #ffd449;
            border: 2px solid #000;
            padding: 4px;
            margin-bottom: 15px;
        }
        .top-title {
            margin-top: 0;
            margin-bottom: 0;
        }
        .commission-table {
            width: 100%;
            border-collapse: collapse;
        }
        .logo-img {
            height: 90px;
        }
        .t-logo-row {
            width: 50%;
        }
        .logo-img {
            float: right;
        }
        .invoice-box-header table {
            width: 100%;
        }
        .commission-table > tbody > tr > td {
            border-top: 1px solid #000;
            padding: 4px;
        }
        .commission-table tr td, .commission-table tr th {
            border: 1px solid #000;
            text-align: center;
            height: 12px;
            font-weight: bold;
        }
        .commission-table .row-border-less td{
            border-width: 0;
        }
    </style>
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