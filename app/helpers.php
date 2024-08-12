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

if (! function_exists('deleteFile')) {
    function deleteFile($file, $directory, $disk = 'public')
    {
        $filePath = public_path($directory . '/' . $file);

        if (file_exists($filePath)) {
            unlink($filePath);
            return true;
        }

        return false;
    }
}


if (!function_exists('timeDiffInHours')) {
    function timeDiffInHours($time)
    {
        $diffInHours = $time->diffInHours(now());
        if ($diffInHours < 24) {
            return $diffInHours . ' hr';  // This returns hours with 'hr'
        } elseif ($diffInHours < 48) {
            return '1 day';  // This handles the case where the difference is less than 48 hours but more than 24 hours
        } else {
            return $time->diffForHumans();  // This handles differences greater than 48 hours
        }
    }
}
