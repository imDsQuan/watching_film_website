<?php

namespace App\Http\Controllers;

use App\Repositories\ActorRepository;
use App\Repositories\GenreRepository;
use App\Repositories\MediaRepository;
use App\Repositories\PosterGenresRepository;
use App\Repositories\PosterRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SourceRepository;
use Illuminate\Http\Request;

class PosterController extends Controller
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
        //
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

    public function getRandom() {
        $poster = $this->posterRepo->getRandom();
        $mediaCover = $this->mediaRepo->find($poster->cover_id);
        $mediaPoster = $this->mediaRepo->find($poster->poster_id);
        $source = $this->mediaRepo->find($poster->trailer_id);
        $poster['coverImg'] = $mediaCover->url;
        $poster['posterImg'] = $mediaPoster->url;
        $poster['trailer'] = $source['url'];

        return $poster;
    }

    public function getNewRelease()
    {
        $lstPoster = $this->posterRepo->getNewRealase();
        foreach ($lstPoster as $poster) {
            $mediaCover = $this->mediaRepo->find($poster->cover_id);
            $mediaPoster = $this->mediaRepo->find($poster->poster_id);
            $poster->coverImg = $mediaCover->url;
            $poster->posterImg = $mediaPoster->url;
        }

        return $lstPoster;
    }

    public function getByGenre($genre) {
        $lstPoster = $this->posterRepo->getByGenre($genre);
        foreach ($lstPoster as $poster) {
            $mediaCover = $this->mediaRepo->find($poster->cover_id);
            $mediaPoster = $this->mediaRepo->find($poster->poster_id);
            $poster->coverImg = $mediaCover->url;
            $poster->posterImg = $mediaPoster->url;
        }
        return $lstPoster;
    }
}
