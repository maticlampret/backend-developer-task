<?php

namespace App\Http\Controllers;

use App\Http\Requests\Notes\GetNotesRequest;
use App\Http\Requests\Notes\UpdateNoteRequest;
use App\Http\Requests\Notes\CreateNoteRequest;
use App\Http\Requests\Notes\CreateNodeBodyRequest;
use App\Http\Requests\Notes\UpdateNoteBodyRequest;
use App\Http\Requests\Notes\DeleteNoteBodyRequest;
use App\Models\NoteBodies;
use App\Models\Notes;
use Illuminate\Support\Arr;
use App\Models\Folders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotesController extends Controller
{

    public function GetNotes(GetNotesRequest $request)
    {
        $user = Auth::user();

        $params = $request->all();

        /* if user was not authenticated then return just public notes, since folders are private non auth users
            cannot filter based on idFolder or note visibility but can filter based on public notes text
            Filtering on auth/nonAuth user is defined in model under scopeGuestOrUser */
        $notes = Notes::GuestOrUser($user)
            ->with([
                'body' => function ($query) {
                    $query->select(['id_note', 'id_note_body', 'text']);
                }
            ]);

        //Since I am filtering records that I know belong to User, I do not need to check that the idFolder he sends as param is actually his folder.
        if ($user && Arr::get($params, 'idFolder')) {
            $notes->where('id_folder', Arr::get($params, 'idFolder'));
        }

        /* Since filterPublic can have 0 when filtering only private notes I needed to use array_key_exists instead of Arr::get()
        Currently frontend needs to send 1 if filtering by public and 0 filterPublic to return private */
        if ($user && array_key_exists('filterPublic', $params)) {
            $notes->where('public', Arr::get($params, 'filterPublic'));
        }

        //Here I could do toLowercase on noteBody text and searchTerm to make it more friendly, currently user has to match the exact spelling
        if (Arr::get($params, 'searchTerm')) {
            $notes->whereHas('body', function ($query) use ($params) {
                $query->Where('text', 'LIKE', '%' . Arr::get($params, 'searchTerm') . '%');
            });
        }

        /* sort based on send fields, in case this parameters are not send (they are optional), I default sort notes based on their name in ascending alphabetical order
        if default sorting by name is not correct for the app use case then I would check if request has sortField and only then sort the records */
        $notes->orderBy(Arr::get($params, 'sortField', 'name'), Arr::get($params, 'sortDirection', 'ASC'));

        /* Implementing pagination, if no params are send then the default is first page and 10 records per page
        Pagination could also be done by using laravel eloquent paginated */
        $notes = $notes->take(Arr::get($params, 'perPage', 10))
            ->skip((Arr::get($params, 'page', 1) - 1) * Arr::get($params, 'perPage', 10))
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notes
        ], 200);
    }

    public function UpdateNote($idNote, UpdateNoteRequest $request)
    {
        $user = Auth::user();

        $params = $request->all();

        $noteToUpdate = Notes::where('id_user', $user->id_user)
            ->withCount('body')
            ->find($idNote);

        if (!$noteToUpdate) {
            return response()->json([
                'success' => false,
                'message' => 'User cannot update requested note'
            ], 403);
        }

        //check if the folder the user wants to have the note in, is actually his
        if (Arr::get($params, 'idFolder')) {
            $folder = Folders::where('id_user', $user->id_user)
                ->find(Arr::get($params, 'idFolder'));

            if (!$folder) {
                return response()->json([
                    'success' => false,
                    'message' => 'User cannot use requested folder'
                ], 400);
            }
        }

        /* If note already has some body, user cannot change its type,
         on the frontend the select for changing id_note_type is locked to the current type in the event that note has content already */
        if (Arr::get($params, 'idNoteType') != $noteToUpdate->id_note_type && $noteToUpdate->body_count) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot change note type because it already has content'
            ], 400);
        }

        $noteToUpdate->name = Arr::get($params, 'name');

        $noteToUpdate->public = Arr::get($params, 'public', 0);

        $noteToUpdate->id_note_type = Arr::get($params, 'idNoteType');

        $noteToUpdate->id_folder = Arr::get($params, 'idFolder');

        $success = $noteToUpdate->save();

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Note has been updated' : 'There was an error'
        ], 200);
    }

    public function deleteNote($idNote)
    {
        $user = Auth::user();

        $note = Notes::with('body')
            ->where('id_user', $user->id_user)
            ->find($idNote, ['id_note', 'name']);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'User cannot delete requested note'
            ], 403);
        }

        /* Since I am potentially deleting records from 2 tables, I could wrap this
        in a transaction to ensure referential integrity */
        $note->body()->delete();

        $success = $note->delete();

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Note has been deleted' : 'There was an error'
        ], 200);
    }

    public function CreateNote(CreateNoteRequest $request)
    {
        $user = Auth::user();

        $params = $request->all();

        /* this would prevent an attack where a legitimate user spams the api with create note requests where he uses a
        folder that is not his. */
        if (Arr::get($params, 'idFolder')) {
            $folder = Folders::where('id_user', $user->id_user)
                ->find(Arr::get($params, 'idFolder'));

            if (!$folder) {
                return response()->json([
                    'success' => false,
                    'message' => 'User cannot use requested folder.'
                ], 400);
            }
        }

        $newNote = new Notes([
                'name' => Arr::get($params, 'name'),
                'id_user' => $user->id_user,
                'id_folder' => Arr::get($params, 'idFolder'),
                'public' => Arr::get($params, 'public', 0),
                'id_note_type' => Arr::get($params, 'idNoteType')
            ]
        );

        $success = $newNote->save();

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Note has been created' : 'There was an error'
        ], 200);
    }

    public function GetNote($idNote)
    {
        $user = Auth::user();

        //where('public', 1) could also be moved to model scope since it's used a couple of times
        if (!$user) {
            $note = Notes::where('public', 1)
                ->with('body')
                ->find($idNote, ['id_note', 'name']);
        } else {
            $note = Notes::with('body')
                ->Where(function ($query) use ($user) {
                    $query->where('public', 1);
                    $query->Orwhere('id_user', $user->id_user);
                })
                ->find($idNote, ['id_note', 'name']);
        }

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Requested note was not found.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $note
        ], 200);
    }

    /* Note bodies are what hold actual things that users write in their notes. In text notes this is one record that contains
    all the text and in list type this is multiple records one for each list item user writes */
    public function CreateNodeBody(CreateNodeBodyRequest $request)
    {
        $user = Auth::user();

        $params = $request->all();

        $note = Notes::withCount('body')
            ->with('tip')
            ->where('id_user', $user->id_user)
            ->find(Arr::get($params, 'idNote'));

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'User cannot add to requested note.'
            ], 403);
        }

        /* if note is of type "text note" and already has a body record, then another cannot be created.
        This would firstly be handled on frontend so such a request wouldn't happen, but I have to double check on server side aswell */
        if ($note->tip->isTextBody() && $note->body_count) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot create another note body.'
            ], 400);
        }

        $newNoteBody = new NoteBodies([
                'id_note' => Arr::get($params, 'idNote'),
                'text' => Arr::get($params, 'text'),
            ]
        );

        $success = $newNoteBody->save();

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Note body has been created' : 'There was an error'
        ], 200);
    }

    public function UpdateNoteBody(UpdateNoteBodyRequest $request)
    {
        $user = Auth::user();

        $params = $request->all();

        $noteToUpdate = Notes::with('body')
            ->where('id_user', $user->id_user)
            ->find(Arr::get($params, 'idNote'));

        if (!$noteToUpdate) {
            return response()->json([
                'success' => false,
                'message' => 'User cannot update requested note.'
            ], 403);
        }

        $noteBodyToUpdate = $noteToUpdate->body()->find(Arr::get($params, 'idNoteBody'));

        if (!$noteBodyToUpdate) {
            return response()->json([
                'success' => false,
                'message' => 'Note body record not found.'
            ], 200);
        }

        $noteBodyToUpdate->text = Arr::get($params, 'text');

        $success = $noteBodyToUpdate->save();

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Note body has been updated' : 'There was an error'
        ], 200);
    }

    /* Another possible use case is that user wants to delete all content in note body. He can do this with both current types of note
    in "text note" he will delete entire body and possibly write a new one and in "list note" he deletes one list item's he doesn't want anymore.
    This of course is not deleting entire note, for example lets say user has a shopping list and he decides that he no longer needs a particular item.
    He would delete just that item from shopping list note which would send the request here. I think there is a case for having this function just for
    the list notes and not also text notes, but currently I implemented it for both types. Another improvement is possibly moving noteBody operation to its own controller
    but right now I decided to leave it here.*/
    public function DeleteNoteBody(DeleteNoteBodyRequest $request)
    {
        $user = Auth::user();

        $params = $request->all();

        $note = Notes::with('body')
            ->where('id_user', $user->id_user)
            ->find(Arr::get($params, 'idNote'));

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'User cannot delete requested note.'
            ], 403);
        }

        $noteBodyToUpdate = $note->body()->find(Arr::get($params, 'idNoteBody'));

        if (!$noteBodyToUpdate) {
            return response()->json([
                'success' => false,
                'message' => 'Note body record not found.'
            ], 200);
        }

        $success = $noteBodyToUpdate->delete();

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Note body has been deleted' : 'There was an error'
        ], 200);
    }
}
