<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Features;
use App\Models\User;

class TwoFactorController extends Controller
{
    public function qr(Request $request): JsonResponse
    {
        $user = $request->user();
        if (! Features::canManageTwoFactorAuthentication()) {
            return $this->error('2FA not enabled.', 403);
        }
        if (! $user->two_factor_secret) {
            return $this->error('2FA not configured.', 400);
        }
        $qr = $user->twoFactorQrCodeSvg();
        return $this->success(['qr_svg' => $qr, 'recovery_codes' => $user->twoFactorRecoveryCodes() ?: []]);
    }

    public function enable(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string|size:6',
            'password' => 'required|string',
        ]);
        $user = $request->user();
        if (! Hash::check($request->password, $user->password)) {
            return $this->error('Invalid password.', 422);
        }
        $user->forceFill([
            'two_factor_confirmed_at' => now(),
        ])->save();
        return $this->success(null, '2FA confirmed.');
    }

    public function disable(Request $request): JsonResponse
    {
        $request->validate(['password' => 'required|string']);
        $user = $request->user();
        if (! Hash::check($request->password, $user->password)) {
            return $this->error('Invalid password.', 422);
        }
        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();
        return $this->success(null, '2FA disabled.');
    }

    public function regenerateRecoveryCodes(Request $request): JsonResponse
    {
        $request->validate(['password' => 'required|string']);
        $user = $request->user();
        if (! Hash::check($request->password, $user->password)) {
            return $this->error('Invalid password.', 422);
        }
        $codes = json_encode(collect(range(1, 8))->map(fn() => Illuminate\Support\Str::random(10).'-'.Illuminate\Support\Str::random(10))->all());
        $user->forceFill(['two_factor_recovery_codes' => $codes])->save();
        return $this->success(['recovery_codes' => json_decode($codes)]);
    }

    public function challenge(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required_without:recovery_code|string|size:6',
            'recovery_code' => 'required_without:code|string',
            'challenge_token' => 'required|string',
        ]);

        $token = \Laravel\Sanctum\PersonalAccessToken::findToken($request->challenge_token);
        if (! $token || ! in_array('2fa', $token->abilities ?? [], true)) {
            return $this->error('Invalid challenge token.', 401);
        }
        $user = $token->tokenable;
        if (! $user) {
            return $this->error('User not found.', 404);
        }

        if ($request->code) {
            $valid = app(\Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication::class)($user, $request->code);
            if (! $valid) {
                return $this->error('Invalid 2FA code.', 422);
            }
        } else {
            $valid = collect(json_decode($user->two_factor_recovery_codes, true) ?? [])
                ->contains(fn($code) => hash_equals($code, $request->recovery_code));
            if (! $valid) {
                return $this->error('Invalid recovery code.', 422);
            }
        }

        $token->delete();
        $newToken = $user->createToken('auth_token', ['*'])->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => '2FA verified.',
            'data' => [
                'token' => $newToken,
                'token_type' => 'Bearer',
                'user' => new \App\Http\Resources\UserResource($user),
            ],
        ]);
    }
}
