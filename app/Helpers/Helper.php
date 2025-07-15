<?php
namespace App\Helpers;

class Helper{

    public static function generateID($model, $trow, $prefix, $length=5){
        $data = $model::orderBy('id','desc')->first();  //In the given model, find the latest row
        if(!$data){
            $last_number = 1;   //In case there are no records, the last digit in the id is 1
            $log_length = $length-strlen($last_number);  //Number of zeros will be 4
           
        }else{
            $code = substr($data->$trow, strlen($prefix)+1);    /*In the data look for a row called $trow, 
            the string length is the prefix like 'CUS' plus the '-' sign subtract that string from the code so we eg. 00124*/
            $actual_last_number = intval(preg_replace('/[^0-9]/', '', $code));  // Convert to integer, removing any non-numeric characters
            $increment_last_number = $actual_last_number + 1;  //Next number
            $last_number_length = strlen((string)$increment_last_number);  //Find the number of digits
            $log_length = $length - $last_number_length;  //Number of zeros to be added
            $last_number = $increment_last_number;
        }
        $zeros = "";
        for($i=0; $i<$log_length; $i++){
            $zeros.= "0";  // .= appends 0's each time the loop runs
        }
        return $prefix.'-'.$zeros.$last_number;  
       
    }
}


?>