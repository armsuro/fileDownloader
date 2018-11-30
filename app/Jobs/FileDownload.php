<?php
namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\File;
use App\FileStatus;

class FileDownload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $file;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }
    /**
     * This function downloads file from source
     *
     * @return void
     */
    public function handle()
    {
        set_time_limit(0);

        $url = $this->file->url;
        $fileName = $this->file->hash;

        $this->file->update([
            'status_id' => FileStatus::DOWNLOADING
        ]);

        $context = stream_context_create([
            "http" => [
                "header" => "User-Agent: Downloader 1.0"
            ]
        ], [
            'notification' => [$this, 'progress']
        ]);

        $file = fopen($url, 'rb', null, $context);

        if (!$file) {
            throw new \Exception('Unprocessable url');
        }

        \Storage::disk('files')->put($fileName, $file);

        fclose($file);

        $this->file->status_id = FileStatus::COMPLETED;
        $this->file->file_size = $this->file->received_bytes;

        $this->file->save();
    }


    /**
     * In case failure runs this one
     *
     * @return void
    */

    public function failed()
    {
        $this->file->update([
            'status_id' => FileStatus::ERROR
        ]);
    }

    public function progress($notificationCode, $severity, $message, $messageCode, $bytesTransferred, $fileSize)
    {
        $lastUpdateTime = strtotime($this->file->updated_at);
        $diffSeconds = time() - $lastUpdateTime;

        switch($notificationCode) {
            case STREAM_NOTIFY_AUTH_REQUIRED: {
                throw new \Exception('Authorization is required');
            }
            case STREAM_NOTIFY_FAILURE: {
                throw new \Exception('Failure');
                break;
            }
            case STREAM_NOTIFY_FILE_SIZE_IS: {
                $this->file->file_size = $fileSize;
                break;
            }
            case STREAM_NOTIFY_MIME_TYPE_IS: {
                $this->file->mime_type = $message;
                break;
            }
            case STREAM_NOTIFY_PROGRESS: {
                $this->file->received_bytes = $bytesTransferred;
                break;
            }
        }

        if ($diffSeconds > 2) {
            $this->file->save();
        }
    }
}
