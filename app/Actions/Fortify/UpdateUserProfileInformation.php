<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    public function update($user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ])->validate();

        if ($input['email'] !== $user->email && $user->email_verified_at) {
            $user->forceFill(['email_verified_at' => null]);
        }

        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
        ])->save();
    }
}
