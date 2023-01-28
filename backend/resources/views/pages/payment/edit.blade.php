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
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-start">
                    <ion-icon name="people-outline" style="font-size: 32px;"></ion-icon>
                    <div class="font-weight-bold ml-2" style="font-size: 32px;">Edit Genre</div>
                </div>
                <div class="card-body">
                    <form action="/pack/update" method="POST" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{$pack->title}}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea type="text" class="form-control" id="description" name="description" required>
                                {{$pack->description}}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="discount">Discount</label>
                            <input type="text" class="form-control" id="discount" name="discount" value="{{$pack->discount}}" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" id="price" name="price" value="{{$pack->price}}" required>
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration</label>
                            <input type="text" class="form-control" id="duration" name="duration" value="{{$pack->duration}}" required>
                        </div>
                        <input type="text" name="id" id="idGenre" value="{{$pack->id}}" hidden/>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="/genre" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>

        </div>


    </div>

@stop
