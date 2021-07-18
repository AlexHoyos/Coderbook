<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <?php include_once 'templates/header/bootstrapcdn.php' ?>
    <script src="./resources/js/functions/time.js"></script>
    <script src="./resources//js/functions/reactions.js"></script>
    <script src="./resources/js/models/User.js"></script>
    <script src="./resources/js/models/Page.js"></script>
    <script src="./resources/js/models/Post.js"></script>
    <script src="./resources/js/home.js"></script>
    <script src="./resources/js/comments.js"></script>
    <link rel="stylesheet" href="./resources/css/home.css">
</head>
<body>
    
    <?php include('templates/home/navbar.php'); ?>
    <?php include('templates/notification/connection.php')?>
    <?php include('templates/notification/post_react.php')?>
    <?php include('templates/post/shareModal.php')?>
   

    <div class="row m-0 p-0 mt-2">
    
        <div class="col-3">
        </div>

        <div class="col-12 col-lg-6 float-right mt-2 mt-lg-0" id="posts">
        <?php include('templates/post/newPost.php'); ?>

        <?php include('templates/post/postTemplate.php'); ?>

        </div>

        <div class="col-3">
        </div>
    
    </div>

</body>
</html>