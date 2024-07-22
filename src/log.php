<?php

function getTimeStampLog(){
    date_default_timezone_set('Europe/Paris');
    return date("Y-m-d H:i:s");
}

function setLevelLog(int $result){
    try{
        switch($result){
            case 1:
                $result = 'TRACE';
                break;
            case 2:
                $result = 'DEBUG';
                break;
            case 3:
                $result = 'INFO';
                break;
            case 4:
                $result = 'WARNING';
                break;  
            case 5:
                $result = 'ERROR';
                break;
        }
    }
    catch(Exception $e){
        echo "Erreur de typage du niveau";
    }
    return $result;
}


function getCurrentFileLog(){
    return $_SERVER['SCRIPT_NAME'];
}

function setLog(int $level, string $message){
    try{
        $directory = '../var/logs/';
        $filePath = "$directory/log.log";
        $currentFile = getCurrentFileLog();
        $level = setLevelLog($level);
        $user = get_current_user();
        $date = getTimeStampLog();
        $text = sprintf("[%s] %s %s %s %s \r\n",$date, $level,$user, $currentFile, $message);
    
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