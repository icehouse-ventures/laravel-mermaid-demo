<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Basic Mermaid examples</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
        body { background: #f5f5f5; }
        .container { width: 90%; margin: 4em auto 0; max-width: 50em; }
        .example { background: #fff; border: 1px solid #eee; box-shadow: 1px 1px 6px rgba(0, 0, 0, 0.1); padding: 3em; }
        .example h2 { font-size: 24px; margin: 0 0 1em; }
        </style>
    </head>
    <body class="">
        
        <div class="container">
            <div class="example">
                <h2>Generated from User model</h2>
                <x-mermaid::component :data="$mermaid" />
            </div>
        </div>

    </body>
</html>
