<?php

namespace App\Jobs;

use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadImageToS3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $fileName;

    protected $filePath;

    public function __construct($fileName, $filePath)
    {
        $this->filePath = $filePath;
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {

        $result  = Storage::disk('s3')->putFileAs('images', new File(storage_path('app/' . $this->filePath)), $this->fileName);

        if ($result == false) {
            throw new Exception("Couldn't upload file to S3");
        }

        if (!Storage::disk('local')->delete($this->filePath)) {
            throw new Exception('File could not be deleted from the local filesystem ');
        }
    }
}
