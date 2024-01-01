<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class MatchOldPassword implements Rule
{

    /**
     * Memeriksa apakah password sama dengan password sebelumnya
     */
    public function passes($attribute, $value)
    {
        return Hash::check($value, auth()->user()->password);
    }

    /**
     * Menampilkan error message validasi
     */
    public function message()
    {
        return 'Incorrect password';
    }
}