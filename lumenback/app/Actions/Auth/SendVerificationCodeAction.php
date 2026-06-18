<?php

namespace App\Actions\Auth;

use App\Mail\VerificationCodeMail;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\Mail;

class SendVerificationCodeAction
{
    public function execute(string $email, string $type): void
    {
        $code = (string) random_int(100000, 999999);

        EmailVerification::updateOrCreate(
            ['email' => $email],
            ['code' => bcrypt($code)],
        );

        Mail::to($email)->queue(new VerificationCodeMail($code, $type));
    }
}
