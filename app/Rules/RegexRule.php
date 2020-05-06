<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RegexRule implements Rule
{
    /** @var string $regex The regex to validate. */
    public $regex;

    /**
     * Create a new rule instance.
     */
    public function __construct(string $regex)
    {
        $this->regex = $regex;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            return preg_match($this->regex, $value);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Trường :attribute này không thể có ký tự đặc biệt!';
    }
}
