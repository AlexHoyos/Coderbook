<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrar sesión</title>
</head>
<body>
    
<script>

    window.onload = function(){
        window.localStorage.removeItem('user_id');
        window.localStorage.removeItem('api_token');
        window.location.href = './'
    }

</script>

</body>
</html>