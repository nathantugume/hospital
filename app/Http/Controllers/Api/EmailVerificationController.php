<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class EmailVerificationController extends Controller
{
    public function verify(Request $request, $id, $hash): JsonResponse
    {
        $user = User::findOrFail($id);
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException('Invalid verification link.');
        }
        if ($user->hasVerifiedEmail()) {
            return $this->success(null, 'Email already verified.');
        }
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        return $this->success(null, 'Email verified successfully.');
    }

    public function resend(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user->hasVerifiedEmail()) {
            return $this->success(null, 'Email already verified.');
        }
        $user->sendEmailVerificationNotification();
        return $this->success(null, 'Verification link resent.');
    }
}
