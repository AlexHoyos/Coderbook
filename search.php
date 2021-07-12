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
    <script src="./resources/js/models/Post.js"></script>
    <script src="./resources/js/search.js"></script>
    <script src="./resources/js/comments.js"></script>
    <link rel="stylesheet" href="./resources/css/home.css">
</head>
<body>
    
    <?php include('templates/home/navbar.php'); ?>
    <?php include('templates/notification/connection.php')?>
    <?php include('templates/notification/post_react.php')?>

    <div class="row m-0 p-0 d-flex justify-content-center mt-2">

        <div class="col-12 col-lg-8 bg-light py-2 px-3">
            
            <h4>Resultados de: </h4>
            <h6 class="text-muted" id="resultsOf"></h6>

            <div class="w-100 m-0 p-0 text-center d-none" id="noResults">
                <h5 class="text-muted" >Sin resultados</h5>
            </div>

            <div class="row m-0 p-0 mt-2 flex-column d-none" id="usersList">
                <h5>Usuarios: </h5>

                <div class="col-12 row m-0 p-2 border-top border-bottom align-items-center d-none" style="cursor:pointer;" id="userModel">
                    <div class="col-2 col-lg-1">
                        <div class="pp-bubble" style="background-image: url('');height:50px;width:50px"></div>
                    </div>
                    <div class="col-8 row m-0 p-0 ml-1 align-self-center">
                        <div class="col-12 row m-0 p-0">
                            <h6 class="mt-1 user-fullname" ><b>Alex Hoyos</b></h6>
                        </div>
                    </div>
                </div>



            </div>

        </div>

    </div>

</body>
</html>