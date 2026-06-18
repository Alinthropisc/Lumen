<?php

namespace App\Services\Auth;

use App\Contracts\IEmailVerificationRepository;
use App\Contracts\IUserRepository;
use App\Dtos\Auth\LoginData;
use App\Dtos\Auth\RegisterData;
use App\Dtos\Auth\ResetPasswordData;
use App\Dtos\Auth\TokenResult;
use App\Events\Auth\UserLoggedIn;
use App\Events\Auth\UserRegistered;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class AuthService
{
    public function __construct(
        private readonly IUserRepository $userRepository,
        private readonly IEmailVerificationRepository $emailVerificationRepository,
    ) {}

    /**
     * @throws Throwable
     */
    public function login(LoginData $data): TokenResult
    {
        /** @var User $model */
        $model = $this->userRepository->findByEmailOrName($data->email);

        if ($model && Hash::check($data->password, $model->password)) {
            event(new UserLoggedIn($model));

            return new TokenResult(
                type: 'Bearer',
                token: $this->userRepository->createToken($data->email),
                user: $model,
            );
        }

        throw new UnauthorizedHttpException('Bearer', 'The provided username or password is incorrect.');
    }

    /**
     * @throws Throwable
     */
    public function register(RegisterData $data): TokenResult
    {
        $emailVerification = $this->emailVerificationRepository->findByEmail($data->email);

        if ($emailVerification && Hash::check($data->code, $emailVerification->code)) {
            $user = $this->userRepository->create([
                'email' => $data->email,
                'password' => $data->password,
                'name' => $data->name,
                'roles' => [['role_code' => 'new_user', 'status' => true]],
                'email_verified_at' => date('Y-m-d'),
            ]);
            $emailVerification->delete();
            event(new UserRegistered($user));

            return new TokenResult(
                type: 'Bearer',
                token: $this->userRepository->createToken($data->email),
                user: $user,
            );
        }

        throw new UnauthorizedHttpException('Bearer', 'The email is not verified, please repeat again.');
    }

    /**
     * @throws Throwable
     */
    public function resetPassword(ResetPasswordData $data): TokenResult
    {
        $emailVerification = $this->emailVerificationRepository->findByEmail($data->email);

        if ($emailVerification && Hash::check($data->code, $emailVerification->code)) {
            $user = $this->userRepository->findByEmail($data->email);
            $user->password = $data->password;
            $user->save();
            $emailVerification->delete();

            return new TokenResult(
                type: 'Bearer',
                token: $this->userRepository->createToken($data->email),
                user: $user,
            );
        }

        throw new UnauthorizedHttpException('Bearer', 'The email is not verified, please repeat again.');
    }

    /**
     * @throws Throwable
     */
    public function logout(): int
    {
        return $this->userRepository->removeToken(auth()->user());
    }
}
