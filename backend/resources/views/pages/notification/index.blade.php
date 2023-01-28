@extends('layouts.default')

@section('content')

    <style>
        .select-menu {
            /*width: 380px;*/
            /*margin: 140px auto;*/
            display: none;
        }

        .select-menu .select-btn {
            display: flex;
            height: 55px;
            background: #fff;
            padding: 20px;
            font-size: 18px;
            font-weight: 400;
            border-radius: 8px;
            align-items: center;
            cursor: pointer;
            justify-content: space-between;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .select-btn i {
            font-size: 25px;
            transition: 0.3s;
        }

        .select-menu.active .select-btn i {
            transform: rotate(-180deg);
        }

        .select-menu .options {
            position: relative;
            padding: 20px;
            margin-top: 10px;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
            display: none;
            height: 180px;
            overflow-y: auto;
        }

        .select-menu.active .options {
            display: block;
        }

        .options .option {
            display: flex;
            height: 55px;
            cursor: pointer;
            padding: 0 16px;
            border-radius: 8px;
            align-items: center;
            background: #fff;
        }

        .options .option:hover {
            background: #F2F2F2;
        }

        .option i {
            font-size: 25px;
            margin-right: 12px;
        }

        .option .img{
            width: 40px;
            height: 40px;
            overflow: hidden;
            border-radius: 50%;
            margin-right: 10px;
        }

        .option .img img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .option .option-text {
            font-size: 18px;
            color: #333;
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
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-start">
                    <ion-icon name="people-outline" style="font-size: 32px;"></ion-icon>
                    <div class="font-weight-bold ml-2" style="font-size: 32px;">Send Notification</div>
                </div>
                <div class="card-body">
                    <form action="/notification" method="POST" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="type">Notification Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="1">Send Broadcast</option>
                                <option value="2">Send To User</option>
                            </select>
                        </div>
                        <div class="select-menu">
                            <div class="select-btn">
                                <span class="sBtn-text">Select your option</span>
                                <i class="bx bx-chevron-down"></i>
                            </div>

                            <ul class="options">
                                @foreach($lstUser as $user)
                                    <li class="option">
                                        <div class="img">
                                            <img src="{{$user['image']}}" alt="">
                                        </div>
                                        <span class="option-text">{{$user['full_name']}}</span>
                                        <input type="text" class="id" value="{{$user['id']}}" hidden>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="form-group">
                            <label for="title">Notification Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Notification Messgae</label>
                            <input type="text" class="form-control" id="message" name="message" required>
                        </div>
                        <input type="text" class="form-control" id="user_id" name="user_id" hidden>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Image (Optional)</label>
                            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="file">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="/genre" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>

        </div>

        <script>
            const optionMenu = document.querySelector(".select-menu"),
                selectBtn = optionMenu.querySelector(".select-btn"),
                options = optionMenu.querySelectorAll(".option"),
                sBtn_text = optionMenu.querySelector(".sBtn-text"),
                typeOption = document.querySelector("#type"),
                userIdInput = document.querySelector("#user_id");

            selectBtn.addEventListener("click", () => optionMenu.classList.toggle("active"));

            typeOption.addEventListener("change", () => {
                if(typeOption.value == 1) {
                    optionMenu.style.display = 'none';
                    userIdInput.value = null;
                    sBtn_text.innerText = "Select your option";
                    console.log(userIdInput.value);
                } else {
                    optionMenu.style.display = 'block';
                    console.log(userIdInput.value);
                }
            });

            options.forEach(option => {
                option.addEventListener("click", () => {
                    let selectedOption = option.querySelector(".option-text").innerText;
                    sBtn_text.innerText = selectedOption;
                    let user_id = option.querySelector(".id").value;
                    console.log(user_id);
                    userIdInput.value = user_id;
                    optionMenu.classList.remove("active");
                });
            });


        </script>

@stop
