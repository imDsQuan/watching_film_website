@extends('layouts.default')

@section('content')
    <style>
        .season-box{
            position: relative;
            height: 250px;
            margin-top: 40px;
            border: 1px solid #ccc;
            box-shadow: 0 1px 4px 0 rgb(0 0 0 / 14%);
            border-radius: 6px;
            padding: 0 30px;
        }

        .season-box .season-title {
            display: flex;
            position: absolute;
            top: -20px;
            left: 32px;
            border: 1px solid #ccc;
            justify-content: center;
            align-items: center;
            padding: 8px;
            font-weight: 500;
            background: var(--white);
        }

        .season-box .season-title .title {
            margin-left: 4px;
        }

        .season-box .season-control {
            display: flex;
            position: absolute;
            top: -20px;
            right: 32px;
            justify-content: center;
            align-items: center;
        }
        .season-box .season-body {
            height: 250px;
            display: flex;
            justify-content: start;
            overflow-x: auto;
        }

        .episode {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: start;
            height: 150px;
            width: 450px;
            margin: 48px 16px 0 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .episode .img {
            width: 150px !important;
            height: 150px;
            border-radius: 6px;
            overflow: hidden;
        }

        .episode .img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .episode .episode-body {
            width: 280px;
            margin-left: 10px;
            margin-right: 10px
        }
        .episode .episode-control {
            position: absolute;
            bottom: -18px;
            right: 18px;
        }

        .episode-body .title {
            white-space: nowrap;
            font-weight: 600;
            font-size: 22px;
            margin: 10px 0;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .episode-body .body {
            text-overflow: ellipsis;
            overflow: hidden;
            font-size: 16px;
            line-height: 18px;
            height: 54px;
        }

    </style>
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
                <img src="{{url('/images/avatar_default.png')}}" alt="">
            </div>
        </div>


        <div class="container">

            <div class="card card-stats card-initial" style="margin: 15px 0;">
                <div class="card-content views-body  pull-right">
                    <a href="#" class="btn btn-tab-movie rounded-pill"
                       style="background: #555 !important; color: #fff !important; border:none !important;">
                        <div class="d-flex justify-content-center align-items-center">
                            <ion-icon name="eye-outline" class="mr-2"></ion-icon> {{$tvShow->views}} Views
                        </div>
                    </a>
                    <a href="#" class="btn btn-tab-movie rounded-pill"
                       style="background: #555 !important; color: #fff !important; border:none !important;">
                        <div class="d-flex justify-content-center align-items-center">
                            <ion-icon name="share-social-outline" class="mr-2"></ion-icon>
                            0 Shares
                        </div>
                    </a>
                    <a href="#" class="btn btn-tab-movie rounded-pill"
                       style="background: #555 !important; color: #fff !important; border:none !important;">
                        <div class="d-flex justify-content-center align-items-center">
                            <ion-icon name="share-social-outline" class="mr-2"></ion-icon> {{$tvShow->rating}} Downloads
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-start align-items-center">
                    <div class="card-header " data-background-color="green">
                        <ion-icon name="videocam-outline" style="font-size: 46px;"></ion-icon>
                    </div>
                    <div class="card-content trailer-body">
                        <h4 class="title">Edit Movie {{$tvShow->title}} </h4>
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
                    <a href="/movie/{{$tvShow->slug}}/cast"
                       class="btn btn-tab-movie d-flex justify-content-center align-items-center">
                        <ion-icon name="people-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon>
                        Cast</a>
                    <a href="/movie/{{$tvShow->slug}}/trailer"
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
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center justify-content-start">
                        <ion-icon name="library-outline" style="font-size: 32px;"></ion-icon>
                        <div class="font-weight-bold ml-2" style="font-size: 32px;">Season "{{$tvShow->title}}"</div>
                    </div>
                    <button id="btn-create-season" href="/movie/{{$tvShow->id}}/source/create" class="btn float-right">
                        <div class="card m-2 bg-success" style="height: 40px;">
                            <div class="card-body d-flex justify-content-center align-items-center text-white">
                                <ion-icon name="add-circle-outline" style="font-size: 24px;"></ion-icon>
                                <span class="font-weight-bold ml-1" style="font-size: 18px;">Create</span>
                            </div>
                        </div>
                    </button>
                </div>

            </div>

            <div class="card" style="margin: 15px 0;" id="create-season-box">
                <div class="card-header d-flex bg-white w-100 align-items-center">
                    <ion-icon class="p-1 rounded bg-info mr-3" name="add-outline"
                              style="font-size: 46px;"></ion-icon>
                    <h4>Add Season </h4>
                </div>
                <div class="card-body">
                    <form action="tvShow/{{$tvShow->slug}}/season" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="title">Season Title</label>
                            <input type="text" class="form-control" id="title" name="role" value="" required>
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary mt-4">Submit</button>
                            <button id="btn-cancel-create-season" class="btn btn-secondary  mt-4">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
            <div class="season-box">
                <div class="season-title">
                    <ion-icon name="newspaper-outline"></ion-icon>
                    <span class="title">Tro ve tu coi chet</span>
                </div>
                <div class="season-control">
                    <a href=" /tvShow/{{$tvShow->slug}}/cast//edit" class="btn btn-success mr-2 d-flex align-items-center"><ion-icon class="mr-2" name="add-circle-outline"></ion-icon> New Episode</a>
                    <a href=" /tvShow/{{$tvShow->slug}}/cast//edit" class="btn btn-warning mr-2"><ion-icon name="build-outline"></ion-icon></a>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="showData()"><ion-icon name="trash-outline"></ion-icon></button>
                    <a href="/tvShow/{{$tvShow->slug}}/cast//up" class="btn btn-info mx-2"><ion-icon name="chevron-up-outline"></ion-icon></a>
                    <a href="/tvShow/{{$tvShow->slug}}/cast//down" class="btn btn-info"><ion-icon name="chevron-down-outline"></ion-icon></a>
                </div>
                <div class="season-body">
                    <div class="episode">
                        <div class="img">
                            <img class="" src="{{url('images/image_placeholder.jpg')}}" alt="">
                        </div>
                        <div class="episode-body">
                            <div class="title">Alive in Tucson</div>
                            <div class="body">After a deadly virus wipes out humanity, Phil Miller searches the country for more survivors.</div>
                        </div>
                        <div class="episode-control">
                            <a href=" /tvShow/{{$tvShow->slug}}/cast//edit" class="btn btn-warning mr-2"><ion-icon name="build-outline"></ion-icon></a>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="showData()"><ion-icon name="trash-outline"></ion-icon></button>
                            <a href="/tvShow/{{$tvShow->slug}}/cast//up" class="btn btn-info mx-2"><ion-icon name="chevron-up-outline"></ion-icon></a>
                            <a href="/tvShow/{{$tvShow->slug}}/cast//down" class="btn btn-info"><ion-icon name="chevron-down-outline"></ion-icon></a>
                        </div>
                    </div>
                    <div class="episode">
                        <div class="img">
                            <img class="" src="{{url('images/image_placeholder.jpg')}}" alt="">
                        </div>
                        <div class="episode-body">
                            <div class="title">Alive in Tucson</div>
                            <div class="body">After a deadly virus wipes out humanity, Phil Miller searches the country for more survivors.</div>
                        </div>
                        <div class="episode-control">
                            <a href=" /tvShow/{{$tvShow->slug}}/cast//edit" class="btn btn-warning mr-2"><ion-icon name="build-outline"></ion-icon></a>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="showData()"><ion-icon name="trash-outline"></ion-icon></button>
                            <a href="/tvShow/{{$tvShow->slug}}/cast//up" class="btn btn-info mx-2"><ion-icon name="chevron-up-outline"></ion-icon></a>
                            <a href="/tvShow/{{$tvShow->slug}}/cast//down" class="btn btn-info"><ion-icon name="chevron-down-outline"></ion-icon></a>
                        </div>
                    </div>
                    <div class="episode">
                        <div class="img">
                            <img class="" src="{{url('images/image_placeholder.jpg')}}" alt="">
                        </div>
                        <div class="episode-body">
                            <div class="title">Alive in Tucson</div>
                            <div class="body">After a deadly virus wipes out humanity, Phil Miller searches the country for more survivors.</div>
                        </div>
                        <div class="episode-control">
                            <a href=" /tvShow/{{$tvShow->slug}}/cast//edit" class="btn btn-warning mr-2"><ion-icon name="build-outline"></ion-icon></a>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="showData()"><ion-icon name="trash-outline"></ion-icon></button>
                            <a href="/tvShow/{{$tvShow->slug}}/cast//up" class="btn btn-info mx-2"><ion-icon name="chevron-up-outline"></ion-icon></a>
                            <a href="/tvShow/{{$tvShow->slug}}/cast//down" class="btn btn-info"><ion-icon name="chevron-down-outline"></ion-icon></a>
                        </div>
                    </div>
                    <div class="episode">
                        <div class="img">
                            <img class="" src="{{url('images/image_placeholder.jpg')}}" alt="">
                        </div>
                        <div class="episode-body">
                            <div class="title">Alive in Tucson</div>
                            <div class="body">After a deadly virus wipes out humanity, Phil Miller searches the country for more survivors.</div>
                        </div>
                        <div class="episode-control">
                            <a href=" /tvShow/{{$tvShow->slug}}/cast//edit" class="btn btn-warning mr-2"><ion-icon name="build-outline"></ion-icon></a>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="showData()"><ion-icon name="trash-outline"></ion-icon></button>
                            <a href="/tvShow/{{$tvShow->slug}}/cast//up" class="btn btn-info mx-2"><ion-icon name="chevron-up-outline"></ion-icon></a>
                            <a href="/tvShow/{{$tvShow->slug}}/cast//down" class="btn btn-info"><ion-icon name="chevron-down-outline"></ion-icon></a>
                        </div>
                    </div>
                    <div class="episode">
                        <div class="img">
                            <img class="" src="{{url('images/image_placeholder.jpg')}}" alt="">
                        </div>
                        <div class="episode-body">
                            <div class="title">Alive in Tucson</div>
                            <div class="body">After a deadly virus wipes out humanity, After a deadly virus wipes out humanity, After a deadly virus wipes out humanity, After a deadly virus wipes out humanity, After a deadly virus wipes out humanity,After a deadly virus wipes out humanity, Phil Miller searches the country for more survivors.</div>
                        </div>
                        <div class="episode-control">
                            <a href=" /tvShow/{{$tvShow->slug}}/cast//edit" class="btn btn-warning mr-2"><ion-icon name="build-outline"></ion-icon></a>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="showData()"><ion-icon name="trash-outline"></ion-icon></button>
                            <a href="/tvShow/{{$tvShow->slug}}/cast//up" class="btn btn-info mx-2"><ion-icon name="chevron-up-outline"></ion-icon></a>
                            <a href="/tvShow/{{$tvShow->slug}}/cast//down" class="btn btn-info"><ion-icon name="chevron-down-outline"></ion-icon></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>


    <script>
        $(document).ready(function () {
            $('#create-season-box').hide();
            $('#btn-create-season').on('click', function () {
                $('#create-season-box').show();
            })
            $('#btn-cancel-create-season').on('click', function () {
                $('#create-season-box').hide();
            })
        })


    </script>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Source</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do You Want To Delete This Source?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="btn-delete-source">Delete</button>
                </div>
            </div>
        </div>
    </div>

@stop
