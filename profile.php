<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alex Hoyos | Coderbook</title>
    <?php include_once 'templates/header/bootstrapcdn.php' ?>
    <script src="./resources/js/functions/time.js"></script>
    <script src="./resources/js/models/User.js"></script>
    <script src="./resources/js/models/Post.js"></script>
    <script src="./resources/js/profile.js"></script>
    <script src="./resources/js/comments.js"></script>
    <link rel="stylesheet" href="./resources/css/home.css">
    <link rel="stylesheet" href="./resources/css/profile.css">
</head>
<body>
    <?php include('templates/notification/connection.php')?>
    <?php include('templates/home/navbar.php'); ?>
    <div class="row m-0 p-0 shadow-sm pb-1 bg-light">
    
        <div class="col-10 row m-0 p-0 mx-auto wallpaper_pic" >

            <div class="profile_pic mx-auto mt-auto"></div>

        </div>

        <div class="col-10 row mx-auto mt-5 text-center ">

            <div class="col-12">
                <h4><b>Alex Hoyos</b></h4>
                <p>Hola:3</p>
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

            <div class="col-6 text-right">
                
                <button class="btn btn-primary"> <i class="fas fa-user-plus"></i> Agregar</button>
                <button class="btn btn-secondary"> <i class="fas fa-comment-dots"></i></button>

            </div>

        </div>

    </div>


    <div class="row m-0 p-0 mx-auto mt-2">
    <div class="col-1"></div>
    <div class="col-4">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detalles</h5>
                <p class="card-text"> <i class="fas fa-calendar-check text-muted" style="font-size:1.15em"></i> Se unió el 22 de junio de 2021</p>
                <p class="card-text"> <i class="fas fa-birthday-cake text-muted" style="font-size:1.15em"></i> Nació el 8 de marzo de 2002</p>
            </div>
        </div>

        <div class="card mt-2">
            <div class="card-body">
                <h5 class="card-title">Fotos <button href="#" class="btn btn-link card-link float-right" style="font-size:.8em;">Ver todas las fotos</a></h5>
                
                <br>
                <div class="row m-0 p-0 justify-content-center w-100">

                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-1" ></div>
                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-2" ></div>
                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-3" ></div>
                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-4" ></div>
                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-5" ></div>
                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-6" ></div>
                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-7" ></div>
                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-8" ></div>
                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-9" ></div>
                </div>
                
            </div>
        </div>

        <div class="card mt-2">
            <div class="card-body">
                <h5 class="card-title">Amigos <button href="#" class="btn btn-link card-link float-right" style="font-size:.8em;">Ver todas los amigos</a></h5>
                <h6 class="text-muted">780 amigos</h6>
                <br>
                <div class="row m-0 p-0 justify-content-center w-100">

                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-1" ></div>
                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-2" ></div>
                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-3" ></div>
                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-4" ></div>
                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-5" ></div>
                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-6" ></div>
                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-7" ></div>
                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-8" ></div>
                    <div class="col-3 m-1 embed-responsive embed-responsive-1by1 prof-photo profile-photo-9" ></div>
                </div>
                
            </div>
        </div>


    </div>

    <div class="col-6 float-right" id="posts">
        <?php include('templates/post/newPost.php'); ?>

        <div class="card mt-2 d-none" id="postNode">

            <div class="card-body">

            <div class="row m-0 p-0 w-100">
                <div class="pp-bubble post-pp"></div>
                <h6 class="ml-2 mt-2 post-head "><b>name lname</b></h6>
                <h6 class="ml-2 mt-2 post-head d-none"><b class="post-name">name lname</b> ha actualizado su foto de perfil</h6>
                <h6 class="ml-2 mt-2 post-head d-none"><b class="post-name">name lname</b> ha actualizado su foto de portada</h6>
                <h6 class="ml-2 mt-2 post-head d-none"><b class="post-name">name lname</b> compartió una publicación</h6>
                <h6 class="ml-2 mt-2 post-head d-none"><b class="post-name">name lname</b> > <b class="post-target-name">name lname</b></h6>
                <i class="ml-auto fas fa-globe-americas post-privacy mt-1"></i>
                <p class="ml-2 post-time">Hace 1 min</p>
            </div>
            

            <p class="text-justify mt-2 post-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Magni quas quia sunt delectus natus autem odit repellat, dolorum consequuntur numquam nostrum, 
            corporis blanditiis laborum veniam, dolor sed beatae quo at!</p>

            </div>


            <div class="row m-0 justify-content-center post-profile-img d-none">

                <div class="col-10 m-1 post-img profile-pic" > </div>

            </div>

            <div class="row m-0 justify-content-center post-1-img d-none">

                <div class="col-10 m-1 post-img" > </div>

            </div>

            <div class="row m-0 justify-content-center post-2-img d-none">

                <div class="col-5 m-1 post-img" > </div>
                <div class="col-5 m-1 post-img" > </div>

            </div>

            <div class="row m-0 justify-content-center post-3-img d-none">

                <div class="col-10 m-1 post-img" > </div>
                <div class="col-5 m-1 post-img" > </div>
                <div class="col-5 m-1 post-img" > </div>

            </div>

            <div class="row m-0 justify-content-center post-4-img d-none">

                <div class="col-5 m-1 post-img" > </div>
                <div class="col-5 m-1 post-img" > </div>
                <div class="col-5 m-1 post-img" > </div>
                <div class="col-5 m-1 post-img" > </div>

            </div>

            <!-- IF SHARED -->
            <div class="card mx-3 my-0 d-none postNodeShared" id="postNodeShared">
                <div class="card-body">

                    <div class="row m-0 p-0 w-100">
                        <div class="pp-bubble post-pp"></div>
                        <h6 class="ml-2 mt-2 post-head "><b>name lname</b></h6>
                        <h6 class="ml-2 mt-2 post-head d-none"><b class="post-name">name lname</b> ha actualizado su foto de perfil</h6>
                        <h6 class="ml-2 mt-2 post-head d-none"><b class="post-name">name lname</b> ha actualizado su foto de portada</h6>
                        <h6 class="ml-2 mt-2 post-head d-none"><b class="post-name">name lname</b> compartió una publicación</h6>
                        <h6 class="ml-2 mt-2 post-head d-none"><b class="post-name">name lname</b> > <b class="post-target-name">name lname</b></h6>
                        <i class="ml-auto fas fa-globe-americas post-privacy mt-1"></i>
                        <p class="ml-2 post-time">Hace 1 min</p>
                    </div>


                    <p class="text-justify mt-2 post-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    Magni quas quia sunt delectus natus autem odit repellat, dolorum consequuntur numquam nostrum, 
                    corporis blanditiis laborum veniam, dolor sed beatae quo at!</p>

                </div>


                <div class="row m-0 justify-content-center post-profile-img d-none">

                    <div class="col-10 m-1 post-img profile-pic" > </div>

                </div>

                <div class="row m-0 justify-content-center post-1-img d-none">

                    <div class="col-10 m-1 post-img" > </div>

                </div>

                <div class="row m-0 justify-content-center post-2-img d-none">

                    <div class="col-5 m-1 post-img" > </div>
                    <div class="col-5 m-1 post-img" > </div>

                </div>

                <div class="row m-0 justify-content-center post-3-img d-none">

                    <div class="col-10 m-1 post-img" > </div>
                    <div class="col-5 m-1 post-img" > </div>
                    <div class="col-5 m-1 post-img" > </div>

                </div>

                <div class="row m-0 justify-content-center post-4-img d-none">

                    <div class="col-5 m-1 post-img" > </div>
                    <div class="col-5 m-1 post-img" > </div>
                    <div class="col-5 m-1 post-img" > </div>
                    <div class="col-5 m-1 post-img" > </div>

                </div>
            </div>
            <!-- END SHARED -->

            <div class="row m-0 p-0 basic-post-info d-none">
            
                <div class="col-4">
                    <button class="btn btn-link color-gray post-likes"><li class="fas fa-thumbs-up"></li> 10</button>
                </div>
                <div class="col-8 text-right">
                <button class="btn btn-link color-gray post-comments">300 comentarios</button>
                <button class="btn btn-link color-gray post-shares">10 compartidas</button>
                </div>

            </div>
            <div class="row m-0 p-0 border-top border-bottom py-2 basic-actions-post d-none">
                <div class="col-4 text-center">
                   
                        <button class="btn-post-inf px-5 py-2 like-btn">
                        <ul class="reactions-box">
                            <!-- Reaction buttons container-->
                            <li class="reaction reaction-like" data-reaction="Like"></li>
                            <li class="reaction reaction-love" data-reaction="Love"></li>
                            <li class="reaction reaction-haha" data-reaction="HaHa"></li>
                            <li class="reaction reaction-wow" data-reaction="Wow"></li>
                            <li class="reaction reaction-sad" data-reaction="Sad"></li>
                            <li class="reaction reaction-angry" data-reaction="Angry"></li>
                        </ul>
                        </button>
                   

                </div>
                <div class="col-4 text-center">
                    <button class="btn-post-inf px-5 py-2 comment-btn"> <li class="fas fa-comment"></li> Comentar</button>
                </div>
                <div class="col-4 text-center dropdown">
                    <button class="btn-post-inf px-5 py-2" id="shareOptions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <li class="fas fa-share"></li> Compartir</button>
                    <div class="dropdown-menu" aria-labelledby="shareOptions">
                        <button class="dropdown-item post-shareNow"> <i class="fas fa-share-square"></i> Compartir ahora</button>
                        <button class="dropdown-item post-shareWithContent"> <i class="fas fa-edit"></i> Escribir publicacion</button>
                        <button class="dropdown-item"> <i class="fas fa-user-friends"></i> Compartir en el perfil de un amigo</button>
                        <button class="dropdown-item"> <i class="fas fa-link"></i> Copiar enlace</button>
                    </div>
                </div>
                
            </div>

            <div class="row m-0 p-0 py-2 border-bottom post-comments-1 d-none">
                <div class="col-1">
                    <div class="pp-bubble comment-own-pp"></div>
                </div>

                <div class="col-11">
                    <textarea style="resize:none;border-radius:2em;" onkeydown="sendComment(event, this)" class="form-control post-create-comment" placeholder="Añade un comentario..." id="" cols="30" rows="1"></textarea>
                </div>

            </div>
            <div class="row m-0 p-0 py-2 border-bottom post-comments-2 d-none">
                <div class="col-12">
                <p class="text-secondary">Comentarios</p>
                </div>
                

                <div class="col-12 row m-0 p-0 post-comment-model d-none">
                    <div class="col-1">
                        <div class="pp-bubble comment-own-pp"></div>
                    </div>
                    <div class="col-11 pr-2">
                        <div style="border-radius:1.2em;min-height:2.2em;width:auto" class="comment py-2 px-3" style="font-size:0">
                            <button class="btn d-block btn-link p-0 comment-profile-link"><b></b></button>
                            <p class="comment-content"></p>
                        </div>
                        <button class="btn btn-sm btn-link text-secondary m-0 ml-2 p-0 like-btn like-comment">
                        <ul class="reactions-box" style="height:40px;top:-30px">
                            <!-- Reaction buttons container-->
                            <li class="reaction reaction-like" data-reaction="Like"></li>
                            <li class="reaction reaction-love" data-reaction="Love"></li>
                            <li class="reaction reaction-haha" data-reaction="HaHa"></li>
                            <li class="reaction reaction-wow" data-reaction="Wow"></li>
                            <li class="reaction reaction-sad" data-reaction="Sad"></li>
                            <li class="reaction reaction-angry" data-reaction="Angry"></li>
                        </ul>
                        </button>
                        <button class="btn btn-sm btn-link text-secondary m-0 ml-2 d-none">Chilo </button>
                        <button class="btn btn-sm btn-link text-secondary m-0 comment-response-btn" >Responder </button>
                        <button class="btn btn-sm btn-link text-secondary m-0 d-none comment-responses-count">3 respuestas </button>
                        <button class="btn btn-sm btn-link text-secondary m-0 comment-time" disabled>Hace 1d </button>
                        <button class="btn btn-sm btn-link m-0 float-right mr-5 comment-reactions"> <i class="fas fa-thumbs-up"></i> 2</button>
                    </div>
                   <!-- RESPUESTAS -->
                   <div class="col-2"></div>
                   <div class="col-10 row p-0 m-0 my-1 comment-create-response d-none">
                    <div class="col-1"><div class="pp-bubble response-own-pp"></div></div>
                    <div class="col-11">
                            <textarea style="resize:none;border-radius:2em;" onkeydown="sendResponse(event, this)" class="form-control post-create-comment comment-input-response" placeholder="Escribe una respuesta..." id="" cols="30" rows="1"></textarea>
                        </div>
                   </div>
                    <div class="col-2"></div>
                    <div class="col-10 row p-0 m-0 mt-2 comment-responses d-none">
                        <div class="col-12 row m-0 p-0 response-comment-model d-none">
                            <div class="col-1">
                                <div class="pp-bubble response-own-pp"></div>
                            </div>
                            <div class="col-11 pr-2">
                                <div style="border-radius:1.2em;min-height:2.2em;width:auto" class="comment py-2 px-3" style="font-size:0">
                                    <button class="btn d-block btn-link p-0 comment-profile-link response-profile-link"><b></b></button>
                                    <p class="comment-content response-content"></p>
                                </div>
                                <button class="btn btn-sm btn-link text-secondary m-0 ml-2 p-0 like-btn like-response">
                                <ul class="reactions-box" style="height:40px;top:-30px">
                                    <!-- Reaction buttons container-->
                                    <li class="reaction reaction-like" data-reaction="Like"></li>
                                    <li class="reaction reaction-love" data-reaction="Love"></li>
                                    <li class="reaction reaction-haha" data-reaction="HaHa"></li>
                                    <li class="reaction reaction-wow" data-reaction="Wow"></li>
                                    <li class="reaction reaction-sad" data-reaction="Sad"></li>
                                    <li class="reaction reaction-angry" data-reaction="Angry"></li>
                                </ul>
                                </button>
                                <button class="btn btn-sm btn-link text-secondary m-0 response-time" disabled>Hace 1d </button>
                                <button class="btn btn-sm btn-link m-0 float-right mr-5 comment-reactions response-reactions"> <i class="fas fa-thumbs-up"></i> 2</button>
                            </div>
                        </div>
                    </div>
                    

                <!-- FIN DE RESPUESTAS -->


                </div>

            </div>


        </div>


                        <!---->
                        <div class="card mt-2 d-none m-3 shared-post">

                <div class="card-body">

                    <div class="row m-0 p-0 w-100">
                        <div class="pp-bubble post-pp"></div>
                        <h6 class="ml-2 mt-2 shared-post-head "><b>name lname</b></h6>
                        <h6 class="ml-2 mt-2 shared-post-head d-none"><b class="post-name">name lname</b> ha actualizado su foto de perfil</h6>
                        <h6 class="ml-2 mt-2 shared-post-head d-none"><b class="post-name">name lname</b> ha actualizado su foto de portada</h6>
                        <h6 class="ml-2 mt-2 shared-post-head d-none"><b class="post-name">name lname</b> > <b class="post-target-name">name lname</b></h6>
                        <i class="ml-auto fas fa-globe-americas shared-post-privacy mt-1"></i>
                        <p class="ml-2 shared-post-time">Hace 1 min</p>
                    </div>


                    <p class="text-justify mt-2 shared-post-content">SOYY</p>

                </div>

                <div class="row m-0 justify-content-center shared-post-profile-img d-none">

                    <div class="col-10 m-1 post-img profile-pic" > </div>

                </div>

                <div class="row m-0 justify-content-center shared-post-1-img d-none">

                    <div class="col-10 m-1 post-img" > </div>

                </div>

                <div class="row m-0 justify-content-center shared-post-2-img d-none">

                    <div class="col-5 m-1 post-img" > </div>
                    <div class="col-5 m-1 post-img" > </div>

                </div>

                <div class="row m-0 justify-content-center shared-post-3-img d-none">

                    <div class="col-10 m-1 post-img" > </div>
                    <div class="col-5 m-1 post-img" > </div>
                    <div class="col-5 m-1 post-img" > </div>

                </div>

                <div class="row m-0 justify-content-center shared-post-4-img d-none">

                    <div class="col-5 m-1 post-img" > </div>
                    <div class="col-5 m-1 post-img" > </div>
                    <div class="col-5 m-1 post-img" > </div>
                    <div class="col-5 m-1 post-img" > </div>

                </div>
                </div>

                <!---->



        </div>

    </div>

    </div>

</body>
</html>