<?php

namespace App\Contracts;

use App\Models\EmailVerification;

interface IEmailVerificationRepository extends IBaseRepository
{
    public function findByEmail(string $email): ?EmailVerification;
}
