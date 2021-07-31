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
        // get uploaded file name
        $fileWithExt = $request->file('photo')->getClientOriginalName();

        // get uploaded file path
        $fileWithoutExt = pathinfo($fileWithExt, PATHINFO_FILENAME);

        // get uploaded file extension
        $fileExt = $request->file('photo')->getClientOriginalExtension();

        // to check if file size not greater than 5 miga
        $size = $request->file('photo')->getSize() / 1048576;
        if ($size > 5)
            return 'sizeExceeded';

        // to check if extension is pdf or not
        if (strtolower($fileExt) != 'pdf')
            return 'extensionError';

        // rename the file to prevent duplication
        $fileNewName = $fileWithExt . '_' . time() . '.' . $fileExt;
        // store the files in folder CR
        $path = $request->file('photo')->storeAs('public/CR', $fileNewName);
        $data = Storage::disk('local')->get($path);
    }
    // returning the file name to save into users table
    return $fileNewName;
}
