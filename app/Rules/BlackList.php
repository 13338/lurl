<?php

namespace App\Rules;

use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Validation\Rule;

class BlackList implements Rule
{
    /**
     * domain black list
     * @var
     */
    protected $blackList = [];

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->blackList = [
            Request::server('HTTP_HOST'),
            'pornhub.com',
        ];
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $flag = true;
        foreach ($this->blackList as $item) {
            if (preg_match('/^(?:http(?:s)?:\/\/)?(?:[^\.]+\.)?'.str_replace('.', '\.', $item).'(\/.*)?$/', $value)) {
                $flag = false;
            }
        }
        return $flag;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Not available domain';
    }
}
