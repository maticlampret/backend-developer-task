<?php


namespace App\Http\Requests\Notes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class GetNotesRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idFolder' => 'exists:folders,id_folder',
            'filterPublic' => 'in:0,1',
            'sortField' => 'in:name,public',
            'sortDirection' => 'in:ASC,DESC',
            'searchTerm' => 'min:3', // search term should be at least 3 char long
            'page' => 'numeric',
            'perPage' => 'numeric'
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
            'filterPublic.in' => 'Incorrect value for filterPublic',
            'idFolder.exists' => 'Invalid value for idFolder',
            'sortField.in' => 'Incorrect value for sortField',
            'sortDirection.in' => 'Incorrect value for sortDirection',
            'searchTerm.min' => 'searchTerm needs to be at least 3 characters long',
            'page.numeric' => 'page needs to be numeric',
            'perPage.numeric' => 'perPage needs to be numeric'
        ];
    }
}
