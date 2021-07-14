<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coderbook</title>
    <?php include_once 'templates/header/bootstrapcdn.php' ?>
    <script src="./resources/js/functions/routing.js"></script>
    <script src="./resources/js/models/User.js"></script>
    <script src="./resources/js/userconfig.js"></script>
    <link rel="stylesheet" href="./resources/css/home.css">
    <link rel="stylesheet" href="./resources/css/profile.css">
</head>
<body>
    <?php include('templates/notification/connection.php')?>
    <?php include('templates/home/navbar.php'); ?>
    <?php include('templates/notification/post_react.php')?>

    <!-- CHANGE PROFILE AND WP PHOTO -->
    <div class="modal" tabindex="-1" role="dialog" id="uploadPicture">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="row m-0 justify-content-center post-profile-img">

                    <div class="col-10 m-1 post-img profile-pic"> </div>
                    <input type="range" class="form-control-range" id="profilePicSize" value="20">
                </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    <!-- end of modal -->

    <div class="row m-3 p-3 bg-light">

        <div class="col-12">
            <h3>Configuracion</h3>
            <hr>
        </div>

        <div class="col-6 p-0 m-0">

            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active" id="btn-profile" onclick="goToMenu('profile')">Perfil</a>
                <a href="#" class="list-group-item list-group-item-action" id="btn-generalInfo"  onclick="goToMenu('generalInfo')">Información General</a>
                <a href="#" class="list-group-item list-group-item-action" id="btn-security"  onclick="goToMenu('security')">Seguridad</a>
                <a href="#" class="list-group-item list-group-item-action text-danger" id="btn-danger"  onclick="goToMenu('danger')">Peligro</a>
            </div>

        </div>

        <div class="col-6 menu" id="profile">
            <h4>Perfil</h4>
            <div class="form-row">

                <div class="col-12">
                    <h5>Foto de perfil</h5>
                    <label for="profilepic" class="btn btn-primary"> <i class="fas fa-upload"></i> Subir foto</label>
                    <!--<label class="btn btn-warning"> <i class="fas fa-images"></i> Seleccionar imagen</label>-->
                    <input type="file" name="profilepic" id="profilepic" onchange="uploadProfileWpPic(event, 'profile')" class="d-none">
                </div>

                <div class="col-12">
                    <h5>Foto de portada</h5>
                    <label for="wppic" class="btn btn-primary"> <i class="fas fa-upload"></i> Subir foto</label>
                   <!--<label class="btn btn-warning"> <i class="fas fa-images"></i> Seleccionar imagen</label>-->
                    <input type="file" name="wppic" id="wppic" onchange="uploadProfileWpPic(event, 'wp')" class="d-none">
                </div>

            </div>
        </div>

        <div class="col-6 menu d-none" id="generalInfo">
            <h4>Información General</h4>
            <div class="form-row">

                <div class="col-6">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>

                <div class="col-6">
                    <label for="lname">Apellido</label>
                    <input type="text" name="lname" id="lname" class="form-control">
                </div>

                <div class="col-6">
                    <label for="usern">Usuario</label>
                    <input type="text" name="username" id="usern" class="form-control">
                </div>

                <div class="col-6">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>

                <div class="col-12">
                    <label for="bio_info">Sobre ti</label>
                    <textarea name="bio_info" id="bio_info" cols="30" rows="5" class="form-control" placeholder="Hablanos de ti (máx 250 caracteres)"></textarea>
                </div>
                <div class="col mt-2">
                    <button type="button" class="btn btn-primary"> <i class="fas fa-save"></i> Guardar</button>
                </div>

            </div>
        </div>

        <div class="col-6 menu d-none" id="security">
        </div>

        <div class="col-6 menu d-none" id="danger">
        </div>

    </div>

</body>
</html>