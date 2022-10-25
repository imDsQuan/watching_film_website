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
                <img src="user.jpg" alt="" >
            </div>
        </div>

        <!--  cards -->

        <div class="cardBox">
            <div class="cardElement">
                <div class="">
                    <div class="numbers">1,504</div>
                    <div class="cardName">Daily Views</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="eye-outline"></ion-icon>
                </div>
            </div>
            <div class="cardElement">
                <div class="">
                    <div class="numbers">80</div>
                    <div class="cardName">Sales</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="cart-outline"></ion-icon>
                </div>
            </div>
            <div class="cardElement">
                <div class="">
                    <div class="numbers">284</div>
                    <div class="cardName">Comments</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="chatbubbles-outline"></ion-icon>
                </div>
            </div>
            <div class="cardElement">
                <div class="">
                    <div class="numbers">$7,482</div>
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
                    <h2>Recent Orders</h2>
                    <a href="#" class="btn-view"> View All</a>
                </div>
                <table>
                    <thead>
                    <td>Name</td>
                    <td>Price</td>
                    <td>Payment</td>
                    <td>Status</td>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Star Refrigrator</td>
                        <td> $1200</td>
                        <td>Paid</td>
                        <td><span class="status delivered">Delivered</span></td>
                    </tr>
                    <tr>
                        <td>Star Refrigrator</td>
                        <td> $1200</td>
                        <td>Paid</td>
                        <td><span class="status pending">Pending</span></td>
                    </tr>
                    <tr>
                        <td>Star Refrigrator</td>
                        <td> $1200</td>
                        <td>Paid</td>
                        <td><span class="status return">Return</span></td>
                    </tr>
                    <tr>
                        <td>Star Refrigrator</td>
                        <td> $1200</td>
                        <td>Paid</td>
                        <td><span class="status inprogress">In Progress</span></td>
                    </tr>
                    <tr>
                        <td>Star Refrigrator</td>
                        <td> $1200</td>
                        <td>Paid</td>
                        <td><span class="status delivered">Delivered</span></td>
                    </tr>
                    <tr>
                        <td>Star Refrigrator</td>
                        <td> $1200</td>
                        <td>Paid</td>
                        <td><span class="status delivered">Delivered</span></td>
                    </tr>
                    <tr>
                        <td>Star Refrigrator</td>
                        <td> $1200</td>
                        <td>Paid</td>
                        <td><span class="status delivered">Delivered</span></td>
                    </tr>
                    <tr>
                        <td>Star Refrigrator</td>
                        <td> $1200</td>
                        <td>Paid</td>
                        <td><span class="status delivered">Delivered</span></td>
                    </tr>
                    <tr>
                        <td>Star Refrigrator</td>
                        <td> $1200</td>
                        <td>Paid</td>
                        <td><span class="status delivered">Delivered</span></td>
                    </tr>
                    <tr>
                        <td>Star Refrigrator</td>
                        <td> $1200</td>
                        <td>Paid</td>
                        <td><span class="status delivered">Delivered</span></td>
                    </tr>
                    <tr>
                        <td>Star Refrigrator</td>
                        <td> $1200</td>
                        <td>Paid</td>
                        <td><span class="status delivered">Delivered</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- New Customer -->

            <div class="recentCustomers">
                <div class="cardHeader">
                    <h2>Recent Customer</h2>
                </div>
                <table>
                    <tr>
                        <td width="60px">
                            <div class="imgBx">
                                <img src="user.jpg" alt="">
                            </div>
                        </td>
                        <td>
                            <h4>David <br> <span>Italy</span></h4>
                        </td>
                    </tr>
                    <tr>
                        <td width="60px">
                            <div class="imgBx">
                                <img src="user.jpg" alt="">
                            </div>
                        </td>
                        <td>
                            <h4>David <br> <span>Italy</span></h4>
                        </td>
                    </tr>
                    <tr>
                        <td width="60px">
                            <div class="imgBx">
                                <img src="user.jpg" alt="">
                            </div>
                        </td>
                        <td>
                            <h4>David <br> <span>Italy</span></h4>
                        </td>
                    </tr>
                    <tr>
                        <td width="60px">
                            <div class="imgBx">
                                <img src="user.jpg" alt="">
                            </div>
                        </td>
                        <td>
                            <h4>David <br> <span>Italy</span></h4>
                        </td>
                    </tr>
                    <tr>
                        <td width="60px">
                            <div class="imgBx">
                                <img src="user.jpg" alt="">
                            </div>
                        </td>
                        <td>
                            <h4>David <br> <span>Italy</span></h4>
                        </td>
                    </tr>
                    <tr>
                        <td width="60px">
                            <div class="imgBx">
                                <img src="user.jpg" alt="">
                            </div>
                        </td>
                        <td>
                            <h4>David <br> <span>Italy</span></h4>
                        </td>
                    </tr>
                    <tr>
                        <td width="60px">
                            <div class="imgBx">
                                <img src="user.jpg" alt="">
                            </div>
                        </td>
                        <td>
                            <h4>David <br> <span>Italy</span></h4>
                        </td>
                    </tr>
                    <tr>
                        <td width="60px">
                            <div class="imgBx">
                                <img src="user.jpg" alt="">
                            </div>
                        </td>
                        <td>
                            <h4>David <br> <span>Italy</span></h4>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>

@stop
