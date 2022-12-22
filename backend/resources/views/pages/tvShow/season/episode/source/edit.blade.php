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
                    <a href="#" class="btn btn-tab-movie rounded-pill" style="background: #555 !important; color: #fff !important; border:none !important;"><div class="d-flex justify-content-center align-items-center"><ion-icon name="eye-outline" class="mr-2"></ion-icon> {{$tvShow->views}}</div></a>
                    <a href="#" class="btn btn-tab-movie rounded-pill" style="background: #555 !important; color: #fff !important; border:none !important;"><div class="d-flex justify-content-center align-items-center"><ion-icon name="share-social-outline" class="mr-2"></ion-icon> 0 Shares</div></a>
                    <a href="#" class="btn btn-tab-movie rounded-pill" style="background: #555 !important; color: #fff !important; border:none !important;"><div class="d-flex justify-content-center align-items-center"><ion-icon name="arrow-down-outline" class="mr-2"></ion-icon> 0 Downloads</div></a>
                </div>
                <div class="d-flex justify-content-start align-items-center">
                    <div class="card-header " data-background-color="green">
                        <ion-icon name="videocam-outline" style="font-size: 46px;"></ion-icon>
                    </div>
                    <div class="card-content trailer-body">
                        <h4 class="title">Edit Movie </h4>
                    </div>
                </div>
                <div class="tab-moivie">
                    <a href="/tvShow/{{$tvShow->slug}}/edit" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="add-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Edit</a>
                    <a href="/tvShow/{{$tvShow->slug}}/season" class="btn btn-tab-movie-active d-flex justify-content-center align-items-center"><ion-icon name="library-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Season</a>
                    <a href="/tvShow/{{$tvShow->slug}}/cast" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="people-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Cast</a>
                    <a href="/tvShow/{{$tvShow->slug}}/trailer" class="btn btn-tab-movie d-flex justify-content-center align-items-center"><ion-icon name="play-circle-outline" style="font-size:16px; margin-right:8px;"></ion-icon> Trailer</a>

                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-start">
                    <ion-icon name="videocam-outline" style="font-size: 32px;"></ion-icon>
                    <div class="font-weight-bold ml-2" style="font-size: 32px;">Edit Source Of "{{$tvShow->title}}"</div>
                </div>
                <div class="card-body">
                    <form action="/tvShow/{{$tvShow->slug}}/season/{{$season->id}}/episode/{{$episode->id}}/source/{{$source->id}}update" method="POST" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" id="movie_id" name="movie_id" value="{{$tvShow->id}}" required hidden>

                                <div class="form-group">
                                    <label for="title">Source Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required value="{{$source->title}}">
                                </div>
                                <div class="form-group">
                                    <label for="quality">Source Quality</label>
                                    <input class="form-control" id="quality" name="quality" required value="{{$source->quality}}">
                                </div>
                                <div class="form-group">
                                    <label for="type">Source Type</label>
                                    <select class="form-control" id="type" name="type">
                                        <option value="Youtube">Youtube URL</option>
                                        <option value="MP4">MP4 URL</option>
                                        <option value="FILE">File</option>
                                    </select>
                                    <button id="btn-upload-file" type="button" class="btn btn-info mt-2" data-toggle="modal" data-target="#exampleModal">
                                        Add File
                                    </button>
                                </div>

                                <div class="form-group">
                                    <label for="source_url">Source URL</label>
                                    <input type="text" class="form-control" id="source_url" name="source_url" required value="{{$source->url}}">
                                </div>

                                <button type="submit" class="btn btn-primary mt-4">Submit</button>
                                <a href="/tvShow/{{$tvShow->slug}}/season/{{$season->id}}/episode/{{$episode->id}}/source" class="btn btn-secondary  mt-4">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <div class="modal" tabindex="-1" role="dialog" id="exampleModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload File</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body" id="source_file">
                            <div id="resumable-error" style="display: none">
                                Resumable not supported
                            </div>
                            <div id="upload-container" class="text-center" >
                                <button id="resumable-browse" class="btn btn-primary" data-url="{{ url('tvShow/source/upload')}}">Brows File</button>
                                <div class="progress mt-3" style="height: 25px">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%; height: 100%">75%</div>
                                </div>
                                <div class="form-group mt-4">
                                    <label for="upload_url" class="float-left">Upload URL</label>
                                    <input class="form-control" id="upload_url" type="text" name="upload_url" required>
                                </div>
                                {{--                                <div class="card-footer p-4" >--}}
                                {{--                                    <video id="videoPreview" src="" controls style="width: 100%; height: auto"></video>--}}
                                {{--                                </div>--}}
                            </div>

                        </div>
                    </div>
                    {{--                    <div class="modal-footer">--}}
                    {{--                        <button type="button" class="btn btn-primary">Save changes</button>--}}
                    {{--                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

    <script>
        // $.fn.hasAttr = function(name) {
        //     return this.attr(name) !== undefined;
        // };

        let browseFile = $('#resumable-browse');
        let resumable = new Resumable({
            target: browseFile.data('url'),
            chunkSize: 1 * 1024 * 1024, // 1MB
            simultaneousUploads: 3,
            query:{_token:'{{ csrf_token() }}'} ,// CSRF token
            headers: {
                'Accept' : 'application/json'
            },
            testChunks: false,
            throttleProgressCallbacks: 1,
        });


        resumable.assignBrowse(browseFile[0]);

        resumable.on('fileAdded', function (file) { // trigger when file picked
            showProgress();
            resumable.upload() // to actually start uploading.
        });

        resumable.on('fileProgress', function (file) { // trigger when file progress update
            updateProgress(Math.floor(file.progress() * 100));
        });

        resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
            response = JSON.parse(response)
            $('#upload_url').val(response.path);
            $('#source_url').attr('value', response.path);
            console.log(response);
        });

        resumable.on('fileError', function (file, response) { // trigger when there is any error
            alert('file uploading error.')
        });


        let progress = $('.progress');
        progress.hide();
        function showProgress() {
            progress.find('.progress-bar').css('width', '0%');
            progress.find('.progress-bar').html('0%');
            progress.find('.progress-bar').removeClass('bg-success');
            progress.show();
        }

        function updateProgress(value) {
            progress.find('.progress-bar').css('width', `${value}%`)
            progress.find('.progress-bar').html(`${value}%`)
        }

        function hideProgress() {
            progress.hide();
        }

        $(document).ready(function(){
            $("#type option[value='{{$source->type}}']").attr('selected', 'selected');
            let btnUploadFile = $('#btn-upload-file');
            btnUploadFile.hide();
            let typeSelect = $('#type');
            typeSelect.on('change', function(){
                if($(this).val() === 'FILE') {
                    btnUploadFile.show();
                }else {
                    btnUploadFile.hide();
                }
            })
        });
    </script>
@stop
