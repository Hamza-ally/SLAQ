<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Http\Requests\StoreSubmissionRequest;
use App\Interfaces\SubmissionRepoInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resources\SubmissionResource;
use Illuminate\Support\Facades\DB;

class SubmissionController extends Controller
{

    private SubmissionRepoInterface $submissionRepoInterface;

    public function __construct(SubmissionRepoInterface $submissionRepoInterface)
    {
        $this->submissionRepoInterface = $submissionRepoInterface;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubmissionRequest $request)
    {
        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ];
        DB::beginTransaction();
        try {
            $submission = $this->submissionRepoInterface->store($details);

            DB::commit();
            return ApiResponseClass::sendResponse(new SubmissionResource($submission), 'Submission Created Successful', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }
}
