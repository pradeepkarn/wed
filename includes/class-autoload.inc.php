<?php 
spl_autoload_register('classLoader');
spl_autoload_register('controllersLoader');
spl_autoload_register('adminControllersLoader');

function classLoader($className){
    $path = RPATH ."/classes/";
    $extension = ".class.php";
    $fullPath = $path . $className . $extension;
    if(file_exists($fullPath)){
        include_once $fullPath;
    }else{
        return false;
    }
}
function controllersLoader($className){
    $path = RPATH ."/controllers/";
    $extension = ".ctrl.php";
    $fullPath = $path . $className . $extension;
    
    if(file_exists($fullPath)){
        include_once $fullPath;
    }else{
        return false;
    }
}
function adminControllersLoader($className){
    $path = RPATH ."/controllers/admin/";
    $extension = ".ctrl.php";
    $fullPath = $path . $className . $extension;
    
    if(file_exists($fullPath)){
        include_once $fullPath;
    }else{
        return false;
    }
}

?>