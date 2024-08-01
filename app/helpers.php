<?php
if (! function_exists('uploadFile')) {
    function uploadFile($file, $directory = 'posts', $filename = null, $disk = 'public')
    {
        $filename = $filename ?: time() . '.' . $file->getClientOriginalExtension();;
        if (!file_exists(public_path($directory))) {
            mkdir(public_path($directory), 0755, true);
        }

        $file->move(public_path($directory), $filename);

        return $filename;
    }
}

?>
