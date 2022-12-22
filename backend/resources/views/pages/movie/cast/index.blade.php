@extends('layouts.default')

@section('content')
    <style>
        .select2-container--default .select2-results>.select2-results__options{
            max-height: 140px !important;
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
                <img src="{{url('/images/avatar_default.png')}}" alt="" >
            </div>
        </div>


        <div class="container">

            <div class="card card-stats card-initial" style="margin: 15px 0;">
                <div class="card-content views-body  pull-right">
                    <a href="#" class="btn btn-tab-movie rounded-pill" style="background: #555 !important; color: #fff !important; border:none !important;"><div class="d-flex justify-content-center align-items-center"><ion-icon name="eye-outline" class="mr-2"></ion-icon> {{$movie->views}} Views</div></a>
                    <a href="#" class="btn btn-tab-movie rounded-pill" style="background: #555 !important; color: #fff !important; border:none !important;"><div class="d-flex justify-content-center align-items-center"><ion-icon name="share-social-outline" class="mr-2"></ion-icon> 0 Shares</div></a>
                    <a href="#" class="btn btn-tab-movie rounded-pill" style="background: #555 !important; color: #fff !important; border:none !important;"><div class="d-flex justify-content-center align-items-center"><ion-icon name="share-social-outline" class="mr-2"></ion-icon> {{$movie->rating}} Downloads</div></a>
                </div>
                <div class="d-flex justify-content-start align-items-center">
                    <div class="card-header " data-background-color="green">
                        <ion-icon name="videocam-outline" style="font-size: 46px;"></ion-icon>
                    </div>
                    <div class="card-content trailer-body">
                        <h4 class="title">Edit Movie {{$movie->title}} </h4>
                    </div>
                </div>
                <div class="tab-moivie">
                    <a href="/movie/{{$movie->slug}}/edit" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="add-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Edit</a>
                    <a href="/movie/{{$movie->slug}}/source" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="folder-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Sources</a>
                    <a href="/movie/{{$movie->slug}}/cast" class="btn btn-tab-movie-active d-flex justify-content-center align-items-center"><ion-icon name="people-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Cast</a>
                    <a href="/movie/{{$movie->slug}}/trailer" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="play-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Trailer</a>

                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center justify-content-start">
                        <ion-icon name="videocam-outline" style="font-size: 32px;"></ion-icon>
                        <div class="font-weight-bold ml-2" style="font-size: 32px;">Actors Of "{{$movie->title}}"</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3 my-3">
                            <div class="card" style="height: 360px">
                                <img class="card-img-top" src="{{url('/images/add_actor.png')}}" alt="Card image cap" style="height: 180px; object-fit: contain">
                                <div class="card-body text-center">
                                    <form action="/movie/{{$movie->slug}}/cast" method="POST">
                                            {{ csrf_field() }}
                                        <input type="text" class="form-control mb-2 text-center" name="poster_id" value="{{$movie->id}}" hidden required>
                                        <input type="text" class="form-control mb-2 text-center" name="role" placeholder="Enter Role" required>
                                        <select class="form-control mb-2" id="select_actor" name="actor_id">
                                            @foreach($listActor as $actor)
                                                <option value="{{$actor['id']}}">{{$actor['name']}}</option>
                                            @endforeach

                                        </select>
                                        <button type="submit" class="btn btn-success mt-3">
                                            <div class="d-flex">
                                                <ion-icon name="add-circle-outline" class="my-auto  mr-2"></ion-icon> Save
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @foreach($actors as $actor)
                            <div class="col-3 my-3">
                                <div class="card" style="height: 360px">
                                    <img class="card-img-top" src="{{$actor->img_url}}" alt="Card image cap" style="height: 200px; object-fit: cover">
                                    <div class="card-body">
                                        <h3 class="text-center" style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">{{$actor->role}}</h3>
                                        <h5 class="card-title text-center" style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">{{$actor->name}}</h5>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href=" /movie/{{$movie->slug}}/cast/{{$actor->role_id}}/edit" class="btn btn-warning mr-2"><ion-icon name="build-outline"></ion-icon></a>
                                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="showData({{$actor->role_id}})"><ion-icon name="trash-outline"></ion-icon></button>
                                            <a href="/movie/{{$movie->slug}}/cast/{{$actor->role_id}}/up" class="btn btn-info mx-2"><ion-icon name="chevron-up-outline"></ion-icon></a>
                                            <a href="/movie/{{$movie->slug}}/cast/{{$actor->role_id}}/down" class="btn btn-info"><ion-icon name="chevron-down-outline"></ion-icon></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>


    </div>

    <script>
        function showData(deleteActorId) {
            deleteId = deleteActorId;
        }

        let deleteId = null;

        $(document).ready(function (){
            $('#btn-delete-cast').on('click', function () {
                $.ajax({
                    url: "http://localhost:8000/" + "movie/{{$movie->id}}/cast/" + deleteId + "/delete",
                    method: "POST",
                    dataType: "json",
                    success: function () {
                        $('#deleteModal').modal('toggle');
                        window.location.reload();
                    }
                })
            });
            $('#select_actor').select2();


        })


    </script>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Cast</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do You Want To Delete This Actor?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="btn-delete-cast">Delete</button>
                </div>
            </div>
        </div>
    </div>

@stop
