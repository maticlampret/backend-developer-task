<?php

namespace App\Http\Controllers;

use App\Http\Requests\Folders\CreateFolderRequest;
use App\Http\Requests\Folders\UpdateFolderRequest;
use Illuminate\Support\Arr;
use App\Models\Folders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FoldersController extends Controller
{
    public function GetFolders(Request $request)
    {
        $user = Auth::user();

        $params = $request->all();

        /* I could also implement pagination here the same way I did with notes but I though the amount of folders is
        going to be much lower than amount of notes so pagination might not be needed */
        $folders = Folders::select(['id_folder', 'name'])
            ->where('id_user', $user->id_user)
            ->withCount('notes');

        /* I think it also makes sense to allow user to filter his folders based on their name, for example let's say that user
        has one folder for each of his university subjects, during 3 years there is gonna be alot of folders,
        so allowing him to search based on their name is a nice quality of life feature.
        Here I could do toLowercase on name and searchTerm to make it more friendly, currently user has to match the exact spelling */
        if (Arr::get($params, 'searchTerm')) {
            $folders->Where('name', 'LIKE', '%' . Arr::get($params, 'searchTerm') . '%');
        }

        return response()->json([
            'success' => true,
            'data' => $folders->get()
        ], 200);
    }

    public function UpdateFolder($idFolder, UpdateFolderRequest $request)
    {
        $user = Auth::user();

        $params = $request->all();

        $folderToUpdate = Folders::where('id_user', $user->id_user)
            ->find($idFolder);

        if (!$folderToUpdate) {
            return response()->json([
                'success' => false,
                'message' => 'User cannot update requested folder.'
            ], 403);
        }

        $folderToUpdate->name = Arr::get($params, 'name');

        $success = $folderToUpdate->save();

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Folder has been updated' : 'There was an error'
        ], 200);
    }

    public function DeleteFolder($idFolder)
    {
        $user = Auth::user();

        $folderToDelete = Folders::withCount('notes')
            ->where('id_user', $user->id_user)
            ->find($idFolder);

        if (!$folderToDelete) {
            return response()->json([
                'success' => false,
                'message' => 'User cannot delete requested folder.'
            ], 403);
        }

        /* I think it makes sense to check if folder has any notes inside of it and prevent user from deleting it in case it does.
        If the app works in a way where deleting a folder is a quick way to delete all the notes inside then
        I would write a query that deletes all of the folder's child records(notes inside) instead of this check here */
        if ($folderToDelete->notes_count) {
            return response()->json([
                'success' => false,
                'message' => 'Please delete all the notes inside folder, before attempting to delete it.'
            ], 400);
        }

        $success = $folderToDelete->delete();

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Folder has been deleted' : 'There was an error'
        ], 200);
    }

    public function CreateFolder(CreateFolderRequest $request)
    {
        $user = Auth::user();

        $params = $request->all();

        $newFolder = new Folders([
                'name' => Arr::get($params, 'name'),
                'id_user' => $user->id_user
            ]
        );

        $success = $newFolder->save();

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Folder has been created' : 'There was an error'
        ], 200);
    }

    public function GetFolder($idFolder)
    {
        $user = Auth::user();

        $folder = Folders::where('id_user', $user->id_user)
            ->withCount('notes')
            ->find($idFolder, ['id_folder', 'name']);

        if (!$folder) {
            return response()->json([
                'success' => false,
                'message' => 'User cannot get requested folder.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $folder
        ], 200);
    }
}
