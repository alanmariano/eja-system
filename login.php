<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->
<?php 

    session_start();
    
    if(isset($_SESSION['logged']) && $_SESSION['logged']){
        header("Location: index.php");
        die();
    }

?>

<head>

    <?php require_once ("head.php"); ?>

</head>

<body class="bg-dark">


    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.html">
                        <img class="align-content" style="width: 40%" src="images/logo.png" alt="">
                    </a>
                </div>
                <div class="login-form">
                    <form action="" method="post" onSubmit="submitForm();return false;" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label>Senha</label>
                            <input type="password" id="password" class="form-control" placeholder="Senha">
                        </div>
                        <!--<div class="checkbox">
                            <label>
                                <input type="checkbox"> Manter conectado
                            </label>

                        </div>-->
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Entrar</button>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php require_once("js.php"); ?>

    <script>

        
        var notyf = new Notyf();

        function submitForm() {

            var data = {
                func: "login",
                email: document.getElementById("email").value,
                password: document.getElementById("password").value
            };


            var json = JSON.stringify(data);

            ajax_handler(function(response){
                response = JSON.parse(response);
                if(response.status == "ok"){
                    notyf.confirm(response.message);
                    document.location.href = 'index.php';
                }else{
                    notyf.alert(response.message);
                }
            }, json );

        }
    </script>


</body>
</html>
