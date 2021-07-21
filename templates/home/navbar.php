<script src="./resources/js/nav.js"></script>
<!-- CREATE PAGE MODAL -->

<div class="modal" id="createPage" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Crear página</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">

            <div class="col-12">
                <label for="page-title">Título / Nombre de la página</label>
                <input type="text" class="form-control" placeholder="Título" id="page-title">
            </div>

            <div class="col-6">
                <label for="page-visibility">Visibilidad</label>
                <select id="page-visibility" class="form-control">
                    <option value="public" selected>Público</option>
                    <option value="private">Privado</option>
                </select>
            </div>

            <div class="col-6">
                <label for="page-category">Categoria</label>
                <input type="text" class="form-control" placeholder="Ej: Blog personal, Noticiero, Entretenimiento, etc..." id="page-category">
            </div>

            <div class="col-12">
                <label for="page-description">Descripción</label>
                <textarea id="page-description" style="resize:none;" cols="30" rows="3" class="form-control" placeholder="Añade una descripción de tu pagina"></textarea>
            </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="createNewPage()">Crear</button>
      </div>
    </div>
  </div>
</div>

<!---->

<div class="row p-0 m-0 home-nav max-he">

    <div class="col-3">
        <a class="navbar-brand" href="./home.php">
            <img src="./resources/images/logo_white.png" width="160" class="m-4" alt="">
        </a>
    </div>

    <div class="col-4">
    
        <form class="input-group mt-4" action="./search.php">
            <input type="text" class="form-control" name="search" placeholder="Buscar personas, paginas, grupos...">
            <div class="input-group-append">
            <button class="btn btn-light" type="submit">
                <i class="fa fa-search"></i>
            </button>
            </div>
        </form>

    </div>

    <div class="col-4">

        <div class="mt-4 d-flex justify-content-end">
        <!--<button class="button-bubble"><i class="fa fa-plus"></i></button>
        <button class="button-bubble"><i class="fa fa-comment-dots"></i></button>
        <button class="button-bubble"><i class="fa fa-bell"></i></button>
        <button class="button-bubble"><i class="fa fa-chevron-down"></i></button>-->

            <div class="dropdown show">

                
                <button class="button-bubble" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-plus"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#" onclick="openCreatePage()"> <i class="fas fa-file-alt text-warning"></i> Página</a>
                    <a class="dropdown-item" href="#"> <i class="fas fa-users text-danger"></i> Grupo</a>
                </div>
            </div>

            <div class="dropdown show">
                <button class="button-bubble" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-comment-dots"></i>
                    <i class="fas fa-circle text-danger" id="see_msg" style="position:absolute;top:-1px;font-size:10px"></i>
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">msg</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>

            <div class="dropdown show">
                <button class="button-bubble" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <i class="fas fa-circle text-danger" id="see_notif" style="position:absolute;top:-1px;font-size:10px"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" id="last_notifs">
                    <a class="dropdown-item noti-model d-none" href="#"> <i class="fas fa-heart text-danger"></i> <b>Alex Hoyos</b> reaccionó a tu publicacion </a>
                    <!--<a class="dropdown-item" href="#"> <i class="fas fa-user-plus text-primary"></i> <b>Pedro</b> quiere ser tu amigo </a>
                    <a class="dropdown-item" href="#"> <i class="fas fa-comment text-secondary"></i> <b>Victor Garcia</b> comento tu publicacion</a>
                    <a class="dropdown-item" href="#"> <i class="fas fa-comments text-secondary"></i> <b>Francisco Acosta</b> respondio tu comentario</a>
                    <a class="dropdown-item" href="#"> <i class="fas fa-user-tag text-success"></i> <b>Ricardo Ortiz</b> publicó en tu perfil</a>-->
                    <a href="./notifications.php" class="btn btn-link float-right">Ver todas las notificaciones</a>
                </div>
            </div>

            <div class="dropdown show">
                <button class="button-bubble" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-chevron-down"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="./profile.php"> <i class="fas fa-user"></i> Mi perfil</a>
                    <a class="dropdown-item" href="./config.php"> <i class="fas fa-cog"></i> Configuración</a>
                    <a href="./mypages.php" class="dropdown-item"> <i class="fas fa-file-alt"></i> Mis paginas</a>
                    <a href="./mygroups.php" class="dropdown-item"> <i class="fas fa-users"></i> Mis grupos</a>
                    <hr>
                    <a class="dropdown-item" href="./logout.php"> <i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                </div>
            </div>

        </div>

    </div>

</div>