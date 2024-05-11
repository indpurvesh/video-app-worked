<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test app</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    @viteReactRefresh
    @vite('resources/react/App.tsx')
</head>
<body>
<div id="root"></div>
</body>
</html>