<?php
    class Encoding {
        //Methods
        
        //toUTF8 string converting method
        static function toUTF8($string){
            //Detecting ISO-8859-2 coding (in specific order)
            $coding = mb_detect_encoding($string, "UTF-8,ISO-8859-2");

            //Test lines for checking if everything runs correctly, used for testings
            //Coding of string before encoding
            echo "Coding of string before encoding: $coding<br>";
            //String before encoding
            echo $string;

            //Encoding input string
            $encoded = iconv($coding, "UTF-8", $string);

            //Test lines for checking if everything runs correctly, used for testings
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
    if(array_key_exists('file', $_POST)){
        //Opening sent file on readonly mode
        $handle = fopen($_POST['file'], "r");
        //Variable to hold the string value from file
        $string;
        //Getting user's input from index.html by looping on file lines
        while(($line = fgets($handle)) != false){
            $string = $line;
        }
        //Creating object of Encoding class
        $encode = new Encoding();
        //Creating variable with return value after calling encoding method toUTF8()
        $result = $encode->toUTF8($string);
        //Printing results in disabled text field
        echo "<h3>Encoded string to UTF-8:</h3><br><textarea disabled>$result</textarea>";
    }
?>