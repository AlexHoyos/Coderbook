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

        <div class="col-12 col-lg-6 float-right mt-2 mt-lg-0" id="posts">
        <?php include('templates/post/newPost.php'); ?>

        <?php include('templates/post/postTemplate.php'); ?>

        </div>

        <div class="col-3">
        </div>
    
    </div>

</body>
</html>