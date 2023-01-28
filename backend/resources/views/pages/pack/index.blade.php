@extends('layouts.default')

@section('content')
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
            <!-- search -->
            <div class="search invisible" >
                <label for="">
                    <input id="searchActor" type="text" placeholder="Search Here">
                    <ion-icon name="search-outline"></ion-icon>
                </label>
            </div>
            <!-- User Image -->
            <div class="user">
                <img src="{{url('/images/avatar_default.png')}}" alt="">
            </div>
        </div>

        <!--  cards -->

        <div class="container">
            <div class="row">
                <a href="/pack" class="col-4 text-decoration-none">
                    <div class="card m-2 bg-primary p-2">
                        <div class="card-body d-flex justify-content-center align-content-center text-white">
                            <ion-icon name="refresh-outline" style="font-size: 32px;"></ion-icon>
                            <span class="font-weight-bold ml-1" style="font-size: 24px;">Refresh</span>
                        </div>
                    </div>
                </a>
                <a href="#" class="col-4 text-decoration-none">
                    <div class="card m-2 bg-info p-2">
                        <div class="card-body d-flex justify-content-center align-content-center text-white">
                            <ion-icon name="bookmark-outline" style="font-size: 32px;"></ion-icon>
                            <span class="font-weight-bold ml-1" style="font-size: 24px;"> {{$totalPack}} Pack</span>
                        </div>
                    </div>
                </a>
                <a href="/pack/create" class="col-4 text-decoration-none">
                    <div class="card m-2 bg-success p-2">
                        <div class="card-body d-flex justify-content-center align-content-center text-white">
                            <ion-icon name="add-circle-outline" style="font-size: 32px;"></ion-icon>
                            <span class="font-weight-bold ml-1" style="font-size: 24px;">Create</span>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <!-- order detail list -->
        <div class="container mt-3">
            <div class="row" id="news-container">
                @foreach($listPack as $genre)
                <div class="col-3 my-3">
                    <div class="card">
                        <div class="card-header" style="text-align: left;height: 130px;padding: 0px;background: black;border-top-left-radius: 0.25rem;border-top-right-radius: 0.25rem; border: 8px solid #fff">
                            <ion-icon style="font-size:60px; color:#fff; padding: 20px" name="pricetags-outline"></ion-icon>
                        </div>
                        <div class="card-body">
                                <h5 class="card-title text-center" style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">{{$genre['title']}}</h5>
                                <div class="d-flex justify-content-center align-items-center">
                                    <a href="/pack/{{$genre['title']}}/edit" class="btn btn-warning mx-2"><ion-icon name="build-outline"></ion-icon></a>
                                    <button class="btn btn-danger mx-2" data-toggle="modal" data-target="#deleteModal" onclick="showData({{$genre['id']}})"><ion-icon name="trash-outline"></ion-icon></button>
                                    <a href="/pack/{{$genre['id']}}/up" class="btn btn-info mx-2"><ion-icon name="chevron-up-outline"></ion-icon></a>
                                    <a href="/pack/{{$genre['id']}}/down" class="btn btn-info mx-2"><ion-icon name="chevron-down-outline"></ion-icon></a>
                                </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>
    </div>

    <script>

        let deleteId = null;

        function showData(deleteActorId) {
            deleteId = deleteActorId;
        }

        $(document).ready(function () {
            $('#btn-delete-genre').on('click', function () {
                $.ajax({
                    url: "http://localhost:8000/" + "pack/delete/" + deleteId,
                    method: "POST",
                    dataType: "json",
                    success: function () {
                        $('#deleteModal').modal('toggle');
                        window.location.reload();
                    },
                })
            });
        });

    </script>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Actor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do You Want To Delete This Actor?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="btn-delete-genre">Delete</button>
                </div>
            </div>
        </div>
    </div>

@stop
