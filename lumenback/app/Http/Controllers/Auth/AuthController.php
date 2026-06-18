<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\SendVerificationCodeAction;
use App\Dtos\ApiResponse;
use App\Dtos\Auth\LoginData;
use App\Dtos\Auth\RegisterData;
use App\Dtos\Auth\ResetPasswordData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendCodeRequest;
use App\Http\Requests\Auth\UpdateYourselfRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $service,
        private readonly SendVerificationCodeAction $sendCodeAction,
    ) {}

    /**
     * @throws Throwable
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return ApiResponse::success($this->service->login(LoginData::fromArray($request->validated()))->toArray());
    }

    public function sendCode(SendCodeRequest $request): JsonResponse
    {
        $this->sendCodeAction->execute($request->validated('email'), $request->validated('type'));

        return ApiResponse::success(['message' => 'Verification code sent to your email.']);
    }

    /**
     * @throws Throwable
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        return ApiResponse::success($this->service->register(RegisterData::fromArray($request->validated()))->toArray());
    }

    /**
     * @throws Throwable
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        return ApiResponse::success($this->service->resetPassword(ResetPasswordData::fromArray($request->validated()))->toArray());
    }

    /**
     * @throws Throwable
     */
    public function logout(): JsonResponse
    {
        return ApiResponse::success(['deleted' => $this->service->logout()]);
    }

    public function checkUserToken(): JsonResponse
    {
        $user = auth()->user();

        if ($user) {
            return ApiResponse::success(['user' => $user]);
        }

        return ApiResponse::error('Unauthenticated.', Response::HTTP_UNAUTHORIZED);
    }

    public function updateYourself(UpdateYourselfRequest $request): JsonResponse
    {
        $user = auth()->user();
        $user->update($request->validated());

        return ApiResponse::success(['user' => $user->fresh()]);
    }
}
