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
                    <input id="searchMovie" type="text" placeholder="Search Here">
                    <ion-icon name="search-outline"></ion-icon>
                    <div id="loading-spinner" class="invisible" style="transform: translateY(-50%);position: absolute;top: 50%;right: 8px;scale: 0.9;">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </label>
            </div>
            <!-- User Image -->
            <div class="user">
                <img src="{{url('/images/avatar_default.png')}}" alt="" >
            </div>
        </div>

        <!--  cards -->

        <div class="container">
            <div class="row flex-center">
                <a href="/tvShow" class="col text-decoration-none">
                    <div class="card m-2 bg-primary p-2">
                        <div class="card-body d-flex justify-content-center align-content-center text-white">
                            <ion-icon name="refresh-outline" style="font-size: 32px;"></ion-icon>
                            <span class="font-weight-bold ml-1" style="font-size: 24px;">Refresh</span>
                        </div>
                    </div>
                </a>
                <a href="#" class="col text-decoration-none">
                    <div class="card m-2 bg-info p-2">
                        <div class="card-body d-flex justify-content-center align-content-center text-white">
                            <ion-icon name="tv-outline" style="font-size: 32px; margin-right: 5px;"></ion-icon>
                            <span class="font-weight-bold ml-1" style="font-size: 24px;"> {{$total_tvShow}} TV Show</span>
                        </div>
                    </div>
                </a>
                <a href="/tvShow/create" class="col text-decoration-none">
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

            </div>

        </div>
        <div class="d-flex justify-content-center">
            <nav aria-label="Page navigation example">
                <ul id="pagination-news-posts" class="pagination">
                </ul>
            </nav>
        </div>
    </div>

    <script>

        let deleteId = null;

        function getItems(page) {
            var dataHtml = ``;
            var pagination_news_posts = document.getElementById('pagination-news-posts');
            $.ajax({
                url: "http://localhost:8000/" + "tvShow/getTvShow",
                method: "POST",
                data: {
                    page: page,
                    limit: 20,
                },

                dataType: "json",
                success: function (data) {
                    console.log(data);
                    if (data.data.data.length > 0) {
                        for (var count = 0; count < data.data.data.length; count++) {
                            dataHtml += `<div class="col-3 my-3">
                                            <div class="card">
                                                <img class="card-img-top" src="` + data.data.data[count].img_thumbnail + `" alt="Card image cap" style="height: 200px; object-fit: cover">
                                                <div class="card-body">
                                                    <h5 class="card-title text-center" style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;">` + data.data.data[count].title + `</h5>
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <a href=" /tvShow/` + data.data.data[count].slug + `/edit" class="btn btn-warning mr-2"><ion-icon name="build-outline"></ion-icon></a>
                                                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="showData(` + data.data.data[count].id + `)"><ion-icon name="trash-outline"></ion-icon></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                        }

                        if (data.data.total > 20) {
                            var countPage = Math.ceil(data.data.total / 20);
                            var pagination = ``;

                            if (page > 1) {
                                pagination += `<li class="page-item" onclick="getItems(` + (page - 1) + `)">
                                                    <a class="page-link" href="#" aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                </li>`;

                            } else {
                                pagination += `<li class="page-item disabled">
                                                   <span class="page-link">Previous</span>
                                               </li>`;
                            }

                            let loadLeft = false;
                            let loadRight = false;
                            for (let i = 1; i <= countPage; i++) {
                                if (i === 1 || i === countPage) {
                                    if (page === i) {
                                        pagination += `<li class="page-item active" onclick="getItems(` + i + `)"><a class="page-link" href="#">` + i + `</a></li>`;
                                    } else {
                                        pagination += `<li class="page-item" onclick="getItems(` + i + `)"><a class="page-link" href="#">` + i + `</a></li>`;
                                    }
                                } else {
                                    if (i >= page - 1 && i <= page + 1) {
                                        if (page === i) {
                                            pagination += `<li class="page-item active" onclick="getItems(` + i + `)"><a class="page-link" href="#">` + i + `</a></li>`;
                                        } else {
                                            pagination += `<li class="page-item" onclick="getItems(` + i + `)"><a class="page-link" href="#">` + i + `</a></li>`;
                                        }
                                    } else {
                                        if (i < page - 1) {
                                            if (!loadLeft) {
                                                pagination += `<li class="page-item"><a class="page-link" href="#">...</a></li>`;
                                                loadLeft = true;
                                                i = page - 3;
                                            }
                                        }
                                        if (i > page + 1) {
                                            if (!loadRight) {
                                                pagination += `<li class="page-item"><a class="page-link" href="#">...</a></li>`;
                                                loadRight = true;
                                                i = countPage - 1;
                                            }
                                        }
                                    }
                                }
                            }

                            if (page < countPage) {
                                pagination += `<li class="page-item" onclick="getItems(` + (page + 1) + `)">
                                                 <a class="page-link" href="#" aria-label="Next">
                                                     <span aria-hidden="true">&raquo;</span>
                                                     <span class="sr-only">Next</span>
                                                 </a>
                                             </li>`;
                            } else {
                                pagination += `<li class="page-item disabled" onclick="getItems(` + (page + 1) + `)">
                                                 <span class="page-link">Next</span>
                                             </li>`;
                            }
                            pagination_news_posts.innerHTML = pagination;
                        } else {
                            pagination_news_posts.innerHTML = '';
                        }
                    } else {
                        pagination_news_posts.innerHTML = '';
                    }

                    let news_container = document.getElementById('news-container');
                    news_container.innerHTML = dataHtml;
                }, error() {
                }
            });
        }

        function showData(deleteMovieId) {
            deleteId = deleteMovieId;
        }

        function search(keyword) {
            var dataHtml = ``;
            var pagination_news_posts = document.getElementById('pagination-news-posts');
            $.ajax({
                url: "http://localhost:8000/" + "tvShow/search",
                method: "POST",
                data: {
                    keyword: keyword,
                },
                dataType: "json",
                beforeSend: function() {
                    $('#loading-spinner').toggleClass('invisible');
                },
                success: function (data) {
                    console.log(data);
                    for (var count = 0; count < data.data.data.length; count++) {
                        dataHtml += `<div class="col-3 my-3">
                                            <div class="card">
                                                <img class="card-img-top" src="` + data.data.data[count].img_thumbnail + `" alt="Card image cap" style="height: 200px; object-fit: cover">
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">` + data.data.data[count].title + `</h5>
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <a href=" /tvShow/` + data.data.data[count].slug + `/edit" class="btn btn-warning mr-2"><ion-icon name="build-outline"></ion-icon></a>
                                                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="showData(` + data.data.data[count].id + `)"><ion-icon name="trash-outline"></ion-icon></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                    }
                    let news_container = document.getElementById('news-container');
                    news_container.innerHTML = dataHtml;
                    pagination_news_posts.innerHTML = '';
                }, error() {
                },
                complete: function(){
                    $('#loading-spinner').toggleClass('invisible');
                }
            });
        }


        $(document).ready(function () {
            getItems(1);

            $('#loading-spinner').hide();


            $('#btn-delete-movie').on('click', function () {
                $.ajax({
                    url: "http://localhost:8000/" + "movie/delete/" + deleteId,
                    method: "POST",
                    dataType: "json",
                    success: function () {
                        $('#deleteModal').modal('toggle');
                        getItems(1);
                    }
                })
            });
            let searchBar = $('#searchMovie');
            searchBar.bind("enterKey",function(e){
                search(searchBar.val())
            });
            searchBar.keyup(function(e){
                if(e.keyCode === 13)
                {
                    $(this).trigger("enterKey");
                }
            });
        });

    </script>


    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Movie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do You Want To Delete This Movie?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="btn-delete-movie">Delete</button>
                </div>
            </div>
        </div>
    </div>

@stop
