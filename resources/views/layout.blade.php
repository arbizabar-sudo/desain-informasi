<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DCH</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-sidebar-assets />
    <style>body{background:#f6f6f6;margin:0;font-family:Inter,system-ui,-apple-system;}</style>
</head>
<body>
    <x-navbar />
    <div class="container">
        @if(session('success'))
            <div style="position:fixed;right:20px;top:20px;background:#4caf50;color:white;padding:10px 14px;border-radius:8px;z-index:9999">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="position:fixed;right:20px;top:20px;background:#e53935;color:white;padding:10px 14px;border-radius:8px;z-index:9999">{{ session('error') }}</div>
        @endif
        @yield('content')
        <x-footer />
    </div>

    <x-sidebar-assets />
</body>
</html>
