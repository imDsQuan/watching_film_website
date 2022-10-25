<?php

namespace App\Repositories;

use App\Models\Media;

class MediaRepository extends EloquentRepository
{

    public function getModel()
    {
        return Media::class;
    }
}
