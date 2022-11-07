<?php

namespace App\Http\Controllers;

use App\Jobs\UploadImageToS3;
use App\Repositories\ActorRepository;
use App\Repositories\MediaRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActorController extends Controller
{

    protected $actorRepo;
    protected $mediaRepo;

    public function __construct(ActorRepository $actorRepo, MediaRepository $mediaRepo)
    {
        $this->actorRepo = $actorRepo;
        $this->mediaRepo = $mediaRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.actor.index',
            [
                'title' => 'Actor Manager',
                'total_actor' => $this->actorRepo->total(),
            ]);
    }

    public function getActor(Request $request) {
        $limit     = $request->input('limit', 1);
        $page      = $request->input('page', 1);
        $offset = ($page - 1) * $limit;

        $listActor = $this->actorRepo->paginate($limit, $offset)->toArray();
        $total = $this->actorRepo->total();
        foreach ($listActor as &$actor) {
            $media = $this->mediaRepo->find($actor['media_id']);
            $actor['img_thumbnail'] = $media['url'];
        }

        $this->message = 'Lấy bài viêt thành công';
        $this->status  = 'success';

        $data          = [
            'data'  => $listActor,
            'total' => $total,
        ];
        return $this->responseData($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.actor.create',
            [
                'title' => 'Create Actor',
            ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->hasFile('file-thumbnail')) {
            $mediaCreated = $this->getMediaCreated($request);

            $actor = array(
                'name' => $request->name,
                'media_id' => $mediaCreated->id,
                'bio' => $request->bio,
                'type' => $request->type,
                'born' => $request->born,
                'height' => $request->height,
                'slug' => Str::slug($request->name).Carbon::now()->timestamp,
            );

            $this->actorRepo->create($actor);

            return redirect('/actor');
        }
        return view('pages.actor.index',
            [
                'title' => 'Actor Manager',
                'total_actor' => $this->actorRepo->total(),
            ]);
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $actor = $this->actorRepo->getActorBySlug($slug);
        $media = $this->mediaRepo->find($actor->media_id);
        $actor->img_thumbnail = $media['url'];
        return view('pages.actor.edit',
            [
                'title' => 'Edit Actor',
                'actor' => $actor,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
//        dd($request);
        if ($request->hasFile('file-thumbnail')) {

            $mediaCreated = $this->getMediaCreated($request);

            $actor = array(
                'name' => $request->name,
                'media_id' => $mediaCreated->id,
                'bio' => $request->bio,
                'type' => $request->type,
                'born' => $request->born,
                'height' => $request->height,
            );

        } else {
            $actor = array(
                'name' => $request->name,
                'bio' => $request->bio,
                'type' => $request->type,
                'born' => $request->born,
                'height' => $request->height,
            );

        }

        $this->actorRepo->update($request->id, $actor);

        return redirect('/actor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $actor = $this->actorRepo->find($id);

        $this->mediaRepo->delete($actor['media_id']);

        $this->actorRepo->delete($id);

        return $this->responseData();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getMediaCreated(Request $request)
    {
        $file = $request->file('file-thumbnail');
        $extension = $file->getClientOriginalExtension();
        $type = $file->getMimeType();
        $fileName = $file->getFilename().Carbon::now()->timestamp;

        $filePath = Storage::putFileAs('files/images', $file, $fileName);

        $media = array(
            'title' => basename($fileName),
            'url' => env('AWS_URL').'/images/'.$fileName,
            'extension' => $extension,
            'date' => Carbon::now(),
            'type' => $type,
            'enabled' => true,
        );

        UploadImageToS3::dispatch($fileName, $filePath)->delay(Carbon::now()->addSecond(10));

        return $this->mediaRepo->create($media);
    }

    public function search(Request $request) {
        $keyword = $request->keyword;
        $listActor = $this->actorRepo->getActorByKeyword($keyword)->toArray();
        $total = count($listActor);
        foreach ($listActor as &$actor) {
            $media = $this->mediaRepo->find($actor->media_id);
            $actor->img_thumbnail = $media['url'];
        }

        $this->message = 'Lấy bài viết thành công';
        $this->status  = 'success';

        $data          = [
            'data'  => $listActor,
            'total' => $total,
        ];
        return $this->responseData($data);
    }

    public function getPopular()
    {
        $lstActor = $this->actorRepo->getPopular();
        foreach ($lstActor as &$actor) {
            $media = $this->mediaRepo->find($actor->media_id);
            $actor->img = $media['url'];
        }
        return $lstActor;
    }

}
