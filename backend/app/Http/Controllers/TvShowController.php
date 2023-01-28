<?php

namespace App\Http\Controllers;

use App\Jobs\UploadImageToS3;
use App\Jobs\UploadVideoToS3;
use App\Repositories\ActorRepository;
use App\Repositories\EpisodeRepository;
use App\Repositories\GenreRepository;
use App\Repositories\MediaRepository;
use App\Repositories\PosterGenresRepository;
use App\Repositories\PosterRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\SourceRepository;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Faker\Generator;

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
    private $seasonRepo;
    private $episodeRepo;

    public function __construct(GenreRepository        $genreRepo,
                                MediaRepository        $mediaRepo,
                                PosterRepository       $posterRepo,
                                PosterGenresRepository $posterGenresRepo,
                                SourceRepository       $sourceRepo,
                                ActorRepository        $actorRepo,
                                RoleRepository         $roleRepo,
                                SeasonRepository       $seasonRepo,
                                EpisodeRepository      $episodeRepo)
    {
        $this->genreRepo = $genreRepo;
        $this->mediaRepo = $mediaRepo;
        $this->posterRepo = $posterRepo;
        $this->posterGenresRepo = $posterGenresRepo;
        $this->sourceRepo = $sourceRepo;
        $this->actorRepo = $actorRepo;
        $this->roleRepo = $roleRepo;
        $this->seasonRepo = $seasonRepo;
        $this->episodeRepo = $episodeRepo;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $thumbnail = null;
        $cover = null;

        if ($request->hasFile('file-thumbnail')) {
            $thumbnail = $this->getMediaCreated($request, 'file-thumbnail');
        }

        if ($request->hasFile('file-cover')) {
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
            'enable' => $request->enable,
            'year' => $request->year,
            'imdb' => $request->imdb,
            'duration' => $request->duration,
            'type' => $request->type,
            'slug' => Str::slug($request->title) . Carbon::now()->timestamp,
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

    public function getTvShow(Request $request)
    {
        $limit = $request->input('limit', 1);
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $limit;

        $listTvShow = $this->posterRepo->paginateTvSHow($limit, $offset)->toArray();
        $total = $this->posterRepo->totalTvShow();
        foreach ($listTvShow as &$tvShow) {
            $media = $this->mediaRepo->find($tvShow->poster_id);
            $tvShow->img_thumbnail = $media['url'];
        }

        $this->message = 'Lấy bài viêt thành công';
        $this->status = 'success';

        $data = [
            'data' => $listTvShow,
            'total' => $total,
        ];
        return $this->responseData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);
        $thumbnail = $this->mediaRepo->find($tvShow->poster_id);
        $cover = $this->mediaRepo->find($tvShow->cover_id);
        $listPostGenre = $this->posterGenresRepo->getMovieGenreId($tvShow->id)->toArray();
        $genres = array();
        foreach ($listPostGenre as &$genre) {
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
     * @param \Illuminate\Http\Request $request
     * @param int $id
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
            'enable' => $request->enable,
            'year' => $request->year,
            'imdb' => $request->imdb,
            'duration' => $request->duration,
            'type' => $request->type,
            'slug' => Str::slug($request->title) . Carbon::now()->timestamp,
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
     * @param int $id
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
            $fileName = $file->getClientOriginalName() . Carbon::now()->timestamp;

            $filePath = Storage::putFileAs('files/images', $file, $fileName);

            $media = array(
                'title' => basename($fileName),
                'url' => env('AWS_URL') . '/images/' . $fileName,
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

    public function storeTrailer(Request $request, $tvShowId)
    {

        $trailerUrl = $this->getEmbedUrl($request->trailer_url);

        $tvShow = $this->posterRepo->getTvShowById($tvShowId);
        $media = array(
            'title' => $tvShow->title . '_trailer',
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

        return redirect('/tvShow/' . $tvShow->slug . '/trailer');
    }

    public function indexCast($slug)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);

        //all actor in DB
        $listActor = $this->actorRepo->getAll()->toArray();

        //actor of the moive
        $actors = $this->actorRepo->getActorByPosterId($tvShow->id)->toArray();

        foreach ($listActor as $key => $value) {
            foreach ($actors as $actor) {
                if ($value['id'] == $actor->id) {
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

    public function storeCast(Request $request, $slug)
    {

        $tvShow = $this->posterRepo->getTvShowBySlug($slug);

        $this->roleRepo->create(array(
            'actor_id' => $request->actor_id,
            'poster_id' => $request->poster_id,
            'role' => $request->role,
            'position' => $this->roleRepo->maxPosition($request->poster_id) + 1,
        ));
        return redirect('/tvShow/' . $tvShow->slug . '/cast');
    }

    public function editCast($slug, $roleId)
    {
        $role = $this->roleRepo->find($roleId);
        $actor = $this->actorRepo->find($role->actor_id);
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);
        return view('pages.tvShow.cast.edit', [
            'title' => 'Edit Role',
            'tvShow' => $tvShow,
            'role' => $role,
            'actor' => $actor,
        ]);
    }

    public function updateCast(Request $request, $slug, $roleId)
    {
        $movie = $this->posterRepo->getTvShowBySlug($slug);
        $this->roleRepo->update($roleId, array(
            'role' => $request->role,
        ));

        return redirect('/tvShow/' . $movie->slug . '/cast');

    }

    public function deleteCast(Request $request, $slug, $roleId)
    {
//        $movie = $this->posterRepo->getMovieBySlug($slug);
        $this->roleRepo->delete($roleId);
        return $this->responseData();

    }

    public function upCast($slug, $id)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);

        $listRole = $this->roleRepo->getByPosterId($tvShow->id)->toArray();
        $roleUp = $this->roleRepo->find($id);
        $position = $roleUp->position;

        foreach ($listRole as $role) {
            if ($role->position == ($position - 1) && $position > 1) {
                $this->roleRepo->update($role->id, [
                    'position' => $position,
                ]);
                $this->roleRepo->update($id, [
                    'position' => $position - 1,
                ]);
                break;
            }
        }

        return redirect('/tvShow/' . $tvShow->slug . '/cast');
    }

    public function downCast($slug, $id)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);

        $listRole = $this->roleRepo->getByPosterId($tvShow->id)->toArray();
        $roleDown = $this->roleRepo->find($id);
        $position = $roleDown->position;

//
        $maxPosition = $this->roleRepo->maxPosition($tvShow->id);

        foreach ($listRole as $role) {
            if ($role->position == ($position + 1) && $position < $maxPosition) {
                $this->roleRepo->update($role->id, [
                    'position' => $position,
                ]);
                $this->roleRepo->update($id, [
                    'position' => $position + 1,
                ]);
                break;
            }
        }

        return redirect('/tvShow/' . $tvShow->slug . '/cast');
    }

    function getEmbedUrl($url)
    {
        // function for generating an embed link
        $finalUrl = '';

        if (strpos($url, 'facebook.com/') !== false) {
            // Facebook Video
            $finalUrl .= 'https://www.facebook.com/plugins/video.php?href=' . rawurlencode($url) . '&show_text=1&width=200';

        } else if (strpos($url, 'vimeo.com/') !== false) {
            // Vimeo video
            $videoId = explode("vimeo.com/", $url)[1] ?? null;
            if (strpos($videoId, '&') !== false) {
                $videoId = explode("&", $videoId)[0];
            }
            $finalUrl .= 'https://player.vimeo.com/video/' . $videoId;

        } else if (strpos($url, 'youtube.com/') !== false) {
            // Youtube video
            $videoId = explode("v=", $url)[1] ?? null;
            if (strpos($videoId, '&') !== false) {
                $videoId = explode("&", $videoId)[0];
            }
            $finalUrl .= 'https://www.youtube.com/embed/' . $videoId;

        } else if (strpos($url, 'youtu.be/') !== false) {
            // Youtube  video
            $videoId = explode("youtu.be/", $url)[1] ?? null;
            if (strpos($videoId, '&') !== false) {
                $videoId = explode("&", $videoId)[0];
            }
            $finalUrl .= 'https://www.youtube.com/embed/' . $videoId;

        } else if (strpos($url, 'dailymotion.com/') !== false) {
            // Dailymotion Video
            $videoId = explode("dailymotion.com/", $url)[1] ?? null;
            if (strpos($videoId, '&') !== false) {
                $videoId = explode("&", $videoId)[0];
            }
            $finalUrl .= 'https://www.dailymotion.com/embed/' . $videoId;

        } else {
            $finalUrl .= $url;
        }

        return $finalUrl;
    }

    public function indexSeason($slug)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);

        $listSeason = $this->seasonRepo->getAllSeason($tvShow->id);

        foreach ($listSeason as $season) {
            $season->listEpisode = $this->episodeRepo->getEpisodeBySeasonId($season->id);
        }

        return view('pages.tvShow.season.index', [
            'title' => 'Edit Season',
            'tvShow' => $tvShow,
            'listSeason' => $listSeason,
        ]);
    }

    public function storeSeason(Request $request, $slug)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);

        $this->seasonRepo->create([
            'poster_id' => $tvShow->id,
            'title' => $request->title,
            'position' => $this->seasonRepo->maxPosition($tvShow->id) + 1,
        ]);

        return redirect('/tvShow/' . $tvShow->slug . '/season');
    }

    public function editSeason($slug, $seasonId)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);
        $season = $this->seasonRepo->find($seasonId);

        return view('pages.tvShow.season.edit', [
            'title' => 'Edit Season',
            'tvShow' => $tvShow,
            'season' => $season,
        ]);

    }

    public function updateSeason(Request $request, $slug, $seasonId)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);

        $this->seasonRepo->update($seasonId, [
            'title' => $request->title,
        ]);

        return redirect('/tvShow/' . $tvShow->slug . '/season');


    }

    public function deleteSeason(Request $request, $slug, $seasonId)
    {
//        $tvShow = $this->posterRepo->getTvShowBySlug($slug);
        $this->seasonRepo->delete($seasonId);
        return $this->responseData();
    }

    public function upSeason($slug, $seasonId)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);
        $listSeason = $this->seasonRepo->getAllSeason($tvShow->id)->toArray();
        $seasonUp = $this->seasonRepo->find($seasonId);
        $position = $seasonUp->position;

        foreach ($listSeason as $season) {
            if ($season['position'] == ($position - 1) && $position > 1) {
                $this->seasonRepo->update($season['id'], [
                    'position' => $position,
                ]);
                $this->seasonRepo->update($seasonId, [
                    'position' => $position - 1,
                ]);
                break;
            }
        }
        return redirect('/tvShow/' . $tvShow->slug . '/season');

    }

    public function downSeason($slug, $seasonId)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);

        $listSeason = $this->seasonRepo->getAllSeason($tvShow->id);;
        $seasonDown = $this->seasonRepo->find($seasonId);
        $position = $seasonDown->position;

        $maxPosition = $this->seasonRepo->maxPosition($tvShow->id);

        foreach ($listSeason as $season) {
            if ($season['position'] == ($position + 1) && $position < $maxPosition) {
                $this->seasonRepo->update($season['id'], [
                    'position' => $position,
                ]);
                $this->seasonRepo->update($seasonId, [
                    'position' => $position + 1,
                ]);
                break;
            }
        }

        return redirect('/tvShow/' . $tvShow->slug . '/season');
    }

    public function createEpisode($slug, $seasonId)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);

        $season = $this->seasonRepo->find($seasonId);

        return view('pages.tvShow.season.episode.create', [
            'title' => 'Create Season',
            'tvShow' => $tvShow,
            'season' => $season,
        ]);

    }

    public function storeEpisode(Request $request, $slug, $seasonId)
    {
        $cover = null;

        if ($request->hasFile('file-cover')) {
            $cover = $this->getMediaCreated($request, 'file-cover');
        }

        $this->episodeRepo->create([
            'season_id' => $seasonId,
            'media_id' => $cover['id'] ?? '',
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request->duration,
            'enabled' => $request->enable ?? 0,
            'position' => $this->episodeRepo->maxPosition($seasonId) + 1,
            'views' => 0,
            'slug' => Str::slug($request->title) . Carbon::now()->timestamp,
        ]);

        return redirect('/tvShow/' . $slug . '/season');


    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $listTvShow = $this->posterRepo->getTvShowByKeyword($keyword)->toArray();
        $total = count($listTvShow);
        foreach ($listTvShow as &$tvShow) {
            $media = $this->mediaRepo->find($tvShow->poster_id);
            $tvShow->img_thumbnail = $media['url'];
        }

        $this->message = 'Lấy bài viết thành công';
        $this->status = 'success';

        $data = [
            'data' => $listTvShow,
            'total' => $total,
        ];
        return $this->responseData($data);
    }

    public function editEpisode($slug, $seasonId, $episodeId)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);

        $season = $this->seasonRepo->find($seasonId);

        $episode = $this->episodeRepo->find($episodeId);

        $media = $this->mediaRepo->find($episode->media_id);

        $episode->img_url = $media->url;

        return view('pages.tvShow.season.episode.edit', [
            'title' => 'Edit Episode',
            'tvShow' => $tvShow,
            'season' => $season,
            'episode' => $episode,
        ]);
    }

    public function updateEpisode(Request $request, $slug, $seasonId, $episodeId)
    {
        $cover = null;

        $episode = $this->episodeRepo->find($episodeId);

        if ($request->hasFile('file-cover')) {
            $cover = $this->getMediaCreated($request, 'file-cover');
        }

        $this->episodeRepo->update($episodeId, [
            'season_id' => $seasonId,
            'media_id' => $cover['id'] ?? $episode->media_id,
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request->duration,
            'enabled' => $request->enable ?? 0,
        ]);

        return redirect('/tvShow/' . $slug . '/season');
    }

    public function deleteEpisode($slug, $seasonId, $episodeId)
    {
        $this->episodeRepo->delete($episodeId);
        return $this->responseData();
    }

    public function upEpisode($slug, $seasonId, $episodeId)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);
        $listEpisode = $this->episodeRepo->getEpisodeBySeasonId($seasonId)->toArray();
        $episodeUp = $this->episodeRepo->find($episodeId);
        $position = $episodeUp->position;

        foreach ($listEpisode as $season) {
            if ($season->position == ($position - 1) && $position > 1) {
                $this->episodeRepo->update($season->id, [
                    'position' => $position,
                ]);
                $this->episodeRepo->update($episodeId, [
                    'position' => $position - 1,
                ]);
                break;
            }
        }
        return redirect('/tvShow/' . $tvShow->slug . '/season');
    }

    public function downEpisode($slug, $seasonId, $episodeId)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);

        $listEpisode = $this->episodeRepo->getAll()->toArray();
        $seasonDown = $this->episodeRepo->find($episodeId);
        $position = $seasonDown->position;

        $maxPosition = $this->episodeRepo->maxPosition($seasonId);

        foreach ($listEpisode as $episode) {
            if ($episode['position'] == ($position + 1) && $position < $maxPosition) {
                $this->episodeRepo->update($episode['id'], [
                    'position' => $position,
                ]);
                $this->episodeRepo->update($episodeId, [
                    'position' => $position + 1,
                ]);
                break;
            }
        }

        return redirect('/tvShow/' . $tvShow->slug . '/season');
    }

    public function indexSource($slug, $seasonId, $episodeId)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);
        $season = $this->seasonRepo->find($seasonId);
        $episode = $this->episodeRepo->find($episodeId);

        $listSource = $this->sourceRepo->getSourceByEpisodeId($episode->id)->toArray();


        return view('pages.tvShow.season.episode.source.index', [
            'title' => 'Edit Source',
            'tvShow' => $tvShow,
            'season' => $season,
            'episode' => $episode,
            'listSource' => $listSource,
        ]);

    }

    public function createSource($slug, $seasonId, $episodeId)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);
        $season = $this->seasonRepo->find($seasonId);
        $episode = $this->episodeRepo->find($episodeId);


        return view('pages.tvShow.season.episode.source.create', [
            'title' => 'Create Source ' . $episode->title,
            'tvShow' => $tvShow,
            'season' => $season,
            'episode' => $episode,
        ]);
    }

    public function uploadSourceFile(Request $request)
    {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            // file not uploaded
        }

        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.' . $extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName = str_replace(' ', '_', $fileName);
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name

            $disk = Storage::disk('local');
            $path = $disk->putFileAs('videos', $file, $fileName);

            // delete chunked file

            UploadVideoToS3::dispatch($path, $fileName)->delay(Carbon::now()->addSecond(10));

            unlink($file->getPathname());
            return [
                'path' => env('AWS_URL') . '/' . $path,
                'filename' => storage_path('app/' . $path),
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

    public function storeSource(Request $request, $slug, $seasonId, $episodeId)
    {
//        $tvShow = $this->posterRepo->getTvShowBySlug($slug);
//        $season = $this->seasonRepo->find($seasonId);
//        $episode = $this->episodeRepo->find($episodeId);

        $source_url = null;

        if ($request->type == 'Youtube') {
            $source_url = $this->getEmbedUrl($request->source_url);
        }

        $source = array(
            'title' => $request->title,
            'quality' => $request->quality,
            'type' => $request->type,
            'url' => $source_url ?? $request->source_url,
            'episode_id' => $episodeId,
        );

        $this->sourceRepo->create($source);

        return redirect('tvShow/' . $slug . '/season/' . $seasonId . '/episode/' . $episodeId . '/source');
    }

    public function editSource($slug, $seasonId, $episodeId, $sourceId)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);
        $season = $this->seasonRepo->find($seasonId);
        $episode = $this->episodeRepo->find($episodeId);

        $source = $this->sourceRepo->find($sourceId);

        return view('pages.tvShow.season.episode.source.edit',
            [
                'title' => 'Edit Source',
                'tvShow' => $tvShow,
                'source' => $source,
                'season' => $season,
                'episode' => $episode,
            ]);
    }

    public function updateSource(Request $request, $slug, $seasonId, $episodeId, $sourceId)
    {
        $source_url = null;

        if ($request->type == 'Youtube') {
            $source_url = $this->getEmbedUrl($request->source_url);
        }

        $source = array(
            'title' => $request->title,
            'quality' => $request->quality,
            'type' => $request->type,
            'url' => $source_url ?? $request->source_url,
            'episode_id' => $episodeId,
        );

        $this->sourceRepo->update($sourceId, $source);

        return redirect('/tvShow/' . $slug . '/season/' . $seasonId . '/episode/' . $episodeId . '/source');

    }

    public function destroySource($slug, $seasonId, $episodeId, $sourceId)
    {
        $this->sourceRepo->delete($sourceId);
        return $this->responseData();

    }

    public function fakeTvShow()
    {
        $response = Http::get('https://api.themoviedb.org/3/tv/popular', [
            'api_key' => '2f2189aa2c8d04cc9ccca4ef07c23a50',
            'page' => 3,
        ]);
        $data_movie = json_decode($response->body())->results;
        foreach ($data_movie as $movie) {

            $thumbnail = $this->mediaRepo->create(array(
                'title' => $movie->original_name,
                'url' => 'https://image.tmdb.org/t/p/original'.$movie->poster_path,
                'extension' => 'jpg',
                'date' => Carbon::now(),
                'type' => 'image/jpeg',
                'enabled' => true,
            ));

            $cover = $this->mediaRepo->create(array(
                'title' => $movie->original_name,
                'url' => 'https://image.tmdb.org/t/p/original'.$movie->backdrop_path,
                'extension' => 'jpg',
                'date' => Carbon::now(),
                'type' => 'image/jpeg',
                'enabled' => true,
            ));

            $tvCreate = array(
                'title' => $movie->original_name,
                'poster_id' => $thumbnail['id'],
                'cover_id' => $cover['id'],
                'label' => $movie->original_name,
                'subLabel' => $movie->original_name,
                'description' => $movie->overview,
                'rating' => 0,
                'views' => 0,
                'comment' => 0,
                'enable' => 1,
                'year' => explode('-', $movie->first_air_date)[0],
                'imdb' => $movie->vote_average,
                'type' => 'tvShow',
                'slug' => Str::slug($movie->original_name) . Carbon::now()->timestamp,
            );

            $tvShowNew = $this->posterRepo->create($tvCreate);

            $listGenre = array(1, 2, 3, 4, 5 ,6 ,7);
            $listRand = array_rand(array(1, 2, 3, 4, 5 ,6 ,7), 3);

            foreach ($listRand as $genre) {
                $this->posterGenresRepo->create(array(
                    'poster_id' => $tvShowNew['id'],
                    'genre_id' => $listGenre[$genre],
                ));
            }

            $res = Http::get('https://api.themoviedb.org/3/tv/'.$movie->id, [
                'api_key' => '2f2189aa2c8d04cc9ccca4ef07c23a50',
                'append_to_response' => 'episode_groups',
            ]);
            $tvshow = json_decode($res->body());
            foreach($tvshow->seasons as $season) {
                $seasonNew = $this->seasonRepo->create([
                    'poster_id' => $tvShowNew->id,
                    'title' => $season->name,
                    'position' => $this->seasonRepo->maxPosition($tvShowNew->id) + 1,
                ]);
                $resSeason = Http::get('https://api.themoviedb.org/3/tv/'.$movie->id."/season/".$season->season_number, [
                    'api_key' => '2f2189aa2c8d04cc9ccca4ef07c23a50',
                    'append_to_response' => 'episode_groups',
                ]);
                $lstEpisodes = json_decode($resSeason->body())->episodes;
                foreach($lstEpisodes as $episode) {
                    $coverEp = $this->mediaRepo->create(array(
                        'title' => $episode->name,
                        'url' => 'https://image.tmdb.org/t/p/original'.$episode->still_path,
                        'extension' => 'jpg',
                        'date' => Carbon::now(),
                        'type' => 'image/jpeg',
                        'enabled' => true,
                    ));
                    $this->episodeRepo->create([
                        'season_id' => $seasonNew->id,
                        'media_id' => $coverEp['id'] ?? '',
                        'title' => $episode->name,
                        'description' => $episode->overview,
                        'duration' => '40',
                        'enabled' => 1,
                        'position' => $this->episodeRepo->maxPosition($seasonNew->id) + 1,
                        'views' => 0,
                        'slug' => Str::slug($episode->name) . Carbon::now()->timestamp,
                    ]);
                }

            }
        }
    }

    public function getAll() {
        $listTvShow = $this->posterRepo->getAllTvShow();
        foreach ($listTvShow as &$tvShow) {
            $mediaCover = $this->mediaRepo->find($tvShow->cover_id);
            $mediaPoster = $this->mediaRepo->find($tvShow->poster_id);
            $tvShow->coverImg = $mediaCover['url'];
            $tvShow->posterImg = $mediaPoster['url'];
            $tvShow->genre = $this->posterGenresRepo->getMovieGenreId($tvShow->id)->toArray();
        }

        return $listTvShow;
    }

    public function getBySlug($slug)
    {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);
        $mediaCover = $this->mediaRepo->find($tvShow->cover_id);
        $mediaPoster = $this->mediaRepo->find($tvShow->poster_id);
        $source = $this->mediaRepo->find($tvShow->trailer_id);
        $tvShow->coverImg = $mediaCover['url'];
        $tvShow->posterImg = $mediaPoster['url'];
        $tvShow->trailer = $source['url'];
        return $tvShow;
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
        $listTvShow = $this->posterRepo->getSimilarTvShowBySlug($slug);
        foreach ($listTvShow as &$tvShow) {
            $mediaCover = $this->mediaRepo->find($tvShow->cover_id);
            $mediaPoster = $this->mediaRepo->find($tvShow->poster_id);
            $tvShow->coverImg = $mediaCover['url'];
            $tvShow->posterImg = $mediaPoster['url'];
        }
        return $listTvShow;
    }

    public function getSeasonBySlug($slug) {
        $tvShow = $this->posterRepo->getTvShowBySlug($slug);
        $lstSeason = $this->seasonRepo->getSeasons($tvShow->id);
        foreach($lstSeason as &$season) {
            $season->episode = $this->episodeRepo->getEpisodeBySeasonId($season->id);
        }
        return $lstSeason;
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function fakeActor() {
        $faker = Container::getInstance()->make(Generator::class);
        $lstTV = $this->posterRepo->getAllTvShow();
        $lstActor = $this->actorRepo->getAll()->toArray();
        foreach($lstTV as $tv) {
            $rand_number = rand(10, 15);
            $lstRandId = array_rand($lstActor, $rand_number);
            $i = 0;
            foreach($lstRandId as $id) {
                $this->roleRepo->create([
                    'actor_id' => $lstActor[$id]['id'],
                    'poster_id' => $tv->id,
                    'role' => $faker->name,
                    'position' => $i + 1,
                ]);
            }
            $i = 0;
        }
        return $this->responseData();

    }

    public function fakeSourceTV()
    {
        $lsEpisode = $this->episodeRepo->getAll()->toArray();
        foreach($lsEpisode as $movie) {
            $this->sourceRepo->create([
                'episode_id' => $movie['id'],
                'type' => 'FILE',
                'url' => 'https://d14jyu72kj34fe.cloudfront.net/videos/Avatar_+The+Way+of+Water+_+Official+Trailer.mp4',
                'quality' => '1080',
                'title' => $movie['title'],
                'create_at' => Carbon::now(),
            ]);

            $this->sourceRepo->create([
                'episode_id' => $movie['id'],
                'type' => 'Youtube',
                'url' => 'https://www.youtube.com/embed/d9MyW72ELq0',
                'quality' => '1080',
                'title' => $movie['title'],
                'create_at' => Carbon::now(),
            ]);
        }

        return $this->responseData();
    }


    public function getSourceBySlug($slug, $episodeId)
    {
        return $this->sourceRepo->getSourceByEpisodeId($episodeId);
    }

    public function searchTvShow(Request $request)
    {
        $keyword = $request->keyword;
        $listMovie = $this->posterRepo->getTvShowByKeyword($keyword)->toArray();
        foreach ($listMovie as &$movie) {
            $mediaCover = $this->mediaRepo->find($movie->cover_id);
            $mediaPoster = $this->mediaRepo->find($movie->poster_id);
            $movie->coverImg = $mediaCover['url'];
            $movie->posterImg = $mediaPoster['url'];
        }
        return $listMovie;
    }
}
