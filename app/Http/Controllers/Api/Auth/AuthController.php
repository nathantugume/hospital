<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Patient;
use App\Models\Staff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $request->ensureIsNotRateLimited();

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            RateLimiter::hit($request->throttleKey());
            throw ValidationException::withMessages(['email' => __('auth.failed')]);
        }

        RateLimiter::clear($request->throttleKey());

        if ($user->two_factor_secret && ! is_null($user->two_factor_confirmed_at)) {
            $token = $user->createToken('2fa_pending', ['2fa'])->plainTextToken;
            return response()->json([
                'success' => true,
                'message' => 'Two-factor authentication required.',
                'two_factor_required' => true,
                'challenge_token' => $token,
            ], 200);
        }

        $token = $user->createToken('auth_token', ['*'])->plainTextToken;
        return $this->respondWithToken($token, $user, 'Login successful.');
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['role'] = $data['role'] ?? 'patient';

        $user = User::create($data);

        if ($user->role === 'patient') {
            $patient = Patient::create([
                'code' => 'P-' . str_pad((string) (Patient::max('id') + 1), 5, '0', STR_PAD_LEFT),
                'first_name' => $user->name,
                'last_name' => '',
                'date_of_birth' => $data['date_of_birth'] ?? now()->subYears(25),
                'gender' => $data['gender'] ?? 'Other',
                'email' => $user->email,
                'phone' => $data['phone'] ?? null,
                'city' => $data['city'] ?? null,
                'country' => $data['country'] ?? 'Uganda',
                'status' => 'Active',
            ]);
            $user->update(['patient_id' => $patient->id]);
        }

        $token = $user->createToken('auth_token', ['*'])->plainTextToken;
        return $this->respondWithToken($token, $user, 'Registration successful.', 201);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new UserResource($request->user()),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => true, 'message' => 'Logged out successfully.']);
    }

    public function logoutAll(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        return response()->json(['success' => true, 'message' => 'Logged out from all devices.']);
    }

    public function refresh(Request $request): JsonResponse
    {
        $user = $request->user();
        $request->user()->currentAccessToken()->delete();
        $token = $user->createToken('auth_token', ['*'])->plainTextToken;
        return $this->respondWithToken($token, $user, 'Token refreshed.');
    }

    protected function respondWithToken(string $token, User $user, string $message, int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => (int) config('sanctum.expiration', 525600) * 60,
                'user' => new UserResource($user),
            ],
        ], $status);
    }
}
