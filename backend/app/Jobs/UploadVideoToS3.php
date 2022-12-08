<?php

namespace App\Jobs;

use App\Http\Controllers\AwsS3Controller;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadVideoToS3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $fileName;

    protected $filePath;

    public function __construct($filePath, $fileName)
    {
        $this->fileName = $fileName;
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle(AwsS3Controller $awsClient)
    {
        $awsClient->pushMedia([
            'sourcePath' => storage_path('app/' . $this->filePath),
            'targetPath' => 'videos/',
            'fileName' => $this->fileName,
        ]);
    }
}
