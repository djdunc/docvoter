<?php 
/**
 * BY AC : Used to save form data in csv format
 * Expects values to be set in $_POST
 * Authorisation is handled as such:
 * - $_SESSION['user'] must be set
 */
require_once ('../config.php');
require_once ('functions.php');

if(!is('user')) {
//must be logged in to edit
    echo "Not logged in; can't save data";
    die;
}

if ($_REQUEST) {
    foreach ($_REQUEST as $key => $value) {
        if ($key == 'event_id'){
            $file = 'event_'.$value.'.csv';
        } else{
            $headers[] = $key;
            $options[$key]=$value;
        }
    }
} else{
    echo('Error saving data');
    die;
}

$survey_file = SURVEY_PATH.$file;
if (!file_exists($survey_file)) {
    $write_header = true;
}

$sf = fopen($survey_file, 'a');

if (isset($write_header)){
    fputcsv($sf , $headers);
}
fputcsv($sf , $options);
fclose($sf);

$_SESSION['survey']= true;

echo('');

?>
