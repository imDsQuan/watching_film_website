<?php

namespace App\Http\Controllers;

use App\Jobs\UploadImageToS3;
use App\Jobs\UploadVideoToS3;
use App\Repositories\ActorRepository;
use App\Repositories\GenreRepository;
use App\Repositories\MediaRepository;
use App\Repositories\PosterGenresRepository;
use App\Repositories\PosterRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SourceRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class MovieController extends Controller
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
        return view('pages.movie.index',
            [
                'title' => 'Movie Manager',
                'total_movie' => $this->posterRepo->totalMovie(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.movie.create', [
            'title' => 'Create Movie',
            'listGenres' => $this->genreRepo->getAll(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
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

        $movie = array(
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

        $movieNew = $this->posterRepo->create($movie);

        $listGenre = explode(',', $request->listGenre);

        foreach ($listGenre as $genre) {
            $this->posterGenresRepo->create(array(
                'poster_id' => $movieNew['id'],
                'genre_id' => $genre,
            ));
        }

        return redirect('/movie');


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
        $movie = $this->posterRepo->getMovieBySlug($slug);
        $thumbnail = $this->mediaRepo->find($movie->poster_id);
        $cover = $this->mediaRepo->find($movie->cover_id);
        $listPostGenre = $this->posterGenresRepo->getMovieGenreId($movie->id)->toArray();
        $genres = array();
        foreach($listPostGenre as &$genre) {
            $genres[] = $genre->genre_id;
        }
        $movie->img_thumbnail = $thumbnail['url'];
        $movie->img_cover = $cover['url'];
        $movie->genres = json_encode($genres);

        return view('pages.movie.edit',
            [
                'title' => 'Edit Movie',
                'movie' => $movie,
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

        $movie = array(
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
            $movie['poster_id'] = $thumbnail['id'];
        }

        if ($request->hasFile('file-cover')) {
            $cover = $this->getMediaCreated($request, 'file-cover');
            $movie['cover_id'] = $cover['id'];
        }

        $listGenre = explode(',', $request->listGenre);

        foreach ($listGenre as $genre) {
            $this->posterGenresRepo->create(array(
                'poster_id' => $request->id,
                'genre_id' => $genre,
            ));
        }

        $this->posterRepo->update($request->id, $movie);

        return redirect('/movie');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $movie = $this->posterRepo->find($id);

        $this->mediaRepo->delete($movie['poster_id']);
        $this->mediaRepo->delete($movie['cover_id']);

        $this->posterRepo->delete($id);

        return $this->responseData();
    }

    public function indexSource($slug) {
        $movie = $this->posterRepo->getMovieBySlug($slug);

        $listSource = $this->sourceRepo->getSourceByPosterId($movie->id)->toArray();

        return view('pages.movie.source.index',
            [
                'title' => 'Edit Source',
                'movie' => $movie,
                'listSource' => $listSource ?? [],
            ]);
    }

    public function createSource($movieId){

        $movie = $this->posterRepo->getMovieById($movieId);

        return view('pages.movie.source.create',
            [
                'title' => 'Edit Source',
                'movie' => $movie,
            ]);
    }

    public function editSource($movieId, $sourceId) {
        $movie = $this->posterRepo->getMovieById($movieId);

        $source = $this->sourceRepo->find($sourceId);

        return view('pages.movie.source.edit',
            [
                'title' => 'Edit Source',
                'movie' => $movie,
                'source' => $source,
            ]);
    }

    public function updateSource(Request $request, $movieId, $sourceId)
    {
        $movie_id = $request->movie_id;

        $movie = $this->posterRepo->getMovieById($movie_id);

        $source_url = null;

        if ($request->type == 'Youtube') {
            $source_url = $this->getEmbedUrl($request->source_url);
        }

        $source = array(
            'title' => $request->title,
            'quality' => $request->quality,
            'type' => $request->type,
            'url' => $source_url ?? $request->source_url,
            'poster_id' => $movie_id,
        );

        $this->sourceRepo->update($sourceId, $source);

        return redirect('/movie/'.$movie->slug.'/source');
    }

    public function uploadSourceFile(Request $request){
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            // file not uploaded
        }

        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.'.$extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName= str_replace(' ', '_', $fileName);
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name

            $disk = Storage::disk('local');
            $path = $disk->putFileAs('videos', $file, $fileName);

            // delete chunked file

            UploadVideoToS3::dispatch($path, $fileName)->delay(Carbon::now()->addSecond(10));

            unlink($file->getPathname());
            return [
                'path' => env('AWS_URL').'/'.$path,
                'filename' => storage_path('app/'.$path),
//                'abc' => storage_path('app/' . $path).$fileName,
            ];
        }

        // otherwise return percentage informatoin
        $handler = $fileReceived->handler();


        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }

    public function storeSource(Request $request)
    {

        $movie_id = $request->movie_id;

        $movie = $this->posterRepo->getMovieById($movie_id);

        $source_url = null;

        if ($request->type == 'Youtube') {
            $source_url = $this->getEmbedUrl($request->source_url);
        }

        $source = array(
            'title' => $request->title,
            'quality' => $request->quality,
            'type' => $request->type,
            'url' => $source_url ?? $request->source_url,
            'poster_id' => $movie_id,
        );

        $this->sourceRepo->create($source);

        return redirect('/movie/'.$movie->slug.'/source');

    }

    public function destroySource($movieId, $sourceId)
    {
        $movie = $this->posterRepo->getMovieById($movieId);

        $this->sourceRepo->delete($sourceId);

        return $this->responseData();
    }


    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName()); // Filename without extension
        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time()) . "." . $extension;
        return $filename;
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


    public function getMovie(Request $request){
        $limit     = $request->input('limit', 20);
        $page      = $request->input('page', 1);
        $offset = ($page - 1) * $limit;

        $listMovie = $this->posterRepo->paginateMovie($limit, $offset)->toArray();
        $total = $this->posterRepo->totalMovie();
        foreach ($listMovie as &$movie) {
            $media = $this->mediaRepo->find($movie->poster_id);
            $movie->img_thumbnail = $media['url'];
        }

        $this->message = 'Lấy bài viêt thành công';
        $this->status  = 'success';

        $data          = [
            'data'  => $listMovie,
            'total' => $total,
            'page'  => $page,
        ];
        return $this->responseData($data);
    }

    public function search(Request $request) {
        $keyword = $request->keyword;
        $listMovie = $this->posterRepo->getMovieByKeyword($keyword)->toArray();
        $total = count($listMovie);
        foreach ($listMovie as &$movie) {
            $media = $this->mediaRepo->find($movie->poster_id);
            $movie->img_thumbnail = $media['url'];
        }

        $this->message = 'Lấy bài viết thành công';
        $this->status  = 'success';

        $data          = [
            'data'  => $listMovie,
            'total' => $total,
        ];
        return $this->responseData($data);
    }

    public function indexTrailer($movieId) {
        $movie = $this->posterRepo->getMovieBySlug($movieId);

        if (isset($movie->trailer_id)) {
            $trailer = $this->mediaRepo->find($movie->trailer_id);
            $movie->trailer = $trailer->url;
        } else {
            $movie->trailer = '';
        }

        return view('pages.movie.trailer.index',
            [
                'title' => 'Edit Trailer',
                'movie' => $movie,
            ]);
    }

    public function storeTrailer(Request $request, $movieId) {

        $trailerUrl = $this->getEmbedUrl($request->trailer_url);

        $movie = $this->posterRepo->getMovieById($movieId);
        $media = array(
            'title' => $movie->title.'_trailer',
            'url' => $trailerUrl,
            'extension' => '',
            'date' => Carbon::now(),
            'type' => 'YoutubeUrl',
            'enabled' => true,
        );
        $mediaCreate = $this->mediaRepo->create($media);
        $this->posterRepo->update($movieId, [
           'trailer_id' => $mediaCreate['id'],
        ]);

        return redirect('/movie/'.$movie->slug.'/trailer');
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

    public function indexCast($slug)
    {
        $movie = $this->posterRepo->getMovieBySlug($slug);

        //all actor in DB
        $listActor = $this->actorRepo->getAll()->toArray();

        //actor of the moive
        $actors = $this->actorRepo->getActorByPosterId($movie->id)->toArray();

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

        return view('pages.movie.cast.index', [
            'title' => 'Edit Movie',
            'movie' => $movie,
            'listActor' => $listActor,
            'actors' => $actors
        ]);

    }

    public function storeCast(Request $request, $slug) {

        $movie = $this->posterRepo->getMovieBySlug($slug);

        $this->roleRepo->create(array(
            'actor_id' => $request->actor_id,
            'poster_id' => $request->poster_id,
            'role' => $request->role,
            'position' => $this->roleRepo->maxPosition() + 1,
        ));
        return redirect('/movie/'.$movie->slug.'/cast');
    }

    public function editCast($slug, $roleId) {
        $role = $this->roleRepo->find($roleId);
        $actor = $this->actorRepo->find($role->actor_id);
        $movie = $this->posterRepo->getMovieBySlug($slug);
        return view('pages.movie.cast.edit', [
            'title' => 'Edit Role',
            'movie' => $movie,
            'role' => $role,
            'actor' => $actor,
        ]);
    }

    public function updateCast(Request $request, $slug, $roleId) {
        $movie = $this->posterRepo->getMovieBySlug($slug);
        $this->roleRepo->update($roleId, array(
            'role' => $request->role,
        ));

        return redirect('/movie/'.$movie->slug.'/cast');

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

    public function getAll(){
        $listMovie = $this->posterRepo->getAllMovie();
        foreach ($listMovie as &$movie) {
            $mediaCover = $this->mediaRepo->find($movie->cover_id);
            $mediaPoster = $this->mediaRepo->find($movie->poster_id);
            $movie->coverImg = $mediaCover['url'];
            $movie->posterImg = $mediaPoster['url'];
        }

        return $listMovie;
    }

    public function getBySlug($slug)
    {
        $movie = $this->posterRepo->getMovieBySlug($slug);
        $mediaCover = $this->mediaRepo->find($movie->cover_id);
        $mediaPoster = $this->mediaRepo->find($movie->poster_id);
        $source = $this->mediaRepo->find($movie->trailer_id);
        $movie->coverImg = $mediaCover['url'];
        $movie->posterImg = $mediaPoster['url'];
        $movie->trailer = $source['url'];
        return $movie;
    }

    public function getGenresBySlug($slug)
    {
        $lstGenres = $this->posterRepo->getGenres($slug);
        return $lstGenres;
    }

    public function getCastBySlug($slug)
    {
        $lstCast = $this->posterRepo->getCast($slug);
        return $lstCast;
    }

    public function getSimilarBySlug($slug)
    {
        $listMovie = $this->posterRepo->getSimilarMovieBySlug($slug);
        foreach ($listMovie as &$movie) {
            $mediaCover = $this->mediaRepo->find($movie->cover_id);
            $mediaPoster = $this->mediaRepo->find($movie->poster_id);
            $movie->coverImg = $mediaCover['url'];
            $movie->posterImg = $mediaPoster['url'];
        }

        return $listMovie;
    }

    public function getSourceBySlug($slug)
    {
        $movie = $this->posterRepo->getMovieBySlug($slug);
        return $this->sourceRepo->getSourceByPosterId($movie->id)->toArray();
    }

    public function fakeSource(){
        $lstMovie = $this->posterRepo->getAllMovie();
        foreach($lstMovie as $movie) {
            $this->sourceRepo->create([
                'poster_id' => $movie->id,
                'type' => 'FILE',
                'url' => 'https://d14jyu72kj34fe.cloudfront.net/videos/Avatar_+The+Way+of+Water+_+Official+Trailer.mp4',
                'quality' => '1080',
                'title' => $movie->title,
                'create_at' => Carbon::now(),
            ]);

            $this->sourceRepo->create([
                'poster_id' => $movie->id,
                'type' => 'Youtube',
                'url' => 'https://www.youtube.com/embed/d9MyW72ELq0',
                'quality' => '1080',
                'title' => $movie->title,
                'create_at' => Carbon::now(),
            ]);
        }

        return $this->responseData();
    }


}
