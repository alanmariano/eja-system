<?php

    require_once (__DIR__ . "/db/db_handler.php");
    $db = new DB_Handler();


    if(isset($_POST["search_input"])){
        $search_input = $_POST["search_input"];
        $query = array (
            "titulo" => $search_input
        );
        $materials = $db->search_materials($query);
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
                    <h1>Resultado da pesquisa: <?php echo $_POST["search_input"]; ?></h1>
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
     
            <?php
                if(is_array($materials)){
                    foreach($materials as $m){

            ?>

                <div class="card" data-id="<?php echo $m["oid"]; ?>">
                    <div class="card-header">
                        <strong class="card-title"><a class="title_links" href="view_material.php?o=1&i=<?php echo $m["oid"]; ?>" > <?php echo $m["titulo"] ?></a>    
                        </strong>                                    
                    </div>
                    <div class="card-body">
                        <div class="row no-gutters">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <strong>Tags: </strong>
                                <?php foreach($m["tags"] as $tag){ ?> 
                                    <span class="badge badge-secondary"><?php echo $tag;?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <button type="button" onclick="edit_material(0,'<?php echo $m['oid']; ?>');" class="btn btn-primary btn-sm float-lg-right float-md-right" style="margin: 2px 5px;" >Editar</button>
                                <button type="button" onclick="view_material(1,'<?php echo $m['oid']; ?>');" class="btn btn-secondary btn-sm float-lg-right float-md-right" style="margin: 2px 5px;" >Visualizar</button>    
                            </div>
                        </div>
                    </div>
                </div>

            <?php
                    }
                }else{
                    echo $materials;
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

    function edit_material(o,i){
        sessionStorage.setItem("o",o);
        sessionStorage.setItem("i",i);
        document.location.href = 'edit_material.php';
    }

    function view_material(o, i){
        sessionStorage.setItem("o",o);
        sessionStorage.setItem("i",i);
        window.open('view_material.php', '_blank');
    }



    ( function ( $ ) {
        "use strict";

       
       
       
       
    } )( jQuery );

    
   

</script>

</body>

</html>