<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculatorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "a"=>[
                "required",
                "integer"
            ],
            "b"=>[
                "required",
                "integer",
                function ($attr, $value, $fail) {
                    $method = explode('@', $this->route()->getActionName())[1];
                    if($method == 'div' || $method == 'mod'){
                        if($value == 0){
                            $fail("$attr can’t be 0");
                        }
                    }
                }
            ]
        ];
    }

    public function getA(): int
    {
        return FormRequest::query('a');
    }

    public function getB(): int
    {
        return FormRequest::query('b');
    }
}
