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

        <!--  cards -->

        <div class="cardBox">
            <div class="cardElement">
                <div class="">
                    <div class="numbers">{{$totalMovie}}</div>
                    <div class="cardName">Movie</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="videocam-outline"></ion-icon>
                </div>
            </div>
            <div class="cardElement">
                <div class="">
                    <div class="numbers">{{$totalTvShow}}</div>
                    <div class="cardName">TvShow</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="tv-outline"></ion-icon>
                </div>
            </div>
            <div class="cardElement">
                <div class="">
                    <div class="numbers">{{$totalUser}}</div>
                    <div class="cardName">User</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="people-outline"></ion-icon>
                </div>
            </div>
            <div class="cardElement">
                <div class="">
                    <div class="numbers">${{$totalEarning}}</div>
                    <div class="cardName">Earning</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="cash-outline"></ion-icon>
                </div>
            </div>
        </div>

        <!-- order detail list -->

        <div class="details">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Recent Subscription</h2>
                    <a href="/payment" class="btn-view"> View All</a>
                </div>
                <table>
                    <thead>
                    <td>Name</td>
                    <td>Price</td>
                    <td>Pack</td>
                    <td>Status</td>
                    </thead>
                    <tbody>
                    @foreach($lstRecentSubscription as $sub)
                        <tr>
                            <td>{{$sub->user->full_name}}</td>
                            <td>{{$sub->price}}</td>
                            <td>{{$sub->pack->title}}</td>
                            @if($sub->status === 'COMPLETED')
                                <td><span class="status delivered">{{$sub->status}}</span></td>
                            @else
                                <td><span class="status pending">{{$sub->status}}</span></td>
                            @endif
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

            <!-- New Customer -->

            <div class="recentCustomers">
                <div class="cardHeader">
                    <h2>Recent Customer</h2>
                </div>
                <table>
                    @foreach($lstRecentCustomer as $user)
                        <tr>
                            <td width="60px">
                                <div class="imgBx">
                                    <img src="{{$user->image}}" alt="">
                                </div>
                            </td>
                            <td>
                                <h4>{{$user->full_name}} <br> <span>{{$user->email}}</span></h4>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

        </div>
    </div>

@stop
