<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <?php include_once 'templates/header/bootstrapcdn.php' ?>
    <script src="./resources/js/functions/time.js"></script>
    <script src="./resources/js/models/User.js"></script>
    <script src="./resources/js/models/Post.js"></script>
    <script src="./resources/js/home.js"></script>
    <script src="./resources/js/comments.js"></script>
    <link rel="stylesheet" href="./resources/css/home.css">
</head>
<body>
    
    <?php include('templates/home/navbar.php'); ?>
    <?php include('templates/notification/connection.php')?>
    <?php include('templates/notification/post_react.php')?>

    <!-- POST CONTENT MODAL -->

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" id="postContent">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Publicar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="sharePostContentBody">
                
                <select class="custom-select custom-select-sm w-25">
                    <option value="public" selected>Publico</option>
                    <option value="private">Privado</option>
                </select>
                <textarea  style="resize: none;" class="form-control mt-1" id="sharedPostContent" placeholder="Escribe algo..." rows="3"></textarea>
                <hr>
                <div class="m-0 p-0" id="sharedPostBody">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="sharePostContent" class="btn btn-primary">Publicar</button>
            </div>
            </div>
        </div>
    </div>

    <!-- END POST MODAL-->

    <div class="row m-0 p-0 mt-2">
    
        <div class="col-3">
        </div>

        <div class="col-6" id="posts">
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

        <div class="col-3">
        </div>
    
    </div>

</body>
</html>