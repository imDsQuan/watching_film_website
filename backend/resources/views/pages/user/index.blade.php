@extends('layouts.default')

@section('content')
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
            <!-- search -->
            <div class="search" >
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
                <a href="/user" class="col-4 text-decoration-none">
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
                            <span class="font-weight-bold ml-1" style="font-size: 24px;">{{$totalUser}}  User</span>
                        </div>
                    </div>
                </a>
                <a href="/user/create" class="col-4 text-decoration-none">
                    <div class="card m-2 bg-success p-2">
                        <div class="card-body d-flex justify-content-center align-content-center text-white">
                            <ion-icon name="add-circle-outline" style="font-size: 32px;"></ion-icon>
                            <span class="font-weight-bold ml-1" style="font-size: 24px;">Create</span>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <div class="container mt-3">
            <table class="table align-middle mb-0 bg-white">
                <thead class="bg-light">
                <tr>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($listUser as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img
                                        src="{{$user['image']}}"
                                        class="rounded-circle"
                                        alt=""
                                        style="width: 45px; height: 45px"
                                    />
                                    <div class="ml-3">
                                        <p class="fw-bold mb-1">{{$user['full_name']}}</p>
                                        <p class="text-muted mb-0">{{$user['email']}}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="fw-normal mb-1">{{$user['username']}}</p>
                            </td>
                            <td>
                                @if($user['subscription'] == null)
                                    <span class="badge badge-secondary rounded-pill">Not Subscribed</span>
                                @elseif(\Carbon\Carbon::now()->lte($user['subscription']->expired_date))
                                    <span class="badge badge-success rounded-pill">Active</span>
                                @elseif(\Carbon\Carbon::now()->gt($user['subscription']->expired_date))
                                    <span class="badge badge-warning rounded-pill">Expired</span>
                                @endif
                            </td>
                            <td>{{$user['phone']}}</td>
                            <td>
                                <a
                                    href="/user/{{$user['id']}}/edit"
                                    class="btn btn-link btn-rounded btn-sm fw-bold"
                                    data-mdb-ripple-color="dark"
                                >
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
