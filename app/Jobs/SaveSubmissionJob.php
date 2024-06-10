<?php

namespace App\Jobs;

use App\Models\Submission;
use App\Events\SubmissionSaved;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Interfaces\SubmissionRepoInterface;

class SaveSubmissionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $name;
    public $email;
    public $message;
    private SubmissionRepoInterface $submissionRepoInterface;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $email, $message, SubmissionRepoInterface $submissionRepoInterface)
    {
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
        $this->submissionRepoInterface = $submissionRepoInterface;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $details = [
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ];
        $this->dispatch(new LogSubmissionEvent($details, $this->submissionRepoInterface));
    }
}