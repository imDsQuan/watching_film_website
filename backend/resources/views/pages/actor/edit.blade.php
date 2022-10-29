@extends('layouts.default')

@section('content')
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
            <!-- search -->
            <div class="search">
                <label for="">
                    <input type="text" placeholder="Search Here">
                    <ion-icon name="search-outline"></ion-icon>
                </label>
            </div>
            <!-- User Image -->
            <div class="user">
                <img src="{{url('/images/avatar_default.png')}}" alt="" >
            </div>
        </div>


        <div class="container">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-start">
                    <ion-icon name="people-outline" style="font-size: 32px;"></ion-icon>
                    <div class="font-weight-bold ml-2" style="font-size: 32px;">Edit Actor</div>
                </div>
                <div class="card-body">
                    <form action="/actor/update" method="POST" enctype='multipart/form-data'>
                        {{ csrf_field() }}

                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="/actor" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>

        </div>


    </div>

    <script>
        $(document).ready(function(){
            $('#type option[value={{$actor->type}}]').attr('selected','selected');
        })
    </script>
@stop
