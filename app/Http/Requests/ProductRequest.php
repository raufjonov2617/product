<?php

namespace App\Http\Requests;

use App\Rules\CheckArticleForLatinSymbolsAndNumbersRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'article' => ['required', 'unique:products,article', new CheckArticleForLatinSymbolsAndNumbersRule],
            'name' => 'required|string|min:10|max:191',
            'status' => 'nullable|string',
            'data' => 'nullable'
        ];
    }

    // protected function prepareForValidation()
    // {
    //     logger($this->input('product'));
    //     if (!$this->input('product'))
    //     {
    //         $this->merge([
    //             'data' => json_encode($this->input('data'))
    //         ]);
    //     }
    // }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
