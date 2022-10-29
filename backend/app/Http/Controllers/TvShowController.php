<?php

namespace App\Http\Controllers;

use App\Jobs\UploadImageToS3;
use App\Repositories\ActorRepository;
use App\Repositories\GenreRepository;
use App\Repositories\MediaRepository;
use App\Repositories\PosterGenresRepository;
use App\Repositories\PosterRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SourceRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TvShowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $genreRepo;
    private $mediaRepo;
    private $posterRepo;
    private $posterGenresRepo;
    private $sourceRepo;
    private $actorRepo;
    private $roleRepo;

    public function __construct(GenreRepository $genreRepo,
                                MediaRepository $mediaRepo,
                                PosterRepository $posterRepo,
                                PosterGenresRepository $posterGenresRepo,
                                SourceRepository $sourceRepo,
                                ActorRepository $actorRepo,
                                RoleRepository $roleRepo)
    {
        $this->genreRepo = $genreRepo;
        $this->mediaRepo = $mediaRepo;
        $this->posterRepo = $posterRepo;
        $this->posterGenresRepo =$posterGenresRepo;
        $this->sourceRepo = $sourceRepo;
        $this->actorRepo = $actorRepo;
        $this->roleRepo = $roleRepo;
    }

    public function index()
    {
        return view('pages.tvShow.index',
            [
                'title' => 'TV Show Manager',
                'total_tvShow' => $this->posterRepo->totalTvShow(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.tvShow.create', [
            'title' => 'Create TV Show',
            'listGenres' => $this->genreRepo->getAll(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $thumbnail = null;
        $cover = null;

        if ($request->hasFile('file-thumbnail')) {
            $thumbnail = $this->getMediaCreated($request, 'file-thumbnail');
        }

        if ($request->hasFile('file-thumbnail')) {
            $cover = $this->getMediaCreated($request, 'file-cover');
        }

        $tvShow = array(
            'title' => $request->title,
            'poster_id' => $thumbnail['id'],
            'cover_id' => $cover['id'],
            'label' => $request->label,
            'subLabel' => $request->subLabel,
            'description' => $request->description,
            'rating' => 0,
            'views' => 0,
            'comment' => 0,
            'enable'=> $request->enable,
            'year' => $request->year,
            'imdb' => $request->imdb,
            'duration' => $request->duration,
            'type' => $request->type,
            'slug' => Str::slug($request->title).Carbon::now()->timestamp,
        );

        $tvShowNew = $this->posterRepo->create($tvShow);

        $listGenre = explode(',', $request->listGenre);

        foreach ($listGenre as $genre) {
            $this->posterGenresRepo->create(array(
                'poster_id' => $tvShowNew['id'],
                'genre_id' => $genre,
            ));
        }

        return redirect('/tvShow');

    }

    public function getTvShow(Request $request){
        $limit     = $request->input('limit', 1);
        $page      = $request->input('page', 1);
        $offset = ($page - 1) * $limit;

        $listTvShow = $this->posterRepo->paginateTvSHow($limit, $offset)->toArray();
        $total = $this->posterRepo->totalTvShow();
        foreach ($listTvShow as &$tvShow) {
            $media = $this->mediaRepo->find($tvShow->poster_id);
            $tvShow->img_thumbnail = $media['url'];
        }

        $this->message = 'Lấy bài viêt thành công';
        $this->status  = 'success';

        $data          = [
            'data'  => $listTvShow,
            'total' => $total,
        ];
        return $this->responseData($data);
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
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);
        $thumbnail = $this->mediaRepo->find($tvShow->poster_id);
        $cover = $this->mediaRepo->find($tvShow->cover_id);
        $listPostGenre = $this->posterGenresRepo->getMovieGenreId($tvShow->id)->toArray();
        $genres = array();
        foreach($listPostGenre as &$genre) {
            $genres[] = $genre->genre_id;
        }
        $tvShow->img_thumbnail = $thumbnail['url'];
        $tvShow->img_cover = $cover['url'];
        $tvShow->genres = json_encode($genres);

        return view('pages.tvShow.edit',
            [
                'title' => 'Edit TV Show',
                'tvShow' => $tvShow,
                'listGenres' => $this->genreRepo->getAll(),
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
        $thumbnail = null;
        $cover = null;

        $tvShow = array(
            'title' => $request->title,
            'label' => $request->label,
            'subLabel' => $request->subLabel,
            'description' => $request->description,
            'enable'=> $request->enable,
            'year' => $request->year,
            'imdb' => $request->imdb,
            'duration' => $request->duration,
            'type' => $request->type,
            'slug' => Str::slug($request->title).Carbon::now()->timestamp,
        );
        if ($request->hasFile('file-thumbnail')) {
            $thumbnail = $this->getMediaCreated($request, 'file-thumbnail');
            $tvShow['poster_id'] = $thumbnail['id'];
        }

        if ($request->hasFile('file-cover')) {
            $cover = $this->getMediaCreated($request, 'file-cover');
            $tvShow['cover_id'] = $cover['id'];
        }

        $listGenre = explode(',', $request->listGenre);

        foreach ($listGenre as $genre) {
            $this->posterGenresRepo->create(array(
                'poster_id' => $request->id,
                'genre_id' => $genre,
            ));
        }

        $this->posterRepo->update($request->id, $tvShow);

        return redirect('/tvShow');
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

    public function getMediaCreated(Request $request, $name)
    {
        $file = $request->file($name);
        if ($file !== null) {
            $extension = $file->getClientOriginalExtension() ?? '';
            $type = $file->getMimeType();
            $fileName = $file->getClientOriginalName().Carbon::now()->timestamp;

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

        return false;

    }

    public function indexTrailer($tvShowId)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($tvShowId);

        if (isset($tvShow->trailer_id)) {
            $trailer = $this->mediaRepo->find($tvShow->trailer_id);
            $tvShow->trailer = $trailer->url;
        } else {
            $tvShow->trailer = '';
        }

        return view('pages.tvShow.trailer.index',
            [
                'title' => 'Edit Trailer',
                'tvShow' => $tvShow,
            ]);
    }

    public function storeTrailer(Request $request, $tvShowId) {

        $trailerUrl = $this->getEmbedUrl($request->trailer_url);

        $tvShow = $this->posterRepo->getTvShowById($tvShowId);
        $media = array(
            'title' => $tvShow->title.'_trailer',
            'url' => $trailerUrl,
            'extension' => '',
            'date' => Carbon::now(),
            'type' => 'YoutubeUrl',
            'enabled' => true,
        );
        $mediaCreate = $this->mediaRepo->create($media);
        $this->posterRepo->update($tvShowId, [
            'trailer_id' => $mediaCreate['id'],
        ]);

        return redirect('/tvShow/'.$tvShow->slug.'/trailer');
    }

    public function indexCast($slug)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);

        //all actor in DB
        $listActor = $this->actorRepo->getAll()->toArray();

        //actor of the moive
        $actors = $this->actorRepo->getActorByPosterId($tvShow->id)->toArray();

        foreach($listActor as $key => $value) {
            foreach ($actors as $actor) {
                if ($value['id'] == $actor->id){
                    unset($listActor[$key]);
                }
            }
        }

        foreach ($actors as $actor) {
            $actor->img_url = $this->mediaRepo->find($actor->media_id)->url;
        }

        return view('pages.tvShow.cast.index', [
            'title' => 'Edit TV Show',
            'tvShow' => $tvShow,
            'listActor' => $listActor,
            'actors' => $actors
        ]);

    }

    public function storeCast(Request $request, $slug) {

        $tvShow = $this->posterRepo->getTvShowBySlug($slug);

        $this->roleRepo->create(array(
            'actor_id' => $request->actor_id,
            'poster_id' => $request->poster_id,
            'role' => $request->role,
            'position' => $this->roleRepo->maxPosition() + 1,
        ));
        return redirect('/tvShow/'.$tvShow->slug.'/cast');
    }

    public function editCast($slug, $roleId) {
        $role = $this->roleRepo->find($roleId);
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);
        return view('pages.tvShow.cast.edit', [
            'title' => 'Edit Role',
            'tvShow' => $tvShow,
            'role' => $role,
        ]);
    }

    public function updateCast(Request $request, $slug, $roleId) {
        $movie = $this->posterRepo->getTvShowBySlug($slug);
        $this->roleRepo->update($roleId, array(
            'role' => $request->role,
        ));

        return redirect('/tvShow/'.$movie->slug.'/cast');

    }

    public function deleteCast(Request $request, $slug, $roleId) {
//        $movie = $this->posterRepo->getMovieBySlug($slug);
        $this->roleRepo->delete($roleId);
        return $this->responseData();

    }

    public function upCast($slug, $id)
    {
        $movie = $this->posterRepo->getMovieBySlug($slug);

        $listRole = $this->roleRepo->getByPosterId($movie->id)->toArray();
        $roleUp = $this->roleRepo->find($id);
        $position = $roleUp->position;

        foreach ($listRole as $role) {
            if ($role->position == ($position - 1) && $position > 1 ){
                $this->roleRepo->update($role->id, [
                    'position' => $position,
                ]);
                $this->roleRepo->update($id, [
                    'position' => $position - 1,
                ]);
                break;
            }
        }

        return redirect('/movie/'.$movie->slug.'/cast');
    }

    public function downCast($slug, $id)
    {
        $movie = $this->posterRepo->getMovieBySlug($slug);

        $listRole = $this->roleRepo->getByPosterId($movie->id)->toArray();
        $roleDown = $this->roleRepo->find($id);
        $position = $roleDown->position;

        $maxPosition = $this->roleRepo->maxPosition();

        foreach ($listRole as $role) {
            if ($role->position == ($position + 1) && $position < $maxPosition ){
                $this->roleRepo->update($role->id, [
                    'position' => $position,
                ]);
                $this->roleRepo->update($id, [
                    'position' => $position + 1,
                ]);
                break;
            }
        }

        return redirect('/movie/'.$movie->slug.'/cast');
    }

    function getEmbedUrl($url) {
        // function for generating an embed link
        $finalUrl = '';

        if (strpos($url, 'facebook.com/') !== false) {
            // Facebook Video
            $finalUrl.='https://www.facebook.com/plugins/video.php?href='.rawurlencode($url).'&show_text=1&width=200';

        } else if(strpos($url, 'vimeo.com/') !== false) {
            // Vimeo video
            $videoId = explode("vimeo.com/", $url)[1] ?? null;
            if (strpos($videoId, '&') !== false){
                $videoId = explode("&",$videoId)[0];
            }
            $finalUrl.='https://player.vimeo.com/video/'.$videoId;

        } else if (strpos($url, 'youtube.com/') !== false) {
            // Youtube video
            $videoId = explode("v=", $url)[1] ?? null;
            if (strpos($videoId, '&') !== false){
                $videoId = explode("&",$videoId)[0];
            }
            $finalUrl.='https://www.youtube.com/embed/'.$videoId;

        } else if(strpos($url, 'youtu.be/') !== false) {
            // Youtube  video
            $videoId = explode("youtu.be/", $url)[1] ?? null;
            if (strpos($videoId, '&') !== false) {
                $videoId = explode("&",$videoId)[0];
            }
            $finalUrl.='https://www.youtube.com/embed/'.$videoId;

        } else if (strpos($url, 'dailymotion.com/') !== false) {
            // Dailymotion Video
            $videoId = explode("dailymotion.com/", $url)[1] ?? null;
            if (strpos($videoId, '&') !== false) {
                $videoId = explode("&",$videoId)[0];
            }
            $finalUrl.='https://www.dailymotion.com/embed/'.$videoId;

        } else{
            $finalUrl.=$url;
        }

        return $finalUrl;
    }

    public function indexSeason($slug)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);

        return view('pages.tvShow.season.index', [
           'title' => 'Edit Season',
           'tvShow' => $tvShow,
        ]);
    }


}
