<?php
class Validator{
    
   function Clean($input){
       return stripslashes(strip_tags(trim($input)));
   }
    
   function validate($input,$flag,$length = 6){
     $result = true;

    switch($flag){
        case "required":
            if(empty($input)){
                $result = false;
            }
            break;
         
        case "string" : 
            if (!preg_match("/^[a-zA-Z\s']*$/",$input)) {
                 $result = false;
            }
            break; 
        
        
        case "length": 
            if (strlen($input) < $length) {
                $result = false;
            }
            break;

        case "image";    
            $filetype = $input['img']['type'];
            $fileArr = explode('/', $filetype);
            $fileExt = end($fileArr);
            if(!in_array($fileExt ,['jpeg' ,'png'])){
                $result = false;
            }else{
                $imgName = time() . rand().'.'.$fileExt;
                $path = 'img/'.$imgName;
                $result=$path;
            }
    }

    return $result;

   }

}




?>