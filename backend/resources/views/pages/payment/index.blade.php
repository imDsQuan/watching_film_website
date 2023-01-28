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
                <a href="/payment" class="col-4 text-decoration-none">
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
                            <span class="font-weight-bold ml-1" style="font-size: 24px;">{{$totalPayment}} Payment</span>
                        </div>
                    </div>
                </a>
                <a href="/user/create" class="col-4 text-decoration-none">
                    <div class="card m-2 bg-success p-2" style="opacity: 0.6;">
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
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Pack</th>
                    <th>Price</th>
                    <th>Currency</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>Expired Date</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($listSub as $key=>$sub)
                        <tr>
                            <td>{{$key}}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img
                                        src="{{$sub['user']->image}}"
                                        class="rounded-circle"
                                        alt=""
                                        style="width: 40px; height: 40px"
                                    />
                                    <div class="ml-3">
                                        <p class="fw-bold mb-1">{{$sub['user']->full_name}}</p>
                                        <p class="text-muted mb-0">{{$sub['user']->email}}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="fw-normal mb-1">{{$sub['pack']->title}}</p>
                            </td>
                            <td>
                                <p class="fw-normal mb-1">{{$sub['price']}}</p>
                            </td>
                            <td>
                                <p class="fw-normal mb-1">{{$sub['currency']}}</p>
                            </td>
                            <td>
                                @if($sub['status'] === 'COMPLETED')
                                    <span class="badge badge-success rounded-pill">{{$sub['status']}}</span>
                                @else
                                    <span class="badge badge-warning rounded-pill">{{$sub['status']}}</span>
                                @endif
                            </td>
                            <td>{{\Carbon\Carbon::parse($sub['start_date'])->format('M d Y')}}</td>
                            <td>{{\Carbon\Carbon::parse($sub['expired_date'])->format('M d Y')}}</td>

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
