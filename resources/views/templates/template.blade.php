<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    @livewireStyles
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <title>@yield('title') | BEEThrift</title>
    <link rel="icon" type="image/x-icon" sizes="144x144" href="{{ url(asset('/assets/logo/logo.png')) }}">
</head>

<body>
    <div class="min-h-screen min-w-screen flex flex-col items-center justify-between ">
        <div class="h-full w-full min-h-screen flex flex-col items-center">
            <x-navbar/>
            @yield('content')
        </div>
        @yield('footer', \Illuminate\Support\Facades\View::make('components.footer'))
    </div>
    @livewire('livewire-ui-modal')
    @livewireScripts

</body>

</html>
