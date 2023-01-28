<?php

namespace App\Http\Controllers;

use App\Repositories\PackRepository;
use Illuminate\Http\Request;

class PackController extends Controller
{

    protected $packRepo;

    public function __construct(PackRepository $packRepo)
    {
        $this->packRepo = $packRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $listPack = $this->packRepo->getAll()->toArray();
        return view('pages.pack.index', [
            'title' => 'Pack Manager',
            'totalPack' => $this->packRepo->total(),
            'listPack' => $listPack,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.pack.create',
            [
                'title' => 'Create Pack',
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

        $this->packRepo->create([
            'title' => $request->title,
            'description' => $request->description,
            'discount' => $request->discount,
            'price' => $request->price,
            'duration' => $request->duration,
            'position' => $this->packRepo->maxPosition() + 1,
        ]);

        return redirect('/pack');
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
    public function edit($title)
    {
        $pack = $this->packRepo->getPackByTitle($title);
        return view('pages.pack.edit',
            [
                'title' => 'Edit Pack',
                'pack' => $pack,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->packRepo->update($request->id, [
            'title' => $request->title,
            'description' => $request->description,
            'discount' => $request->discount,
            'price' => $request->price,
            'duration' => $request->duration,
        ]);

        return redirect('/pack');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->packRepo->delete($id);

        return $this->responseData();
    }

    public function getAllPack(){
        $lstPack = $this->packRepo->getAll();
        foreach($lstPack as $pack) {
            $pack['description'] = preg_split("/\r\n|\n|\r/", $pack['description']);
        }
        return $lstPack;
    }

    public function getPack(Request $request)
    {
        $pack =  $this->packRepo->find($request->id);
        $pack['description'] = preg_split("/\r\n|\n|\r/", $pack['description']);
        return $pack;
    }
}
