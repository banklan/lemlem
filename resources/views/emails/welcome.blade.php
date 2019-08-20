<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito|Lato:100,300,400,700|Open+Sans:400,600|Raleway:300,400|Work+Sans:200|Dancing+Script|Fondamento|Lobster|Pacifico|Poiret+One|Righteous&display=swap|Material+Icons" rel="stylesheet">

</head>
<body>
    <h5>Dear {{ $user->name }}</h5>
    <h5>Welcome to lemlem, thank you for signing up.</h5><br/>
    <p>We are excited for the opportunity you gave us to be part of your daily life and we would not dissappoint you.</p>
    <p>Our desires are to bring all those favourite dishes, grills, drinks, cuisines, restaurants and outlets even closer to you. Wether in the comfort of your homes, in your offices or even for your outdoor events, just place your orders and have them delivered at the snap of your fingers. </p>
    <p>We sincerely hope you enjoy our services. </p><br/>
    <p><strong>- Steve</strong></p>
    <p><a href="">www.lemlem.com</a></p>
    <p>follow us @lemlem | facebook.com/lemlem</p>
</body>
</html>