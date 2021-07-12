<div class="row p-0 m-0 home-nav max-he">

    <div class="col-3">
        <a class="navbar-brand" href="#">
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

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
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

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#"> <i class="fas fa-heart text-danger"></i> <b>Alex Hoyos</b> reaccionó a tu publicacion </a>
                    <a class="dropdown-item" href="#"> <i class="fas fa-user-plus text-primary"></i> <b>Pedro</b> quiere ser tu amigo </a>
                    <a class="dropdown-item" href="#"> <i class="fas fa-comment text-secondary"></i> <b>Victor Garcia</b> comento tu publicacion</a>
                    <a class="dropdown-item" href="#"> <i class="fas fa-comments text-secondary"></i> <b>Francisco Acosta</b> respondio tu comentario</a>
                    <a class="dropdown-item" href="#"> <i class="fas fa-user-tag text-success"></i> <b>Ricardo Ortiz</b> publicó en tu perfil</a>
                </div>
            </div>

            <div class="dropdown show">
                <button class="button-bubble" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-chevron-down"></i>
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">msg</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>

        </div>

    </div>

</div>