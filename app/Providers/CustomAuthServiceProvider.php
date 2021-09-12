<?php


namespace App\Providers;


use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class CustomAuthServiceProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials): ?UserContract
    {
        if (isset($credentials['Password'])) {
            unset($credentials['Password']);
        }

        return parent::retrieveByCredentials($credentials);
    }

    public function validateCredentials(UserContract $user, array $credentials): bool
    {
        $plain = $credentials['Password'];
        return $this->hasher->check($plain, $user->getAuthPassword());
    }
}
