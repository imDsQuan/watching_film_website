<!DOCTYPE html>
<html lang="en">
    <head>
        @include('includes.head')
    </head>

    <body>
        <div class="container-ex">

            @include('includes.sidebar')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            @yield('content')
        </div>

        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script src="{{ url('js/app.js') }}"></script>
        <script src="{{url('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    </body>
</html>
