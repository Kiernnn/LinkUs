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
        $diffInSeconds = $time->diffInSeconds(now());
        $diffInMinutes = $time->diffInMinutes(now());
        $diffInHours = $time->diffInHours(now());
        $diffInDays = $time->diffInDays(now());

        if ($diffInSeconds < 60) {
            return $diffInSeconds . ' sec ';
        } elseif ($diffInMinutes < 60) {
            return $diffInMinutes . ' m ';
        } elseif ($diffInHours < 24) {
            return $diffInHours . ' h ';
        } elseif ($diffInDays < 2) {
            return '1d';
        } else {
            return $diffInDays . ' d'; // Handles differences greater than 48 hours
        }
    }
}
