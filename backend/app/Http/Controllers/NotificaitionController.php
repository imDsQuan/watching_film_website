<?php

namespace App\Http\Controllers;

use App\Events\PublicNotification;
use App\Jobs\UploadImageToS3;
use App\Models\User;
use App\Notifications\CommonNotification;
use App\Notifications\PublicNoti;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class NotificaitionController extends Controller
{

    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {

        $lstUser = $this->userRepo->getAll()->toArray();
        return view('pages.notification.index',
            [
                'title' => 'Send Notifcation',
                'lstUser' => $lstUser,
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
        if($request->type == '2') {
            $notify = [
                'title' => $request->title,
                'message' => $request->message,
                'user_id' => $request->user_id,
                'image'=> $this->getUrlUploadS3($request, "file")
            ];

            $user = User::find($request->user_id);
            $user->notify(new CommonNotification($notify));
            event(new \App\Events\CommonNotification('Test Notification', $notify, $user));
        } else {
            $notify = [
                'title' => $request->title,
                'message' => $request->message,
                'image'=> $this->getUrlUploadS3($request, "file")
            ];

            $users = User::all();
            Notification::send($users, new PublicNoti($notify));
            event(new PublicNotification('Test Notification', $notify));
        }

        return redirect('/notification');
    }


    public function getUrlUploadS3(Request $request, $name)
    {
        $file = $request->file($name);
        if ($file !== null) {
            $fileName = $file->getClientOriginalName().Carbon::now()->timestamp;
            $filePath = Storage::putFileAs('files/images', $file, $fileName);
            UploadImageToS3::dispatch($fileName, $filePath);
            return env('AWS_URL').'/images/'.$fileName;
        }

        return '';

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
