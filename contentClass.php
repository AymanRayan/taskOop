<?php
require_once 'dbconnection.php';
require_once 'validateData.php';

class Blog{
    private $title;
    private $article;
    private $img;
    private $fileTempName;
    private $url;
    
    
  public function addNew($data,$file){
      
    $validator = new Validator();
    $this->title = $validator->Clean($data['Title']);
    $this->article = $validator->Clean($data['Article']);

    $this->img = $file['img']['name'];
    $this->fileTempName =$file['img']['tmp_name'];
    $errors = []; 

    

    if (!$validator->Validate($this->title, 'required')) {      
      $errors['title'] = "Field Required";
     }elseif (!$validator->Validate($this->title, 'string')) {      
      $errors['title'] = "InValid String";
    }
    if (!$validator->Validate($this->article, 'required')) {      
      $errors['article'] = "Field Required";
     }elseif (!$validator->Validate($this->article, 'length',10)) {      
      $errors['article'] = "InValid length";
    }

    
    if (!$validator->Validate($this->img, 'required')) {      
      $errors['img'] = "Field Required";
     }elseif (!$validator->Validate($file, 'image')) {      
      $errors['img'] = "InValid extention";
    }else{
      $path=$validator->Validate($file, 'image');
       if(move_uploaded_file($this->fileTempName,$path)){
           $this->url = $path; 
       }else{
        $errors['img'] = "Error at uploading";
       }
    }


    if(count($errors) > 0){

      $Message = $errors;

    }else{
      $db = new DB();
      $sql = "insert into blog (title,article,url) values ('$this->title','$this->article','$this->url')";
      $op = $db->doQuery($sql);
      if($op){
        $Message = ["message" => "raw inserted"];
      }else{
        $Message = ["message" => "try again"];
      }
     
    } 
    return $Message;
  }


  public function Showall(){
    $db = new DB();
    $sql = "select id ,title , article , url from blog";
    $op =$db->doQuery($sql);
    if($op){
      return $op;
    }else{
      $Message = ["message" => "Can't get the data"];
      return $Message;
    }
  } 

  public function Delete($id){
    $db = new DB();
    $sql="delete from blog where id=$id";
    $op =$db->doQuery($sql);
    if($op){
       return $op;
    }else{
      $Message = ["message" => "Can't delete data"];
      return $Message;
    }
  }

  
  public function Deleteimg($id){
    $db = new DB();
    $sql="select url from blog where id=$id";
    $op =$db->doQuery($sql);
    if($op){
      $data= mysqli_fetch_assoc($op);
      unlink($data['url']);
    }else{
      $Message = ["message" => "Can't delete the image"];
      return $Message;
    }
  }
  
  public function ShowOne($id){
    $db = new DB();
    $sql = "select * from blog where id = $id";
    $op = $db->doQuery($sql);
    if($op){
      return $op;
    }else{
      $Message = ["message" => "Can't find Your data"];
      return $Message;
    }
  }

  public function Edit($id,$data,$file,$blogdata){
    $validator = new Validator();
    $this->title = $validator->Clean($data['Title']);
    $this->article = $validator->Clean($data['Article']);
    $this->img = $file['img']['name'];
    $this->fileTempName =$file['img']['tmp_name'];
    $errors = []; 


    if (!$validator->Validate($this->title, 'required')) {      
      $errors['title'] = "Field Required";
     }elseif (!$validator->Validate($this->title, 'string')) {      
      $errors['title'] = "InValid String";
    }
    if (!$validator->Validate($this->article, 'required')) {      
      $errors['article'] = "Field Required";
     }elseif (!$validator->Validate($this->article, 'length',10)) {      
      $errors['article'] = "InValid length";
    }

    if($validator->validate($this->img,'required')){      
       if (!$validator->Validate($file, 'image')) {      
         $errors['img'] = "InValid extention";
       }else{
          $path=$validator->Validate($file, 'image');
         if(move_uploaded_file($this->fileTempName,$path)){
           unlink($blogdata['url']);
           $this->url = $path; 
         }else{
          $errors['img'] = "Error at uploading";
        }
     }
    }else{
    $this->url = $blogdata['url'];
    }
    if(count($errors) > 0 ){

      $Message = $errors;

    }else{
    $db = new DB();
    $sql = "update blog set title ='$this->title', article = '$this->article',url = '$this->url' where id = $id";
    $op = $db->doQuery($sql);
    if($op){
      $Message = ["message" => "data unpdated successfuly"];
    }else{
      $Message = ["message" => "can't update the data"];
    }
   
   } 
    return $Message;

 }

}
?>