@extends('layouts.default')

@section('content')
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
            <!-- search -->
            <div class="search invisible">
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

            <div class="card card-stats card-initial" style="margin: 15px 0;">
                <div class="card-content views-body  pull-right">
                    <a href="#" class="btn btn-tab-movie rounded-pill" style="background: #555 !important; color: #fff !important; border:none !important;"><div class="d-flex justify-content-center align-items-center"><ion-icon name="eye-outline" class="mr-2"></ion-icon> {{$tvShow->views}} Views</div></a>
                    <a href="#" class="btn btn-tab-movie rounded-pill" style="background: #555 !important; color: #fff !important; border:none !important;"><div class="d-flex justify-content-center align-items-center"><ion-icon name="share-social-outline" class="mr-2"></ion-icon> 0 Shares</div></a>
                    <a href="#" class="btn btn-tab-movie rounded-pill" style="background: #555 !important; color: #fff !important; border:none !important;"><div class="d-flex justify-content-center align-items-center"><ion-icon name="share-social-outline" class="mr-2"></ion-icon> {{$tvShow->rating}} Downloads</div></a>
                </div>
                <div class="d-flex justify-content-start align-items-center">
                    <div class="card-header " data-background-color="green">
                        <ion-icon name="videocam-outline" style="font-size: 46px;"></ion-icon>
                    </div>
                    <div class="card-content trailer-body">
                        <h4 class="title">Edit TV Show {{$tvShow->title}} </h4>
                    </div>
                </div>
                <div class="tab-moivie">
                    <a href="/tvShow/{{$tvShow->slug}}/edit" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="add-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Edit</a>
                    <a href="/tvShow/{{$tvShow->slug}}/season" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="library-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Season</a>
                    <a href="/tvShow/{{$tvShow->slug}}/cast" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="people-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Cast</a>
                    <a href="/tvShow/{{$tvShow->slug}}/trailer" class="btn btn-tab-movie-active d-flex justify-content-center align-items-center"><ion-icon name="play-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Trailer</a>

                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-start">
                    <ion-icon name="videocam-outline" style="font-size: 32px;"></ion-icon>
                    <div class="font-weight-bold ml-2" style="font-size: 32px;">Add Trailer</div>
                </div>
                <div class="card-body">
                    <form action="/tvShow/{{$tvShow->id}}/trailer" method="POST" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="trailer_url">Add Trailer Youtube Url</label>
                                    <input type="text" class="form-control" id="trailer_url" name="trailer_url" value="{{$tvShow->trailer}}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>


    </div>

    <script>
        {{--$(document).ready(function(){--}}

        {{--    let listGenre = Object.values(<?php echo $tvShow->genres ?>);--}}

        {{--    let listGenreSelect2 = $('#listGenre');--}}

        {{--    listGenreSelect2.select2();--}}

        {{--    listGenreSelect2.val(listGenre).trigger('change');--}}

        {{--    $('input[name="listGenre"]').val(listGenreSelect2.val());--}}

        {{--    listGenreSelect2.on('select2:select', function (e) {--}}
        {{--        $('input[name="listGenre"]').val(listGenreSelect2.val());--}}
        {{--    });--}}


        {{--    if (1 == <?php echo $tvShow->enable ?>) {--}}
        {{--        $('input[name="enable"]').prop( "checked", true );--}}
        {{--    }--}}


        {{--});--}}
    </script>
@stop
