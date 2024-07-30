<?php

namespace Modules\Media\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageSizeRule implements Rule
{
    /**
     * @var int
     */
    public $maxWidth;
    /**
     * @var int
     */
    public $maxHeight;

    protected $lastError;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $maxWidth,int $maxHeight)
    {
        //
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;
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
        $allowedExtsImage = [
            'jpg',
            'jpeg',
            'bmp',
            'png',
            'gif',
        ];
        if(!in_array(strtolower($value->getClientOriginalExtension()), $allowedExtsImage)) {
            // not image
            return true;
        }
        $imagedata = getimagesize($value->getPathname());
        if (empty($imagedata)) {
            $this->lastError = __("Can not get image size");
            return false;
        }
        if (!empty($this->maxWidth) and $imagedata[0] > $this->maxWidth) {
            $this->lastError = __("Maximum width allowed is: :number", ['number' => $this->maxWidth]);
            return false;
        }
        if (!empty($this->maxHeight) and $imagedata[1] > $this->maxHeight) {
            $this->lastError = __("Maximum height allowed is: :number", ['number' => $this->maxHeight]);
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
        return $this->lastError;
    }
}
