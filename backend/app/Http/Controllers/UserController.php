<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\SubscriptionRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $userRepo;
    protected $subscriptionRepo;

    public function __construct(UserRepository $userRepo, SubscriptionRepository $subscriptionRepo)
    {
        $this->userRepo = $userRepo;
        $this->subscriptionRepo = $subscriptionRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $lstUser = $this->userRepo->getAll()->toArray();
        foreach($lstUser as &$user) {
            $user['subscription'] = $this->subscriptionRepo->getLastSubByUserId($user['id']);
        }
        return view('pages.user.index', [
            'title' => 'User Manager',
            'totalUser' => $this->userRepo->total(),
            'listUser' => $lstUser,
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

    public function getNotification(Request $request)
    {
        $user = User::find($request->user_id);
        return $user->unreadNotifications;
    }

    public function markAllAsRead(Request $request) {
        $user = User::find($request->user_id);
        $user->unreadNotifications->markAsRead();
        return $this->responseData();

    }
}
