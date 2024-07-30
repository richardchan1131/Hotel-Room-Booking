<?php

namespace Modules\Media\Rules;

use Illuminate\Contracts\Validation\Rule;

class FileExtRule implements Rule
{
    /**
     * @var array
     */
    public $acceptedExt;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $acceptedExt)
    {
        //
        $this->acceptedExt = $acceptedExt;
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
        $ext = $value->getClientOriginalExtension();
        return in_array($ext,$this->acceptedExt);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __("File type invalid");
    }
}
