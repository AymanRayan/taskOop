<?php
require 'contentClass.php';


$blog = new Blog();
$id = $_GET['id'];
$oneData = $blog-> ShowOne($id);
$data = mysqli_fetch_array($oneData); 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $blog = new Blog();
    $result =$blog->Edit($id,$_POST,$_FILES,$data);
    foreach ($result as $key => $value) {
        echo '- '.$key.' : '.$value.'<br>';
    }
    header("location: ".'blog.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit the post</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Post here</h2>

        <form action="edite.php?id=<?php echo $data['id'] ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="Name" aria-describedby=""   name="Title" placeholder="The Topic's Title" value="<?php echo $data['title']?>">
            </div>
           <?php
        
              
            ?>

            <div class="form-group">
                <label for="Article">What's in your mind?</label>
                <textarea class="form-control" id="Article" name="Article" rows="5" cols="40" ><?php echo $data['article']?></textarea>
            </div>
            <?php
            
             ?>

            <div class="form-group">
                <label for="myimg">Upload Image</label>
                <input type="file" class="form-control" id="myimg" name="img">
                <img src="<?php echo $data['url']?>" alt="">
            </div>
            <?php
           
            ?>

            <button type="submit" name="submit" class="btn btn-primary">Save</button>
        </form>
    </div> 
</body>
</html>   