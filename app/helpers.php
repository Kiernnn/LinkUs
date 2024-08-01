<?php
if (! function_exists('uploadFile')) {
    function uploadFile($file, $directory, $disk = 'public')
    {
        $filename = time() . '.' . $file->getClientOriginalExtension();
        if (!file_exists(public_path($directory))) {
            mkdir(public_path($directory), 0755, true);
        }

        $file->move(public_path($directory), $filename);

        return $filename;
    }
}

?>
