<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | Coderbook</title>
    <?php include_once 'templates/header/bootstrapcdn.php' ?>
    <script src="./resources/js/functions/time.js"></script>
    <script src="./resources/js/functions/routing.js"></script>
    <script src="./resources/js/models/User.js"></script>
    <script src="./resources/js/models/Message.js"></script>
    <script src="./resources/js/messages.js"></script>
    <link rel="stylesheet" href="./resources/css/home.css">
    <link rel="stylesheet" href="./resources/css/messages.css">
</head>
<body>
    <?php include('templates/notification/connection.php')?>
    <?php include('templates/home/navbar.php'); ?>
    
    <div class="row m-0 p-0 h-100 bg-light" style="height:100vh">

        <div class="col-12 row justify-content-center d-none" style="height:80vh" id="noFriends">
                
                <div class="col-12 align-self-center text-center">
                    <h1 class=" text-muted"> <i class="fas fa-comments p-block"></i></h1>
                    <h4 class=" text-muted" > Agrega amigos para empezar a charlar</h4>
                </div>

        </div>


        <div class="col-6 m-0 p-0" id="friendsList">
            
            <div class="col-12 bg-light px-3 pt-4 row m-0 mb-3">
                <h5 class="align-self-center">Amigos</h5>
            </div>


            <div class="col-12 row m-0 p-2 border-top border-bottom align-items-center d-none" style="cursor:pointer;" id="friendChatModel">
                <div class="col-2 col-lg-1">
                    <div class="pp-bubble" style="background-image: url('');height:50px;width:50px"></div>
                </div>
                <div class="col-8 row m-0 p-0 ml-1 align-self-center">
                    <div class="col-12 row m-0 p-0">
                        <h6 class="ml-2 mt-1 friend-fullname" ><b>name lname</b></h6>
                        <h6 class="ml-2 user-online"> <i class="fas fa-circle text-success" style="font-size:.4em"></i> </h6>
                    </div>
                    <div class="col-12 m-0 p-0 pl-2" >
                        <p style="margin-top:-10px;" class="friend-message"></p>
                    </div>
                </div>
                <div class="col-1 ml-auto">
                    <i class="fas fa-circle text-primary d-none user-seen" style="font-size:.5em"></i>
                </div>
            </div>


        </div>

        <div class="col-6 row justify-content-center" style="height:80vh" id="noFriendChat">
            
            <div class="col-12 align-self-center text-center">
                <h1 class=" text-muted"> <i class="fas fa-comments p-block"></i></h1>
                <h4 class=" text-muted" > ??Saluda a tus amigos hoy!</h4>
            </div>

        </div>

        <div class="col-6 m-0 p-0 shadow-sm d-none" id="friendChat">

           <div class="row m-0 p-0">
           
                <div class="col-12 row m-0 p-0 pl-3 shadow-sm" style="height:70px">
                    <div class="pp-bubble align-self-center" style="background-image: url('http://localhost:8000/media/usr/5/5_1625361480.jpg');"></div>
                    <h6 class="align-self-center ml-2 mt-1 chatbox-friendname" ><b>Dianna Carballo</b></h6>
                    <h6 class="align-self-center ml-2"> <i class="fas fa-circle text-success" style="font-size:.6em"></i> </h6>
                </div>
                


                <div class="col-12 row m-0 p-0 pt-2 align-items-end" style="height:72vh;overflow: auto;" id="chatBox">
                    

                </div>

                <div class="col-12 row m-0 p-0 align-self-end">
                    <div class="col-10 py-2">
                        <textarea style="resize:none;border-radius:2em;" class="form-control post-create-comment" placeholder="Escribe un mensaje..." id="sender-msg" cols="30" rows="1"></textarea>
                    </div>
                    <div class="col-2 py-2">
                        <button class="pp-bubble p-0 text-center bg-primary" style="height:35px;width:35px;font-size:.8em" id="sender-msg-btn"> <i class="fas fa-paper-plane mr-1"></i> </button>
                    </div>
                </div>

           </div>

        </div>

    </div>

    <div id="messageModels" class="d-none">
        <div class="col-12 p-0 m-0 pr-2 pb-2 user-sender">
            <div class="ml-auto bg-primary text-light p-2 message" style="max-width: 50%;">Este es un mensaje cualquiera, es solamente para probar el dise??o del chat lol</div>
        </div>

        <div class="col-12 p-0 m-0 pl-2 pb-2 friend-sender">
            <div class="mr-auto bg-secondary text-light p-2 message" style="max-width: 50%;">Este es un mensaje cualquiera, es solamente para probar el dise??o del chat lol</div>
        </div>
                    
    </div>

</body>
</html>