<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Repositories\PackRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\PosterRepository;
use App\Repositories\SubscriptionRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    protected $posterRepo;
    protected $userRepo;
    protected $subscriptionRepo;
    protected $packRepo;
    protected $paymentRepo;

    public function __construct(PosterRepository $posterRepo,
                                UserRepository $userRepo,
                                SubscriptionRepository $subscriptionRepo,
                                PackRepository $packRepo,
                                PaymentRepository $paymentRepo
                                )
    {
        $this->posterRepo = $posterRepo;
        $this->userRepo = $userRepo;
        $this->subscriptionRepo = $subscriptionRepo;
        $this->packRepo = $packRepo;
        $this->paymentRepo = $paymentRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $totalMovie = $this->posterRepo->totalMovie();
        $totalTvShow = $this->posterRepo->totalTvShow();
        $totalUser = $this->userRepo->total();
        $totalEarning = $this->subscriptionRepo->totalEarning();

        $lstRecentSubscription = $this->subscriptionRepo->getRecent(10);

        foreach ($lstRecentSubscription as &$subscription) {
            $subscription->user = $this->userRepo->find($subscription->user_id);
            $subscription->pack = $this->packRepo->find($subscription->pack_id);
            $subscription->payment = $this->paymentRepo->find($subscription->payment_id);
        }

        $lstRecentCustomer = $this->userRepo->getRecent(6);


        return view('pages.home',[
            'title' => 'Dashboard',
            'totalMovie' => $totalMovie,
            'totalTvShow' => $totalTvShow,
            'totalUser' => $totalUser,
            'totalEarning' => $totalEarning,
            'lstRecentSubscription' =>$lstRecentSubscription,
            'lstRecentCustomer' => $lstRecentCustomer
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
