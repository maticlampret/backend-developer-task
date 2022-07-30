<?php



namespace App\Http\Requests\Notes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;




class DeleteNoteBodyRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idNote' => 'required|exists:notes,id_note',
            'idNoteBody' => 'required|exists:note_bodies,id_note_body',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'errors'      => $validator->errors()
        ]));

    }

    public function messages()
    {

        return [
            'idNote.required' => 'idNote is required',
            'idNote.exists' => 'Invalid value for idNote',
            'idNoteBody.required' => 'idNoteBody is required',
            'idNoteBody.exists' => 'Invalid value for idNoteBody',
        ];

    }
}
