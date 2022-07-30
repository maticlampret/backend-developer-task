<?php

namespace App\Http\Requests\Folders;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class DeleteFolderRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idFolder' => 'required|numeric|exists:folders,id_folder',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ]));

    }

    public function messages()
    {

        return [
            'idFolder.required' => 'idFolder is required',
            'idFolder.exists' => 'Invalid value for idFolder'
        ];

    }
}
