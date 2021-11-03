<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
    <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
    <title>Survey Page</title>
</head>
<body>    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Safety Management Web</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/user/dashboard">Dashboard</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>                         --}}
                </ul>          
            </div>
        </div>
    </nav>    
    @yield('isiuser')

<script>
    window.onbeforeunload = function() {
        return "Data will be lost if you leave the page, are you sure?";
    };
</script>
</body>
</html>