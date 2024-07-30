<?php
$modules = [
    'boat',
    'car',
    'tour',
    'hotel',
    'event',
    'flight'
];
$folderNames = [
    'bookingHistory',
    'bookingReport',
    'booking',
    'profile',
    'manage'
];
foreach ($modules as $module){
    foreach ($folderNames as $folder_name){
        $folder = __DIR__.'/themes/BC/'.ucfirst($module).'/Views/frontend';
        $destFolder = __DIR__.'\themes\Base\\'.ucfirst($module).'\Views\frontend';

        if($folder_name == 'manage') $folder_name.=ucfirst($module);

        $folder.='/'.$folder_name;
        echo $folder.PHP_EOL;
        if(!is_dir($folder)) continue;
        $destFolder.='\\'.$folder_name;
        recurse_copy($folder,$destFolder);
        rrmdir($folder);
    }
}
function recurse_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst,0777,true);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}
function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
                    rrmdir($dir. DIRECTORY_SEPARATOR .$object);
                else
                    unlink($dir. DIRECTORY_SEPARATOR .$object);
            }
        }
        rmdir($dir);
    }
}

