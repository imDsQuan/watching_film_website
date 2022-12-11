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
                    <a href="#" class="btn btn-tab-movie rounded-pill" style="background: #555 !important; color: #fff !important; border:none !important;"><div class="d-flex justify-content-center align-items-center"><ion-icon name="eye-outline" class="mr-2"></ion-icon> 0 Views</div></a>
                    <a href="#" class="btn btn-tab-movie rounded-pill" style="background: #555 !important; color: #fff !important; border:none !important;"><div class="d-flex justify-content-center align-items-center"><ion-icon name="share-social-outline" class="mr-2"></ion-icon> 0 Shares</div></a>
                    <a href="#" class="btn btn-tab-movie rounded-pill" style="background: #555 !important; color: #fff !important; border:none !important;"><div class="d-flex justify-content-center align-items-center"><ion-icon name="arrow-down-outline" class="mr-2"></ion-icon> 0 Downloads</div></a>
                </div>
                <div class="d-flex justify-content-start align-items-center">
                    <div class="card-header " data-background-color="green">
                        <ion-icon name="videocam-outline" style="font-size: 46px;"></ion-icon>
                    </div>
                    <div class="card-content trailer-body">
                        <h4 class="title">New Movie </h4>
                    </div>
                </div>
                <div class="tab-moivie">
                    <a href="#" class="btn btn-tab-movie-active d-flex justify-content-center align-items-center"><ion-icon name="add-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Add</a>
                    <a href="#" class="btn btn-tab-movie btn-disabled d-flex justify-content-center align-items-center"><ion-icon name="folder-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Sources</a>
                    <a href="#" class="btn btn-tab-movie btn-disabled d-flex justify-content-center align-items-center"><ion-icon name="people-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Cast</a>
                    <a href="#" class="btn btn-tab-movie btn-disabled d-flex justify-content-center align-items-center"><ion-icon name="play-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Trailer</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-start">
                    <ion-icon name="videocam-outline" style="font-size: 32px;"></ion-icon>
                    <div class="font-weight-bold ml-2" style="font-size: 32px;">New Movie</div>
                </div>
                <div class="card-body">
                    <form action="/movie" method="POST" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-4">
                                <div class="fileinput">
                                    <a id="btn-select-thumbnail" class="btn btn-secondary btn-select">Select Image</a>
                                    <img class="img-preview  img-thumbnail" src="{{url('images/image_placeholder.jpg')}}" alt="">
                                </div>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" id="imdb" name="type" value="video" required hidden>
                                <input class="file-thumbnail" type="file" name="file-thumbnail" required hidden >
                                <input class="file-cover" type="file" name="file-cover" required hidden >
                                <div class="fileinput">
                                    <a class="btn btn-secondary btn-select" id="btn-select-cover">Select Image</a>
                                    <img class="img-preview img-cover" src="{{url('images/image_placeholder.jpg')}}" alt="">
                                </div>

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="label">Label</label>
                                            <input type="text" class="form-control" id="label" name="label" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="subLabel">Sub-label</label>
                                            <input type="text" class="form-control" id="subLabel" name="subLabel" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Movie Description</label>
                                    <textarea class="form-control" id="description" rows="3" name="description" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="year">Movie Year</label>
                                    <input type="text" class="form-control" id="year" name="year" required>
                                </div>
                                <div class="form-group">
                                    <label for="imdb">Movie IMDB Rating</label>
                                    <input type="text" class="form-control" id="imdb" name="imdb" required>
                                </div>
                                <div class="form-group">
                                    <label for="duration">Movie Duration</label>
                                    <input type="text" class="form-control" id="duration" name="duration" required>
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
                                    <input type="text" class="form-control" id="born" name="listGenre" hidden required>
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
            let listGenreSelect2 = $('#listGenre');

            listGenreSelect2.select2();

            listGenreSelect2.on('select2:select', function (e) {
                $('input[name="listGenre"]').val($('#listGenre').val());
            });
        });
    </script>
@stop
