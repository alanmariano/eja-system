<?php
    
    require_once (__DIR__ . "/classes/User.php");

    session_start();

    if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
        header("Location: login.php");
        die();
    }else if($_SESSION['user']->getRole() != "admin"){
        header("Location: index.php");
        die();
    }

?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->

<head>
    <?php require_once ("head.php"); ?>
</head>

<body>


    <?php include "menu.php"; ?>
    <!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <?php include "header.php"; ?>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Cadastro de usuário</h1>
                    </div>
                </div>
            </div>
            <!--<div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>-->
        </div>

        <div class="content mt-3">

            <div class="col-sm-12">
                <!--<div class="alert  alert-success alert-dismissible fade show" role="alert">
                  <span class="badge badge-pill badge-success">Success</span> You successfully read this important alert message.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>-->
            </div>

            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Novo</strong> usuário
                    </div>
                    <div class="card-body card-block">
                        <form action="" method="post" onSubmit="submitForm();return false;" enctype="multipart/form-data" id="new-user-form" class="form-horizontal">
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="name" class=" form-control-label">Nome</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="name" name="name" placeholder="Nome completo" class="form-control"><small class="form-text text-muted">Insira o nome completo do usuário</small></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="email" class=" form-control-label">Email</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="email" name="email" placeholder="Email" class="form-control"><small class="form-text text-muted">Insira o email do usuário</small></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="password" class=" form-control-label">Senha</label></div>
                                <div class="col-12 col-md-9"><input type="password" id="password" name="password" placeholder="Senha" class="form-control"><small class="form-text text-muted">Insira a senha do usuário</small></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label class=" form-control-label">Função</label></div>
                                <div class="col col-md-9">
                                    <div class="form-check">
                                        <div class="radio">
                                            <label for="radioProf" class="form-check-label ">
                                                <input type="radio" id="radioProf" name="role" checked="true" value="teacher" class="form-check-input">Professor
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label for="radioAdmin" class="form-check-label ">
                                                <input type="radio" id="radioAdmin" name="role" value="admin" class="form-check-input">Administrador
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-dot-circle-o"></i> Enviar
                                </button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
            <!--/.col-->


        </div>
        <!-- .content -->
    </div>
    <!-- /#right-panel -->

    <!-- Right Panel -->
    <?php require_once("js.php"); ?>

    <script>

        var notyf = new Notyf();
        
        function submitForm() {

            var data = {
                func: "new_user",
                name: document.getElementById("name").value,
                role: document.querySelector('input[name="role"]:checked').value,
                email: document.getElementById("email").value,
                password: document.getElementById("password").value
            };

            var json = JSON.stringify(data);  

            ajax_handler(function(response){
                console.log(response);
                response = JSON.parse(response);
                if(response.status == "ok"){
                    notyf.confirm('O usuário foi cadastrado com sucesso!');
                    window.scrollTo(0, 0);
                }else{
                    notyf.alert(response.message);
                }
                console.log(response);
            }, json );
            
        }

        ( function ( $ ) {
            "use strict";

            
           
            
           
        } )( jQuery );

        
       

    </script>

</body>

</html>