<?php 
spl_autoload_register('classLoader');
spl_autoload_register('controllersLoader');
spl_autoload_register('adminControllersLoader');
spl_autoload_register('apiControllersLoader');
spl_autoload_register('cmdControllersLoader');

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
function apiControllersLoader($className){
    $path = RPATH ."/controllers/api/";
    $extension = ".api.php";
    $fullPath = $path . $className . $extension;
    
    if(file_exists($fullPath)){
        include_once $fullPath;
    }else{
        return false;
    }
}
function cmdControllersLoader($className){
    $path = RPATH ."/controllers/cmd/";
    $extension = ".cmd.php";
    $fullPath = $path . $className . $extension;
    
    if(file_exists($fullPath)){
        include_once $fullPath;
    }else{
        return false;
    }
}
function frontControllersLoader($className){
    $path = RPATH ."/controllers/front/";
    $extension = ".front.php";
    $fullPath = $path . $className . $extension;
    
    if(file_exists($fullPath)){
        include_once $fullPath;
    }else{
        return false;
    }
}

?>