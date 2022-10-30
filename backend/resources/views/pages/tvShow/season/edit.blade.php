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
                    <a href="#" class="btn btn-tab-movie rounded-pill" style="background: #555 !important; color: #fff !important; border:none !important;"><div class="d-flex justify-content-center align-items-center"><ion-icon name="eye-outline" class="mr-2"></ion-icon> {{$tvShow->views}}</div></a>
                    <a href="#" class="btn btn-tab-movie rounded-pill" style="background: #555 !important; color: #fff !important; border:none !important;"><div class="d-flex justify-content-center align-items-center"><ion-icon name="share-social-outline" class="mr-2"></ion-icon> 0 Shares</div></a>
                    <a href="#" class="btn btn-tab-movie rounded-pill" style="background: #555 !important; color: #fff !important; border:none !important;"><div class="d-flex justify-content-center align-items-center"><ion-icon name="arrow-down-outline" class="mr-2"></ion-icon> 0 Downloads</div></a>
                </div>
                <div class="d-flex justify-content-start align-items-center">
                    <div class="card-header " data-background-color="green">
                        <ion-icon name="videocam-outline" style="font-size: 46px;"></ion-icon>
                    </div>
                    <div class="card-content trailer-body">
                        <h4 class="title">Edit Movie </h4>
                    </div>
                </div>
                <div class="tab-moivie">
                    <a href="#" class="btn btn-tab-movie d-flex justify-content-center align-items-center">
                        <ion-icon name="add-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon>
                        Edit</a>
                    <a href="/tvShow/{{$tvShow->slug}}/episode"
                       class="btn btn-tab-movie-active d-flex justify-content-center align-items-center">
                        <ion-icon name="library-outline" style="font-size:16px; margin-right:8px;"></ion-icon>
                        Episode</a>
                    <a href="/tvShow/{{$tvShow->slug}}/cast"
                       class="btn btn-tab-movie d-flex justify-content-center align-items-center">
                        <ion-icon name="people-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon>
                        Cast</a>
                    <a href="/tvShow/{{$tvShow->slug}}/trailer"
                       class="btn btn-tab-movie d-flex justify-content-center align-items-center">
                        <ion-icon name="play-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon>
                        Trailer</a>
                    <a href="#" class="btn btn-tab-movie d-flex justify-content-center align-items-center">
                        <ion-icon name="document-text-outline" style="font-size:16px; margin-right:8px;"></ion-icon>
                        Comments</a>
                    <a href="#" class="btn btn-tab-movie d-flex justify-content-center align-items-center">
                        <ion-icon name="star-half-outline" style="font-size:16px; margin-right:8px;"></ion-icon>
                        Ratings</a>
                </div>

            </div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-start">
                    <ion-icon name="videocam-outline" style="font-size: 32px;"></ion-icon>
                    <div class="font-weight-bold ml-2" style="font-size: 32px;">Edit Season "{{$season->title}}"</div>
                </div>
                <div class="card-body">
                    <form action="/tvShow/{{$tvShow->slug}}/season/{{$season->id}}/update" method="POST" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="title">Season Title</label>
                            <input class="form-control" id="title" name="title" value="{{$season->title}}" required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Submit</button>
                        <a href="/tvShow/{{$tvShow->slug}}/season" class="btn btn-secondary  mt-4">Cancel</a>
                    </form>
                </div>
            </div>

        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
@stop
