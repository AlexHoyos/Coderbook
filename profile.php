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
    <script src="./resources/js/models/User.js"></script>
    <script src="./resources/js/models/Page.js"></script>
    <script src="./resources/js/models/Post.js"></script>
    <script src="./resources/js/home.js"></script>
    <script src="./resources/js/profile.js"></script>
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

            <div class="profile_profile_pic mx-auto mt-auto"></div>

        </div>

        <div class="col-10 row mx-auto mt-5 text-center ">

            <div class="col-12">
                <h4><b id="profile_fullname"></b></h4>
                <p id="profile_info"></p>
                <hr>
            </div>

            <div class="col-6">
                <nav class="nav nav-pills nav-fill">
                    <a class="nav-item nav-link active" href="#">Publicaciones</a>
                    <a class="nav-item nav-link" href="#">Amigos</a>
                    <a class="nav-item nav-link" href="#">Fotos</a>
                    <a class="nav-item nav-link" href="#">Videos</a>
                    <a class="nav-item nav-link" href="#">Más</a>
                </nav>
            </div>

            <div class="col-6 text-right d-none friendship_box no_friend_box">
                
                <button class="btn btn-primary"> <i class="fas fa-user-plus"></i> Agregar</button>

            </div>

            <div class="col-6 text-right d-none friendship_box friend_box">
                
                <button class="btn btn-primary"> <i class="fas fa-user-minus"></i> Eliminar</button>
                <button class="btn btn-secondary"> <i class="fas fa-comment-dots"></i></button>

            </div>

            <div class="col-6 text-right d-none friendship_box sent_box">
                
                <button class="btn btn-danger"> <i class="fas fa-user-minus"></i> Eliminar peticion</button>

            </div>

            <div class="col-6 text-right d-none friendship_box pending_box">
                
                <button class="btn btn-danger"> <i class="fas fa-user-minus"></i> Eliminar</button>
                <button class="btn btn-primary"> <i class="fas fa-user-plus"></i> Aceptar</button>

            </div>

            <div class="col-6 text-right d-none friendship_box yourself_box">
                
                <a class="btn btn-secondary" href="./config.php"> <i class="fas fa-cog"></i> Configuracion</a>

            </div>

        </div>

    </div>



    <div class="row m-0 p-0 mx-auto mt-2">
        <div class="col-0 col-lg-1"></div>
        <div class="col-12 col-lg-4">

            <div class="card">
                <div class="card-body profile_details">
                    <h5 class="card-title">Detalles</h5>
                    <p class="card-text profile_detail d-none"> <i class="fas text-muted" style="font-size:1.15em"></i> </p>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-body">
                    <h5 class="card-title">Fotos <button href="#" class="btn btn-link card-link float-right" style="font-size:.8em;">Ver todas las fotos</a></h5>
                    
                    <br>
                    <div class="row m-0 p-0 justify-content-center w-100">

                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-1 d-none" ></div>
                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-2 d-none" ></div>
                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-3 d-none" ></div>
                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-4 d-none" ></div>
                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-5 d-none" ></div>
                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-6 d-none" ></div>
                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-7 d-none" ></div>
                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-8 d-none" ></div>
                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-9 d-none" ></div>
                    </div>
                    
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-body">
                    <h5 class="card-title">Amigos <button href="#" class="btn btn-link card-link float-right" style="font-size:.8em;">Ver todas los amigos</a></h5>
                    <h6 class="text-muted " id="total_friends">780 amigos</h6>
                    <br>
                    <div class="row m-0 p-0 justify-content-center w-100">

                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo d-none friend-photo-1" ></div>
                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo d-none friend-photo-2" ></div>
                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo d-none friend-photo-3" ></div>
                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo d-none friend-photo-4" ></div>
                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo d-none friend-photo-5" ></div>
                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo d-none friend-photo-6" ></div>
                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo d-none friend-photo-7" ></div>
                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo d-none friend-photo-8" ></div>
                        <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo d-none friend-photo-9" ></div>
                    </div>
                    
                </div>
            </div>


        </div>

        <div class="col-12 col-lg-6 float-right mt-2 mt-lg-0" id="posts">
            <?php include('templates/post/newPost.php'); ?>

            <?php include('templates/post/postTemplate.php'); ?>
        </div>

        </div>

    </div>

</body>
</html>