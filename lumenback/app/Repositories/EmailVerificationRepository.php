<?php

namespace App\Repositories;

use App\Contracts\IEmailVerificationRepository;
use App\Models\EmailVerification;

class EmailVerificationRepository extends BaseRepository implements IEmailVerificationRepository
{
    public function __construct(EmailVerification $model)
    {
        parent::__construct($model);
    }

    /**
     * @throws \Throwable
     */
    public function findByEmail(string $email): ?EmailVerification
    {
        return $this->query()->where('created_at', '>', date('Y-m-d H:i:s', strtotime('-1 hours')))->where('email', $email)->latest('email')->first();
    }
}
