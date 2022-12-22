<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Repositories\ItemsRepository;
use App\Repositories\MediaRepository;
use Illuminate\Http\Request;

class MyListController extends Controller
{

    protected $itemRepo;
    protected $mediaRepo;

    public function __construct(ItemsRepository $itemRepo, MediaRepository $mediaRepo)
    {
        $this->itemRepo = $itemRepo;
        $this->mediaRepo = $mediaRepo;
    }

    public function addToList(Request $request)
    {
        $item = [
            'user_id' => $request->user_id,
            'poster_id' => $request->poster_id,
        ];

        $itemFind = Item::where(['user_id' => $request->user_id, 'poster_id' => $request->poster_id,])->first();
        if ($itemFind == null) {
            $this->itemRepo->create($item);
        }

        return $this->responseData();
    }

    public function remove(Request $request)
    {
        $this->itemRepo->delete($request->item_id);
        return $this->responseData();
    }

    public function getAll(Request $request) {
        $lstMovie = $this->itemRepo->getAllItem($request->id);
        foreach ($lstMovie as &$movie) {
            $mediaCover = $this->mediaRepo->find($movie->cover_id);
            $mediaPoster = $this->mediaRepo->find($movie->poster_id);
            $movie->coverImg = $mediaCover['url'];
            $movie->posterImg = $mediaPoster['url'];
        }
        return $lstMovie;
    }
}
