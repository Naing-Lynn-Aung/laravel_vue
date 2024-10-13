<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <style>
            nav {
                padding: 30px;
            }
            nav a {
                font-weight: bold;
                color: #000;
                padding: 10px 20px;
                text-decoration: none;
            }
            nav a:hover {
                color: #000;
            }
            nav a.router-link-exact-active {
                color: #fff;
                border-radius: 4px;
                background: #0d6efd;
            }

        </style>
        
    </head>

       <div id="app">
        <nav class="d-flex justify-content-center align-items-center">
            <router-link to="/">Login</router-link>
            <router-link :to= "{ name: 'posts' }">Post</router-link>
            
        </nav>
            <router-view />
       </div>
       <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
