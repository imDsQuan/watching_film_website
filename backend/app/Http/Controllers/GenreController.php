<?php

namespace App\Http\Controllers;

use App\Repositories\GenreRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    protected $genreRepo;

    public function __construct(GenreRepository $genreRepo)
    {
        $this->genreRepo = $genreRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\Http\Response
     */
    public function index()
    {
        $listGenre = $this->genreRepo->getAll()->toArray();

        return view('pages.genre.index',
            [
                'title' => 'Genre Manager',
                'totalGenre' => $this->genreRepo->total(),
                'listGenre' => $listGenre,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.genre.create',
            [
                'title' => 'Create Genre',
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $title = $request->title;
        $genre = array(
            'title' => $title,
            'position' => $this->genreRepo->maxPosition() + 1,
        );
        $this->genreRepo->create($genre);
        return redirect('/genre');
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
     * @param $title
     * @return Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\Http\Response
     */
    public function edit($title)
    {
        $genre = $this->genreRepo->getGenreByTitle($title);
        return view('pages.genre.edit',
            [
                'title' => 'Edit Genre',
                'genre' => $genre,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $this->genreRepo->update($request->id, [
            'title' => $request->title,
        ]);

        return redirect('/genre');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->genreRepo->delete($id);

        return $this->responseData();
    }

    public function upAction($id)
    {
        $listGenre = $this->genreRepo->getAll()->toArray();
        $genreUp = $this->genreRepo->find($id);
        $position = $genreUp->position;

        foreach ($listGenre as $genre) {
            if ($genre['position'] == ($position - 1) && $position > 1 ){
                $this->genreRepo->update($genre['id'], [
                    'position' => $position,
                ]);
                $this->genreRepo->update($id, [
                    'position' => $position - 1,
                ]);
                break;
            }
        }

        return redirect('/genre');

    }

    public function downAction($id)
    {
        $listGenre = $this->genreRepo->getAll()->toArray();
        $genreUp = $this->genreRepo->find($id);
        $position = $genreUp->position;

        $maxPosition = $this->genreRepo->maxPosition();

        foreach ($listGenre as $genre) {
            if ($genre['position'] == ($position + 1) && $position < $maxPosition ){
                $this->genreRepo->update($genre['id'], [
                    'position' => $position,
                ]);
                $this->genreRepo->update($id, [
                    'position' => $position + 1,
                ]);
                break;
            }
        }

        return redirect('/genre');
    }
}
