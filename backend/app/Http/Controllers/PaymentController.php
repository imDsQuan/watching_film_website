<?php

namespace App\Http\Controllers;

use App\Repositories\PackRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\SubscriptionRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentRepo;
    protected $subRepo;
    protected $userRepo;
    protected $packRepo;

    public function __construct(PaymentRepository $paymentRepo,
                                SubscriptionRepository $subRepo,
                                UserRepository $userRepo,
                                PackRepository $packRepo)
    {
        $this->paymentRepo = $paymentRepo;
        $this->subRepo = $subRepo;
        $this->userRepo = $userRepo;
        $this->packRepo = $packRepo;
    }

    public function checkoutPaypal(Request $request)
    {
        $payer = $request->payer;
        $user = $request->user;
        $pack = $request->pack;
        $purchase_units = $request->purchase_units;

        $payment = $this->paymentRepo->create([
            'payer_id' => $payer['payer_id'],
            'payer_email' => $payer['email_address'],
            'amount' => $purchase_units[0]['amount']['value'],
            'currency' => $purchase_units[0]['amount']['currency_code'],
            'payment_status' => $request->status,
            'user_id' => $user['id'],
        ]);

        $subscription = $this->subRepo->create([
            'user_id' => $user['id'],
            'pack_id' => $pack['id'],
            'payment_id' => $payment['id'],
            'duration' => $pack['duration'],
            'method' => 'PAYPAL',
            'status' => $request->status,
            'currency' => $purchase_units[0]['amount']['currency_code'],
            'price' => $purchase_units[0]['amount']['value'],
            'email' => $payer['email_address'],
            'start_date' => Carbon::now(),
            'expired_date' => Carbon::now()->addMonth(1),
        ]);

        $data = [
            'payment' => $payment,
            'subscription' => $subscription,
            'pack' => $pack,
        ];
        return $this->responseData($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $lstSubscription = $this->subRepo->getAll()->toArray();
        foreach($lstSubscription as &$subscription) {
            $subscription['user'] = $this->userRepo->find($subscription['user_id']);
            $subscription['pack'] = $this->packRepo->find($subscription['pack_id']);
            $subscription['payment'] = $this->paymentRepo->find($subscription['payment_id']);
        }

        return view('pages.payment.index', [
            'title' => 'Payment Manager',
            'totalPayment' => $this->paymentRepo->total(),
            'listSub' => $lstSubscription,
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
