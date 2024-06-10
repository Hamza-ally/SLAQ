<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Interfaces\SubmissionRepoInterface;
use Illuminate\Support\Facades\DB;

class LogSubmissionEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $details;
    private SubmissionRepoInterface $submissionRepoInterface;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details, SubmissionRepoInterface $submissionRepoInterface)
    {
        $this->details = $details;
        $this->submissionRepoInterface = $submissionRepoInterface;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();

        $this->submissionRepoInterface->store([
            "name" => $this->details['name'],
            "email" => $this->details['email'],
            "message" => $this->details['message'],
        ]);
        
        DB::commit();

        Log::channel('submission')->info('Submission received', [
            'name' => $this->details['name'],
            'email' => $this->details['email'],
            'message' => $this->details['message'],
        ]);
    }
}