<!DOCTYPE html>
<html lang="en" class="h-100">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="The Baile Apartment">
    <meta name="author" content="The Baile Apartment">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The Baile Apartment">
    <meta property="og:title" content="The Baile Apartment">
    <meta property="og:description" content="The Baile Apartment">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta name="format-detection" content="telephone=no">

    <title>The Baile Apartment</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link href="{{ asset('dashboard') }}/css/style.css" rel="stylesheet">

</head>

<body class="vh-100">
    <div id="auth" class="authincation h-100"></div>

    <script src="{{ asset('dashboard') }}/vendor/global/global.min.js"></script>

    <script src="{{ asset('dashboard') }}/js/dlabnav-init.js"></script>
    @vite('resources/js/app.js')
</body>

</html>
