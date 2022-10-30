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
                        <h4 class="title">Edit TvShow {{$tvShow->title}} </h4>
                    </div>
                </div>
                <div class="tab-moivie">
                    <a href="#" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="add-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Edit</a>
                    <a href="/tvShow/{{$tvShow->slug}}/season" class="btn btn-tab-movie-active d-flex justify-content-center align-items-center"><ion-icon name="library-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Season</a>
                    <a href="/tvShow/{{$tvShow->slug}}/cast" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="people-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Cast</a>
                    <a href="/tvShow/{{$tvShow->slug}}/trailer" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="play-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Trailer</a>
                    <a href="#" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="document-text-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Comments</a>
                    <a href="#" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="star-half-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Ratings</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center justify-content-start">
                        <ion-icon name="videocam-outline" style="font-size: 32px;"></ion-icon>
                        <div class="font-weight-bold ml-2" style="font-size: 32px;">Source Of "{{$episode->title}}"</div>
                    </div>
                    <a href="/tvShow/{{$tvShow->slug}}/season/{{$season->id}}/episode/{{$episode->id}}/source/create" class="text-decoration-none float-right">
                        <div class="card m-2 bg-success" style="height: 40px;">
                            <div class="card-body d-flex justify-content-center align-items-center text-white">
                                <ion-icon name="add-circle-outline" style="font-size: 24px;"></ion-icon>
                                <span class="font-weight-bold ml-1" style="font-size: 18px;">Create</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <a href="/tvShow/{{$tvShow->slug}}/season/{{$season->id}}/episode/{{$episode->id}}/edit" class="btn btn-tab-movie d-flex justify-content-center align-items-center mb-3"><ion-icon name="add-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Edit</a>
                            <a href="/tvShow/{{$tvShow->slug}}/season/{{$season->id}}/episode/{{$episode->id}}/source" class="btn btn-tab-movie-active d-flex justify-content-center align-items-center mb-3"><ion-icon name="folder-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Sources</a>
                            <a href="#" class="btn btn-tab-movie d-flex justify-content-center align-items-center mb-3"><ion-icon name="eye-outline" style="font-size:16px; margin-right:8px;"></ion-icon> 0 Views</a>
                            <a href="#" class="btn btn-tab-movie d-flex justify-content-center align-items-center mb-3"><ion-icon name="share-social-outline" style="font-size:16px; margin-right:8px;"></ion-icon> 0 Share</a>
                            <a href="#" class="btn btn-tab-movie d-flex justify-content-center align-items-center mb-3"><ion-icon name="arrow-down-outline" style="font-size:16px; margin-right:8px;"></ion-icon> 0 Downloads</a>
                        </div>
                        <div class="col">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Type</th>
                                    <th scope="col" class="text-center">Url</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                @if(isset($listSource) && $listSource != null)
                                    <tbody>
                                    @foreach($listSource as $source)
                                        <tr>
                                            <th scope="row" class="align-middle">{{$source->type}}</th>
                                            <td><span class="d-block bg-info m-2 rounded p-2">{{$source->url}}</span></td>
                                            <td class="align-middle">
                                                <div class="d-flex">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <a href="/tvShow/{{$tvShow->slug}}/season/{{$season->id}}/episode/{{$episode->id}}/source/{{$source->id}}/edit" class="btn btn-warning mr-2"><ion-icon name="build-outline"></ion-icon></a>
                                                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"><ion-icon name="trash-outline"></ion-icon></button>
                                                    </div>
                                                </div>
                                            </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
    @if(isset($listSource) && $listSource != null)

    <script>
        $(document).ready(function (){
            $('#btn-delete-source').on('click', function () {
                $.ajax({
                    url: "http://localhost:8000/" + "tvShow/{{$tvShow->id}}/season/{{$season->id}}/episode/{{$episode->id}}/source/{{$source->id}}/delete",
                    method: "POST",
                    dataType: "json",
                    success: function () {
                        $('#deleteModal').modal('toggle');
                        window.location.reload();
                    }
                })
            });


        })


    </script>

    @endif
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
