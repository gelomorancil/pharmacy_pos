<?php

class String_library {

   

    public function compare_string($a,$b){
        if(strcmp($this->format_lstring($a),$this->format_lstring($b))==0)
            return true;
        return false;
    }


    public function format_lstring($str){
        $str = (string) strtolower(trim($str));
        return   $str;
    }

    public function format_ustring($str){
        $str = (string) strtoupper(trim($str));
        return   $str;
    }
    
    public function validate_bool($value){
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public function format_file($file,$auth){
        $file_name = $auth.'_'.($file['name']);
        return $file_name;
    }

    public function format_profile_image($file,$auth){
        $format = explode('.', $file['name']);
        $extension = $format[count($format)-1];
        
       
        $file_name = $auth.'.'.$extension;
        return $file_name;
    }
    public function compressImage($source, $destination, $quality) { 
        // Get image info 
        $imgInfo = getimagesize($source); 
        $mime = $imgInfo['mime']; 
         
        // Create a new image from file 
        
        switch($mime){ 
            case 'image/jpeg': 
                $image = imagecreatefromjpeg($source); 
               imagejpeg($image, $destination, $quality);
                break; 
            case 'image/png': 
                $image = imagecreatefrompng($source); 
                imagepng($image, $destination, 9);
                break; 
            case 'image/gif': 
                $image = imagecreatefromgif($source); 
                imagegif($image, $destination, $quality);
                break; 
            default: 
                $image = imagecreatefromjpeg($source); 
               imagejpeg($image, $destination, $quality);
        } 
         
         
        // Return compressed image 
        return $destination; 
    } 
  }
?>