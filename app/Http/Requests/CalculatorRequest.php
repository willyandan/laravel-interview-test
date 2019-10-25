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
        // TODO @laravel-test
    }

    public function getA(): int
    {
        // TODO @laravel-test
    }

    public function getB(): int
    {
        // TODO @laravel-test
    }
}
