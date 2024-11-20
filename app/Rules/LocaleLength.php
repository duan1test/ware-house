<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class LocaleLength implements Rule
{
    public function message()
    {
        return __('messages.settings.locale_length');
    }

    public function passes($attribute, $value)
    {
        return 2 == strlen($value) || 5 == strlen($value);
    }
}
