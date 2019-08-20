<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'lemlem') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito|Lato:100,300,400,700|Open+Sans:400,600|Raleway:300,400|Work+Sans:200|Dancing+Script|Fondamento|Lobster|Pacifico|Poiret+One|Righteous&display=swap|Material+Icons" rel="stylesheet">

</head>
<body>
    <div class="container">
        <div class="row">
            <h5>Dear {{ $user->name }}</h5><br>
            <h5>we are excited to receive your lemlem order with order no {{ $summary->order_id }}</h5>
            <h5>Your order is been processed and will be dispatched as soon as possible.</h5>
            <h5>Once we are in your neighbourhood, our valet will call to inform you.</h5>
            <h5>You can track your order when you sign in into <a href="#">www.lemlem.com.ng</a>, on your dashboard, click on the order.</h5>
            <h5>Thank you for making us a part of your life.</h5><br>
            <h5>Steve</h5>
            <h5><a href="#">www.lemlem.com.ng</a></h5>
        </div>
    </div>
    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
</body>
</html>





