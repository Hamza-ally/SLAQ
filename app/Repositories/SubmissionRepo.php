<?php

namespace App\Repositories;

use App\Models\Submission;
use App\Interfaces\SubmissionRepoInterface;

class SubmissionRepo implements SubmissionRepoInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(array $data){
        return Submission::create($data);
    }
}
