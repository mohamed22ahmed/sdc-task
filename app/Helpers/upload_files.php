<?php


/**
 *
 * this file made to upload files with extensions'jpg','jpeg','png','gif','doc','docx','pdf'
 *
 */

function upload_file($request)
{
    $fileNewName = "";
    if ($request->file('photo')) {
        $fileWithExt = $request->file('photo')->getClientOriginalName();
        $fileWithoutExt = pathinfo($fileWithExt, PATHINFO_FILENAME);
        $fileExt = $request->file('photo')->getClientOriginalExtension();

        $size = $request->file('photo')->getSize() / 1048576;
        if ($size > 5)
            return 'sizeExceeded';

        if (strtolower($fileExt) != 'pdf')
            return 'extensionError';

        $fileNewName = $fileWithExt . '_' . time() . '.' . $fileExt;
        $path = $request->file('photo')->storeAs('public/CR', $fileNewName);
        $data = Storage::disk('local')->get($path);
    }

    return $fileNewName;
}
