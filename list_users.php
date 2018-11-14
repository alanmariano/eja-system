<?php

    require_once (__DIR__ . "/db/db_handler.php");
    require_once (__DIR__ . "/classes/User.php");

    session_start();

    if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
        header("Location: login.php");
        die();
    }else if($_SESSION['user']->getRole() != "admin"){
        header("Location: index.php");
        die();
    }

    $db = new DB_Handler();

    $query = array();
    $options = array(
        "sort" => array(
            "nome" => 1
        ),
        "projection" => array(
            "materiais" => 0,
            "senha"     => 0
        )
    );

    $users = $db->get_users($query, $options);

    
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
    
    <style>
        .title_links{
            color: #000;
        }
    </style>
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
                        <h1>Lista de usuários</h1>
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

            <div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodalLabel">Deleção de usuário</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    Você está deletando o usuário "<strong id="delete_user_email"></strong>", deseja continuar?
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="confirm_delete_user();" >Confirmar</button>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="col-sm-12">
                <!--<div class="alert  alert-success alert-dismissible fade show" role="alert">
                  <span class="badge badge-pill badge-success">Success</span> You successfully read this important alert message.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>-->
            </div>


            <div class="col-sm-12 col-md-12 col-lg-12">
         
                <?php
                    if(is_array($users)){
                        foreach($users as $u){

                ?>

                    <div class="card" data-id="<?php echo $u['oid']; ?>">
                        <div class="card-header">
                            <strong class="card-title"><?php echo $u['nome'] ?>
                                <small>
                                    <?php if($u['funcao'] == 'teacher'){ ?>
                                        <span class="badge badge-success float-right mt-1">Professor</span>
                                    <?php }else{ ?>
                                        <span class="badge badge-dark float-right mt-1">Administrador</span>
                                    <?php } ?>
                                </small>
                            </strong>                                    
                        </div>
                        <div class="card-body">
                            <div class="row no-gutters">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <strong>Email: <?php echo $u['email'];?></strong>                                    
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <button type="button" data-toggle="modal" data-target="#smallmodal" onclick="delete_user('<?php echo $u['oid']; ?>','<?php echo $u['email'] ?>');" class="btn btn-danger btn-sm float-lg-right float-md-right" style="margin: 2px 5px;" >Deletar</button>
                                    <button type="button" onclick="edit_user('<?php echo $u['oid']; ?>');" class="btn btn-primary btn-sm float-lg-right float-md-right" style="margin: 2px 5px;" >Editar</button>   
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                        }
                    }else{
                        echo $users;
                    }
                
                ?>
                
            </div>
            <!--/.col-->

        </div>
        <!-- .content -->
    </div>
    <!-- /#right-panel -->

    <!-- Right Panel -->

    <?php require_once("js.php"); ?>

    <script>

        var json;

        var notyf = new Notyf();

        function edit_user(i){
            sessionStorage.setItem("id_user_edit",i);
            document.location.href = 'edit_user.php';
        }


        function delete_user(i, e){

            document.getElementById("delete_user_email").innerHTML = e;

            data = {
                func: "delete_users",
                oids: [
                    i
                ]
            }
            json  = JSON.stringify(data);

        }

        function confirm_delete_user(){
            var ids = JSON.parse(json);
            ajax_handler(function(response){
                response = JSON.parse(response);
                console.log(response);
                if(response.status == "ok"){
                    for(var i=0; i<ids.oids.length; i++){
                        document.querySelectorAll("[data-id='"+ids.oids[i]+"']")[0].outerHTML = "";
                    }
                    notyf.confirm('O usuário foi removido com sucesso!');
                }                
            }, json );
        }
         


        ( function ( $ ) {
            "use strict";
           
           
        } )( jQuery );

        
       

    </script>

</body>

</html>