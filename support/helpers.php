<?php 

/**
 * This function can be used in a view to version an asset
 * in order to avoid the browser to cache this asset and so
 * not refresh it when there is a modification
 */
function asset_timed($path, $secure=null){
    $file = public_path($path);
    if(file_exists($file)){
        return $path . '?v=' . filemtime($file);
    }else{
        throw new \Exception('The file "'.$path.'" cannot be found in the public folder');
    }
}


function public_path($path)
{
    return $_SERVER['DOCUMENT_ROOT'] . trim($path, '/');
}
