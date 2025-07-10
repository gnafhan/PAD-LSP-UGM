<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    
    <!-- Custom Quill.js Font Styles -->
    <style>
        /* Import Google Fonts for more options */
        @import url('https://fonts.googleapis.com/css2?family=Arial:wght@400;700&family=Georgia:wght@400;700&family=Times+New+Roman:wght@400;700&family=Helvetica:wght@400;700&family=Verdana:wght@400;700&family=Comic+Sans+MS:wght@400;700&family=Impact:wght@400;700&family=Lucida+Console:wght@400;700&family=Tahoma:wght@400;700&family=Trebuchet+MS:wght@400;700');
        
        /* Quill font family options */
        .ql-font .ql-picker-options [data-value="arial"]::before {
            font-family: 'Arial', sans-serif;
            content: 'Arial';
        }
        .ql-font .ql-picker-options [data-value="georgia"]::before {
            font-family: 'Georgia', serif;
            content: 'Georgia';
        }
        .ql-font .ql-picker-options [data-value="times"]::before {
            font-family: 'Times New Roman', serif;
            content: 'Times New Roman';
        }
        .ql-font .ql-picker-options [data-value="helvetica"]::before {
            font-family: 'Helvetica', sans-serif;
            content: 'Helvetica';
        }
        .ql-font .ql-picker-options [data-value="verdana"]::before {
            font-family: 'Verdana', sans-serif;
            content: 'Verdana';
        }
        .ql-font .ql-picker-options [data-value="comic"]::before {
            font-family: 'Comic Sans MS', cursive;
            content: 'Comic Sans MS';
        }
        .ql-font .ql-picker-options [data-value="impact"]::before {
            font-family: 'Impact', fantasy;
            content: 'Impact';
        }
        .ql-font .ql-picker-options [data-value="monospace"]::before {
            font-family: 'Lucida Console', monospace;
            content: 'Lucida Console';
        }
        
        /* Apply fonts to editor content */
        .ql-editor .ql-font-arial { font-family: 'Arial', sans-serif; }
        .ql-editor .ql-font-georgia { font-family: 'Georgia', serif; }
        .ql-editor .ql-font-times { font-family: 'Times New Roman', serif; }
        .ql-editor .ql-font-helvetica { font-family: 'Helvetica', sans-serif; }
        .ql-editor .ql-font-verdana { font-family: 'Verdana', sans-serif; }
        .ql-editor .ql-font-comic { font-family: 'Comic Sans MS', cursive; }
        .ql-editor .ql-font-impact { font-family: 'Impact', fantasy; }
        .ql-editor .ql-font-monospace { font-family: 'Lucida Console', monospace; }
        
        /* Size variations */
        .ql-editor .ql-size-small { font-size: 0.75em; }
        .ql-editor .ql-size-large { font-size: 1.5em; }
        .ql-editor .ql-size-huge { font-size: 2.5em; }
    </style>
</head>
<body>
    @include('home.home-asesor.partials.navbar')
    @include('home.home-asesor.partials.sidebar')

    <main>
        @yield('content')
    </main>

    @include('home.home-asesor.partials.footer')
</body>
</html>
