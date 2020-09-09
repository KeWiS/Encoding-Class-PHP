<?php
    class Encoding {
        //Methods
        
        //toUTF8 string converting method
        static function toUTF8($string){
            //Detecting possibly "false" encoding
            $coding = mb_detect_encoding($string, "UTF-8, ISO-8859-2");
            //If detected encoding is ISO-8859-2 it might be false, if statement checks it
            if($coding == "ISO-8859-2"){
                //Forcing to encode from ISO-8859-2 to Windows-1250, then from Windows-1250 to UTF-8
                //IGNORE after output encoding is for getting rid of bug notice, in this case we care only about results of encoding
                $coding_check = iconv("ISO-8859-2", "Windows-1250//IGNORE", $string);
                $coding_check = iconv("Windows-1250", "UTF-8//IGNORE", $coding_check);
                //Doing normal encoding from ISO-8859-2 to UTF-8
                $check_verification = iconv("ISO-8859-2", "UTF-8", $string);
                //Checking if both conversions are correct, if they are not - coding is Windows-1250, if the are - keep coding ISO-8859-2
                if($check_verification != $coding_check)    $coding = "Windows-1250";
            }

            //Test lines for checking if everything runs correctly, used for testing
            //Coding of string before encoding
            echo "Coding of string before encoding: $coding<br>";
            //String before encoding
            echo $string;

            //Encoding input string
            $encoded = iconv($coding, "UTF-8", $string);

            //Test lines for checking if everything runs correctly, used for testing
            //Detecting if method converted correctly
            $coding_encoded = mb_detect_encoding($encoded, "UTF-8");
            //Coding of string after encoding
            echo "<br>Coding of string after encoding: $coding_encoded<br>";
            //String after encoding
            echo $encoded;

            //Returning encoded string
            return $encoded;
        }
    }
    //Checking if user sent request from button next to text input
    if(array_key_exists('string', $_POST)){
        //Getting user's input from index.html
        $string = $_POST['string'];
        //Creating object of Encoding class
        $encode = new Encoding();
        //Creating variable with return value after calling encoding method toUTF8()
        $result = $encode->toUTF8($string);
        //Printing results in disabled text field
        echo "<h3>Encoded string to UTF-8:</h3><br><textarea disabled>$result</textarea>";
    }
?>