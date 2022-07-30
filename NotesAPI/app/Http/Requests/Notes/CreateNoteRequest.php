<?php


namespace App\Http\Requests\Notes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class CreateNoteRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idFolder' => 'numeric|exists:folders,id_folder', //Since my notes can be in folders or not, this is not required, if the requirement is that all notes are in folder then this needs to be required aswell
            'name' => 'required',
            'idNoteType' => 'numeric|required|exists:note_types,id_note_type',
            'public' => 'in:1|nullable', //this value can only be 0 or 1, since it just tells us if the note is public or not
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
            'name.required' => 'name is required',
            'idNoteType.required' => 'idNoteType is required',
            'idNoteType.exists' => 'Invalid value for idNoteType',
            'idFolder.exists' => 'Invalid value for idFolder',
            'public.in' => 'Incorrect value for public',
        ];

    }
}
