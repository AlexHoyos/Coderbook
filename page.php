<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coderbook</title>
    <?php include_once 'templates/header/bootstrapcdn.php' ?>
    <script src="./resources/js/functions/time.js"></script>
    <script src="./resources/js/functions/reactions.js"></script>
    <script src="./resources/js/functions/routing.js"></script>
    <script src="./resources/js/models/Page.js"></script>
    <script src="./resources/js/models/User.js"></script>
    <script src="./resources/js/models/Post.js"></script>
    <script src="./resources/js/page.js"></script>
    <script src="./resources/js/comments.js"></script>
    <script src="./resources/js/functions/friendRequest.js"></script>
    <link rel="stylesheet" href="./resources/css/home.css">
    <link rel="stylesheet" href="./resources/css/profile.css">
</head>
<body>
    <?php include('templates/notification/connection.php')?>
    <?php include('templates/home/navbar.php'); ?>
    <?php include('templates/notification/post_react.php')?>
    <?php include('templates/post/shareModal.php')?>
    <?php include('templates/post/showImages.php')?>
    <?php include('templates/post/reactions.php')?>
    
    <div class="row m-0 p-0 shadow-sm pb-1 bg-light">
    
        <div class="col-10 row m-0 p-0 mx-auto wallpaper_pic" >

            <div class="profile_pic mr-auto ml-5 mt-auto"></div>

        </div>

        <div class="col-10 row mx-auto mt-5 text-center ">

            <div class="col-12 text-left mr-auto ml-5">
                <h4 class="ml-4"><b id="page_title"></b></h4>
                <p id="page_category" class="ml-5" ></p>
                <hr>
            </div>

            <div class="col-6">
                <nav class="nav nav-pills nav-fill">
                    <a class="nav-item nav-link active" href="#">Publicaciones</a>
                    <a class="nav-item nav-link" href="#">Comunidad</a>
                    <a class="nav-item nav-link" href="#">Fotos</a>
                </nav>
            </div>

            <div class="col-6 text-right d-none no-admin">
                
                <button class="btn btn-outline-primary"> <i class="fas fa-thumbs-up"></i> Chilo</button>

            </div>


            <div class="col-6 text-right d-none admin">
                
                <button class="btn btn-secondary"> <i class="fas fa-cog"></i> Configuracion</button>
                <button class="btn btn-outline-primary" onclick="likePage()" id="likeBtn"> <i class="fas fa-thumbs-up"></i> Chilo</button>

            </div>

        </div>

    </div>

    <div class="row m-0 p-0 mx-auto mt-2">
        <div class="col-0 col-lg-1"></div>
        <div class="col-12 col-lg-4">

            <div class="card">
                <div class="card-body profile_details">
                    <h5 class="card-title">Descripción</h5>
                    <p class="card-text page_description"></p>
                </div>
            </div>
            <div class="card">
                <div class="card-body profile_details">
                    <p class="card-text text-muted" id="page_likes"> <i class="fas fa-thumbs-up text-muted"></i> </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 float-right mt-2 mt-lg-0" id="posts">
            <?php include('templates/post/newPost.php'); ?>

            <?php include('templates/post/postTemplate.php'); ?>
        </div>

    </div>


</body>
</html>