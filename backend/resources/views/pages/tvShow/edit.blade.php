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
                    <a href="/tvShow/{{$tvShow->slug}}/edit" class="btn btn-tab-movie-active d-flex justify-content-center align-items-center"><ion-icon name="add-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Edit</a>
                    <a href="/tvShow/{{$tvShow->slug}}/season" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="library-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Season</a>
                    <a href="/tvShow/{{$tvShow->slug}}/cast" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="people-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Cast</a>
                    <a href="/tvShow/{{$tvShow->slug}}/trailer" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="play-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Trailer</a>

                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-start">
                    <ion-icon name="videocam-outline" style="font-size: 32px;"></ion-icon>
                    <div class="font-weight-bold ml-2" style="font-size: 32px;">Edit Movie</div>
                </div>
                <div class="card-body">
                    <form action="/tvShow/update" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-4">
                                <div class="fileinput">
                                    <a id="btn-select-thumbnail" class="btn btn-secondary btn-select">Select Image</a>
                                    <img class="img-preview  img-thumbnail" src="{{$tvShow->img_thumbnail}}" alt="">
                                </div>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="id" value="{{$tvShow->id}}" hidden required>
                                <input type="text" class="form-control" id="imdb" name="type" value="tvShow" required hidden>
                                <input class="file-thumbnail" type="file" name="file-thumbnail" hidden >
                                <input class="file-cover" type="file" name="file-cover" hidden >
                                <div class="fileinput">
                                    <a class="btn btn-secondary btn-select" id="btn-select-cover">Select Image</a>
                                    <img class="img-preview img-cover" src="{{$tvShow->img_cover}}" alt="">
                                </div>

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{$tvShow->title}}" required>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="label">Label</label>
                                            <input type="text" class="form-control" id="label" name="label" value="{{$tvShow->label}}" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="subLabel">Sub-label</label>
                                            <input type="text" class="form-control" id="subLabel" name="subLabel" value="{{$tvShow->subLabel}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Movie Description</label>
                                    <textarea class="form-control" id="description" rows="3" name="description" required>{{$tvShow->description}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="year">Movie Year</label>
                                    <input type="text" class="form-control" id="year" name="year" value="{{$tvShow->year}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="imdb">Movie IMDB Rating</label>
                                    <input type="text" class="form-control" id="imdb" name="imdb" value="{{$tvShow->imdb}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="duration">Movie Duration</label>
                                    <input type="text" class="form-control" id="duration" name="duration" value="{{$tvShow->duration}}" required>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="1" id="enable" name="enable">
                                    <label class="form-check-label" for="enable">
                                        Enable
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="listGenre">Type</label>
                                    <select class="form-control" id="listGenre" multiple="multiple">
                                        @foreach($listGenres as $genre)
                                            <option value="{{$genre['id']}}">{{$genre['title']}}</option>
                                        @endforeach
                                    </select>
                                    <label>
                                        <input type="text" class="form-control" name="listGenre" hidden required/>
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="/movie" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>


    </div>

    <script>
        $(document).ready(function(){

            let listGenre = Object.values(<?php echo $tvShow->genres ?>);

            let listGenreSelect2 = $('#listGenre');

            listGenreSelect2.select2();

            listGenreSelect2.val(listGenre).trigger('change');

            $('input[name="listGenre"]').val(listGenreSelect2.val());

            listGenreSelect2.on('select2:select', function (e) {
                $('input[name="listGenre"]').val(listGenreSelect2.val());
            });


            if (1 == <?php echo $tvShow->enable ?>) {
                $('input[name="enable"]').prop( "checked", true );
            }


        });
    </script>
@stop
