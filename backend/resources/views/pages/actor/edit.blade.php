@extends('layouts.default')

@section('content')
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
            <!-- search -->
            <div class="search">
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
                    <div class="font-weight-bold ml-2" style="font-size: 32px;">Edit Actor</div>
                </div>
                <div class="card-body">
                    <form action="/actor/update" method="POST" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-4">
                                <div class="fileinput">
                                    <a id="btn-select-thumbnail" class="btn btn-secondary btn-select">Select Image</a>
                                    <img class="img-preview img-thumbnail" src="{{$actor->img_thumbnail}}" alt="">
                                </div>
                            </div>
                            <div class="col">
                                <input class="file-thumbnail" type="file" name="file-thumbnail" hidden >
                                <input type="text" name="id" hidden value="{{$actor->id}}">
                                <div class="form-group">
                                    <label for="fullname">Full Name</label>
                                    <input type="text" class="form-control" id="fullname" name="name" value="{{$actor->name}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select class="form-control" id="type" name="type">
                                        <option>Actor</option>
                                        <option>Actress</option>
                                        <option>Director</option>
                                        <option>Producer</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="born">Born</label>
                                    <input type="text" class="form-control" id="born" name="born" required value="{{$actor->born}}">
                                </div>
                                <div class="form-group">
                                    <label for="height">Height</label>
                                    <input type="text" class="form-control" id="height" name="height" required value="{{$actor->height}}">
                                </div>
                                <div class="form-group">
                                    <label for="bio">Bio</label>
                                    <textarea class="form-control" id="bio" rows="3" name="bio" required>{{$actor->bio}}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="/actor" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>


    </div>

    <script>
        $(document).ready(function(){
            $('#type option[value={{$actor->type}}]').attr('selected','selected');
        })
    </script>
@stop
