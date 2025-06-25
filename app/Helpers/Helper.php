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
            $actual_last_number = ($code/1)*1;  //Convert the string to a number so 00124 becomes 125
            $increment_last_number = $actual_last_number+1;  //Next cell ~125
            $last_number_length = strlen($increment_last_number);  //Find the number of digits ~3
            $log_length = $length - $last_number_length;  //Number of zeros to be added i.e 5-3 = 2 zeros
            $last_number = $increment_last_number;  //last number is 125,
        }
        $zeros = "";
        for($i=0; $i<$log_length; $i++){
            $zeros.= "0";  // .= appends 0's each time the loop runs
        }
        return $prefix.'-'.$zeros.$last_number;  
       
    }
}
?>