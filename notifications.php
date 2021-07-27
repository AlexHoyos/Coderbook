<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <?php include_once 'templates/header/bootstrapcdn.php' ?>
    <script src="./resources/js/functions/routing.js"></script>
    <script src="./resources/js/functions/time.js"></script>
    <script src="./resources//js/functions/reactions.js"></script>
    <script src="./resources/js/models/User.js"></script>
    <script src="./resources/js/models/Page.js"></script>
    <script src="./resources/js/models/Post.js"></script>
    <script src="./resources/js/notifications.js"></script>
    <link rel="stylesheet" href="./resources/css/home.css">
</head>
<body>
    
    <?php include('templates/home/navbar.php'); ?>
    <?php include('templates/notification/connection.php')?>
    <?php include('templates/notification/post_react.php')?>
    <?php include('templates/post/shareModal.php')?>
    <?php include('templates/post/showImages.php')?>
    <?php include('templates/post/reactions.php')?>
   

    <div class="row m-0 p-0 mt-2 px-2" style="height:80vh">

        <div class="col-12 bg-light p-4" style="height:80vh;overflow:scroll;overflow-x:hidden;">
            
            <h4>Notificaciones</h4>
            <div id="notifications" class="m-0 p-0">
                <a class="dropdown-item p-3 d-none noti-complete-model" href="#"> <i class="fas fa-user-plus text-primary"></i> <b>Pedro</b> quiere ser tu amigo </a>
            </div>

        </div>
    
    </div>

</body>
</html>