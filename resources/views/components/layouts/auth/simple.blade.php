<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="h-screen w-screen overflow-hidden bg-neutral-950 text-white">

        <div class="flex h-full w-full">
            {{ $slot }}
        </div>

        @fluxScripts
    </body>
</html>
