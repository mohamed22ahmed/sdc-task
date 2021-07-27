<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <title>Laravel & Vue CRUD Single Page Application (SPA) Tutorial - MyNotePaper</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .bg-light {
            background-color: #eae9e9 !important;
        }
    </style>
</head>

<body>
    <div id="app">
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>

</html>
