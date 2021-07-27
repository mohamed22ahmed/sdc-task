<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Storage;

class FormController extends Controller
{
    public function index()
    {
        return User::paginate(10);
    }

    public function store(Request $request)
    {

        $form = json_decode($request->data);
        
        $fileNewName = upload_file($request);
        if ($fileNewName == 'sizeExceeded')
            return 'sizeExceeded';
        if ($fileNewName == 'extensionError')
            return 'extensionError';

        User::create([
            'name' => $form->name,
            'name_ar' => $form->name_ar,
            'email' => $form->email,
            'brand_name' => $form->brand_name,
            'brand_name_ar' => $form->brand_name_ar,
            'cr' => $fileNewName,
        ]);
    }

    public function update_form_test(Request $request)
    {
        $form = json_decode($request->data);

        $fileNewName = upload_file($request);
        if ($fileNewName == 'sizeExceeded')
            return 'sizeExceeded';
        if ($fileNewName == 'extensionError')
            return 'extensionError';

        $user = User::find((int)$form->id);
        if ($user->cr)
            Storage::delete("public/CR" . "/" . $user->cr);

        $user->update([
            'name' => $form->name,
            'name_ar' => $form->name_ar,
            'email' => $form->email,
            'brand_name' => $form->brand_name,
            'brand_name_ar' => $form->brand_name_ar,
            'cr' => $fileNewName,
        ]);
    }

    public function destroy($id)
    {
        $user = User::find((int)$id);
        if ($user->cr)
            Storage::delete("public/CR" . "/" . $user->cr);
        $user->delete();
    }
}
