<?php

    require_once (__DIR__ . "/classes/User.php");

    session_start();

    if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
        header("Location: login.php");
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

        <div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="smallmodalLabel">Importar material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Escolha o material (em formato .pnj ou .jpg) para importar seu texto
                        </p>
                        <form action="" method="post" enctype="multipart/form-data" id="import-material-form" class="form-horizontal">
                            <input type="file" name="import-material" />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="import_material();" >Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Cadastro de material</h1>
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
                        <strong>Novo</strong> material didático
                    </div>
                    <div class="card-body card-block">
                        <form action="" method="post" onSubmit="submitForm();return false;" enctype="multipart/form-data" id="new-material-form" class="form-horizontal">
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="title" class=" form-control-label">Título</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="title" name="title" placeholder="Título" class="form-control"><small class="form-text text-muted">Insira o título de seu material</small></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label class=" form-control-label">Privacidade</label></div>
                                <div class="col col-md-9">
                                    <div class="form-check">
                                        <div class="radio">
                                            <label for="radioPublico" class="form-check-label ">
                                                <input type="radio" id="radioPublico" name="privacy" value="publico" onClick="radioClick(this);" class="form-check-input" checked="true">Público
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label for="radioPrivado" class="form-check-label ">
                                                <input type="radio" id="radioPrivado" name="privacy" value="privado" onClick="radioClick(this);" class="form-check-input">Privado
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label for="radioRestrito" class="form-check-label ">
                                                <input type="radio" id="radioRestrito" name="privacy" value="restrito" onClick="radioClick(this);" class="form-check-input">Restrito
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="shareList" class=" form-control-label">Compartilhar com</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="shareList" name="shareList" placeholder="Compartilhar com" ><small class="form-text text-muted">Insira os emails dos usuários que poderão acessar o material</small></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="textarea-input" class="form-control-label">Tags</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="select-tags" />
                                    <small class="form-text text-muted">Insira as tags do material para facilitar a pesquisa</small>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="textarea-input" class="form-control-label">Conteúdo</label>
                                    <br />
                                    <button type="button" data-toggle="modal" data-target="#smallmodal" class="btn btn-outline-primary btn-sm"><i class="fa fa-upload"></i>&nbsp; Importar</button>
                                </div>
                                <div class="col-12 col-md-9">
                                    <textarea id="editor">
                                    </textarea>
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
        var selectizeNew;
        var selectizeShareList;

        function submitForm() {

            var data = {
                func: "new_material",
                title: document.getElementById("title").value,
                privacy: document.querySelector('input[name="privacy"]:checked').value,
                tags: selectizeNew[0].selectize.items,
                shareList: selectizeShareList[0].selectize.items,
                content: CKEDITOR.instances.editor.getData()
            };

            var json = JSON.stringify(data);

            console.log(json);  

            ajax_handler(function(response){
                response = JSON.parse(response);
                if(response.status == "ok"){
                    notyf.confirm('O material foi cadastrado com sucesso!');
                    window.scrollTo(0, 0);
                }else{
                    notyf.alert(response.message);
                }
                console.log(response);
            }, json );
            
        }

        function radioClick(element){
            if(element.value=="restrito"){
                selectizeShareList[0].selectize.enable();
            }else{
                selectizeShareList[0].selectize.disable();
            }
        }

        function import_material(){
            var files = document.querySelector('input[name=import-material]').files;
            
            var data = new FormData();
            data.append("file", files[0]);

            console.log(data);

            var xhttp = new XMLHttpRequest();
            try{
                xhttp.open("POST", "ocr.php", true);
                xhttp.send(data);
            }catch(err){
                alert("couldnt complete request. Is JS enabled for that domain?\\n\\n" + err.message);
                return false;
            }
            
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var result = JSON.parse(this.responseText);
                    if(result.status == "ok"){
                        CKEDITOR.instances.editor.setData(CKEDITOR.instances.editor.getData()+result.data);
                    }else{
                        notyf.alert(result.message);
                    }
                }else{
                    console.log(this.responseText);
                }
            };

        }


        ( function ( $ ) {
            "use strict";            
           
            $(document).ready(function() {

                CKEDITOR.replace( 'editor' );

                selectizeNew = $('#select-tags').selectize({
                    delimiter: ',',
                    persist: false,
                    create: function(input) {
                        return {
                            value: input,
                            text: input
                        }
                    },
                    render: {
                        option_create: function (data, escape) {
                            return '<div class="create">Adicionar <strong>' + escape(data.input) + '</strong>&hellip;</div>';
                        }
                    }
                });

                var REGEX_EMAIL = '([a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@' +
                  '(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)';

                selectizeShareList = $('#shareList').selectize({
                    delimiter: ',',
                    persist: false,
                    create: function(input) {
                        if ((new RegExp('^' + REGEX_EMAIL + '$', 'i')).test(input)) {
                            return {
                                value: input,
                                text:input
                                };
                        }                        
                        notyf.alert("Email inválido");
                        return false;
                    },
                    render: {
                        option_create: function (data, escape) {
                            return '<div class="create">Adicionar <strong>' + escape(data.input) + '</strong>&hellip;</div>';
                        }
                    }
                });

                
                selectizeShareList[0].selectize.disable();

            });
           
        } )( jQuery );

        
       

    </script>

</body>

</html>