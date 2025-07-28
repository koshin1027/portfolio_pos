<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>POSレジシステム(仮)</title>
        <script src="https://cdn.tailwindcss.com"></script>
            @yield('css')
            @livewireStyles
        <livewire:styles />
    </head>
    <body>
        @yield('body-content')
        @yield('js')
        @livewireScripts
    </body>
</html>
