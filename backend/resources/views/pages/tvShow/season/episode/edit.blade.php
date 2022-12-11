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
                        <h4 class="title">Edit TV Show </h4>
                    </div>
                </div>
                <div class="tab-moivie">
                    <a href="#" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="add-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Edit</a>
                    <a href="/tvShow/{{$tvShow->slug}}/season" class="btn btn-tab-movie-active d-flex justify-content-center align-items-center"><ion-icon name="library-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Season</a>
                    <a href="/tvShow/{{$tvShow->slug}}/cast" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="people-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Cast</a>
                    <a href="/tvShow/{{$tvShow->slug}}/trailer" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="play-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Trailer</a>

                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-start">
                    <ion-icon name="videocam-outline" style="font-size: 32px;"></ion-icon>
                    <div class="font-weight-bold ml-2" style="font-size: 32px;">Eidt Episode "{{$episode->title}}"</div>
                </div>
                <div class="card-body">
                    <form action="/tvShow/{{$tvShow->slug}}/season/{{$season->id}}/episode/{{$episode->id}}/update" method="POST" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-4">
                                <a href="/tvShow/{{$tvShow->slug}}/season/{{$season->id}}/episode/{{$episode->id}}/edit" class="btn btn-tab-movie-active d-flex justify-content-center align-items-center mb-3"><ion-icon name="add-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Edit</a>
                                <a href="/tvShow/{{$tvShow->slug}}/season/{{$season->id}}/episode/{{$episode->id}}/source" class="btn btn-tab-movie d-flex justify-content-center align-items-center mb-3"><ion-icon name="folder-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Sources</a>
                                <a href="#" class="btn btn-tab-movie d-flex justify-content-center align-items-center mb-3"><ion-icon name="eye-outline" style="font-size:16px; margin-right:8px;"></ion-icon> 0 Views</a>
                                <a href="#" class="btn btn-tab-movie d-flex justify-content-center align-items-center mb-3"><ion-icon name="share-social-outline" style="font-size:16px; margin-right:8px;"></ion-icon> 0 Share</a>
                                <a href="#" class="btn btn-tab-movie d-flex justify-content-center align-items-center mb-3"><ion-icon name="arrow-down-outline" style="font-size:16px; margin-right:8px;"></ion-icon> 0 Downloads</a>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" id="imdb" name="type" value="tvShow"  hidden>
                                <input class="file-cover" type="file" name="file-cover" hidden >
                                <div class="fileinput">
                                    <a class="btn btn-secondary btn-select" id="btn-select-cover">Select Image</a>
                                    <img class="img-preview img-cover" src="{{$episode->img_url}}" alt="">
                                </div>

                                <div class="form-group">
                                    <label for="title">Episode Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{$episode->title}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Episode Description</label>
                                    <textarea class="form-control" id="description" rows="3" name="description" required>{{$episode->description}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="duration">Episode Duration</label>
                                    <input type="text" class="form-control" id="duration" name="duration" value="{{$episode->duration}}" required>
                                </div>
                                <div class="form-check mb-3">
                                    @if ($episode->enabled > 0)
                                        <input class="form-check-input" type="checkbox" value="1" id="enable" name="enable" checked>
                                    @else
                                        <input class="form-check-input" type="checkbox" value="1" id="enable" name="enable">
                                    @endif
                                    <label class="form-check-label" for="enable">
                                        Enable
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="/tvShow/{{$tvShow->slug}}/season" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>



    </div>
@stop
