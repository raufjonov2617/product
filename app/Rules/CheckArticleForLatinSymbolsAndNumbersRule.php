<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckArticleForLatinSymbolsAndNumbersRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^[a-zA-Z0-9]+$/';

        if (!preg_match($pattern, $value)){
            $fail('The :attribute must be only latin symbols and numbers');
        }
    }
}
