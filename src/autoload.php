<?php

spl_autoload_register(function($class){
  // TODO
  var_dump("Je dois chercher : ".$class);

    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(realpath(__DIR__)));
    foreach ($rii as $file) {
        if ($file->isDir()) continue;
        if($file->getFileName() == $class.".php"){
          var_dump("trouvé !");
          require($file->getPathName()); 
          return;
        }
    }

  throw new Exception("Could not find ".$class);
});