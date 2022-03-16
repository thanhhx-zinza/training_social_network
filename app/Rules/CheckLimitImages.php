<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckLimitImages implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute = null, $value = null)
    {
        $imageUpNew = $this->data->images;
        $imageOld = $this->data->preloaded;
        if (isset($imageUpNew) && isset($imageOld)) {
            $length = count($imageOld) + count($imageUpNew);
        } else {
            $length = (!empty($imageOld) ? count($imageOld) : 0) + (!empty($imageUpNew) ? count($imageUpNew) : 0);
        }
        if ($length > 10) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You can only upload a maximum of 10 image';
    }
}
