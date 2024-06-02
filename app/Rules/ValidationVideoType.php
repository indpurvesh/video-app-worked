<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidationVideoType implements ValidationRule
{
    protected $allowedMimeTypes = [
        'video/webm',
        'video/mp4'
    ];
    
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $clientMime = $value->getClientMimeType();
        if (!in_array($clientMime, $this->allowedMimeTypes)) {
            $fail("Mime type " . $clientMime . " not allowed");
        }
    }
}
