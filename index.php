<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CoderBook</title>
    <?php include_once 'templates/header/bootstrapcdn.php' ?>
    <script src="resources/js/index.js"></script>
</head>
<body>

    <?php include('templates/index/navbar.php') ?>

    <div class="row m-0 p-0 mt-4 px-2">

        <div class="d-none d-md-block col-6">

            <h2 class="w-100 text-center text-gray">Únete a la comunidad</h2>
            <p class="text-justify mt-2 w-50 mx-auto">
                Unete a este pequeño proyecto el cual es una red social en donde podras interactuar con otras personas.
                Sé que no es el mejor diseño pero lo que importa es lo de adentro:)
            </p>
            <div class="w-100 text-center">
                <img src="./resources/images/icon.png" alt="">
            </div>

        </div>

        <div class="col-12 col-md-6">
            
            <div class="form-row">
            <div class="form-group col-md-6">
                    <label for="inputEmail4">Nombre(s)</label>
                    <input type="text" class="form-control" id="rname" placeholder="Nombre(s)">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Apellido</label>
                    <input type="text" class="form-control" id="rlname" placeholder="Apellido">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Usuario</label>
                    <input type="text" class="form-control" id="rusern" placeholder="Usuario">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Email</label>
                    <input type="email" class="form-control" id="remail" placeholder="Email">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Contraseña</label>
                    <input type="password" class="form-control" id="rpassw" placeholder="Contraseña">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Repite contraseña</label>
                    <input type="password" class="form-control" id="rrpassw" placeholder="Contraseña">
                </div>
            </div>
                <label><input type="checkbox" id="cbox1" value="first_checkbox"> Acepto terminos y condiciones</label><br>
                <button type="submit" class="btn btn-primary">Unirme</button>

            </div>

    </div>

</body>
</html>