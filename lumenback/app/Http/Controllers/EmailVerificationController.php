<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest\StoreEmailVerificationRequest;
use App\Http\Requests\UpdateRequest\UpdateEmailVerificationRequest;
use App\Models\EmailVerification;
use App\Services\EmailVerificationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class EmailVerificationController extends Controller
{
    private EmailVerificationService $service;

    public function __construct(EmailVerificationService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws \Throwable
     */
    public function sendEmailVerification(StoreEmailVerificationRequest $request): array|Builder|Collection|EmailVerification
    {
        return $this->service->createModel($request->validated());
    }

    /**
     * @throws \Throwable
     */
    public function checkEmailVerification(UpdateEmailVerificationRequest $request): JsonResponse
    {
        return $this->service->checkVerificationCode($request->validated());
    }
}
