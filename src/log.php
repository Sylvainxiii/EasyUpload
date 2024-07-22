<?php

function getTimeStampLog(){
    date_default_timezone_set('Europe/Paris');
    return date("Y-m-d H:i:s");
}

// function setLevelLog(int $result){

//     try{
//         switch($result){
//             case TRACE:
//                 $result = 'TRACE';
//                 break;
//             case INFO:
//                 $result = 'INFO';
//                 break;
//         }
//     }
//     catch(Exception $e){
//         echo "Erreur de typage du niveau";
//     }
//     return $result;
// }


function getCurrentFileLog(){
    return $_SERVER['SCRIPT_NAME'];
}

function setLog(string $message, string $level="TRACE"){
    try{
        $directory = '../var/logs/';
        $filePath = "$directory/log.log";
        $currentFile = getCurrentFileLog();
        $user = get_current_user();
        $date = getTimeStampLog();
        $text = sprintf("[%s] %s %s %s %s \r\n",$date, $level, $user, $currentFile, $message);
    
        // creer dossier
        if(!is_dir($directory)){
            mkdir($directory, 0777, true);
        }
        
        $file = fopen($filePath, file_exists($filePath) ? 'a' : 'w');
        fwrite($file, $text);
        fclose($file); 
    }
    catch(Exception $e){
        die("Unable to open file!");
    }
    
}
?>