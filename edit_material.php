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
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
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
                            <div class="col col-md-3"><label class=" form-control-label">Material privado</label></div>
                            <div class="col col-md-9">
                              <div class="form-check">
                                <div class="radio">
                                  <label for="radioSim" class="form-check-label ">
                                    <input type="radio" id="radioSim" name="privacy" value="1" class="form-check-input">Sim
                                  </label>
                                </div>
                                <div class="radio">
                                  <label for="radioNao" class="form-check-label ">
                                    <input type="radio" id="radioNao" checked="true" name="privacy" value="0" class="form-check-input">Não
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="textarea-input" class=" form-control-label">Tags</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="select-tags"/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="textarea-input" class=" form-control-label">Conteúdo</label></div>
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

        
        
        function submitForm() {
            var tags = document.getElementsByClassName("selectize-input")[0].children;
            var array_tags = [];
            for(var i=0; i< tags.length; i++){
                if(tags[i].dataset.value != null)
                    array_tags[i] = tags[i].dataset.value;
            }

            var data = {
                func: "edit_material",
                oid: sessionStorage.getItem("i"),
                title: document.getElementById("title").value,
                privacy: document.querySelector('input[name="privacy"]:checked').value,
                tags: array_tags,
                content: CKEDITOR.instances.editor.getData()
            };

            var json = JSON.stringify(data);

            ajax_handler(function(message){
                alert("Deu certo");
                console.log(message);
            }, json );
            
        }

        var r;


        ( function ( $ ) {
            "use strict";

            //init function makes ajax call to fill form fields
            function init(){
                var owner = sessionStorage.getItem("o");
                var id = sessionStorage.getItem("i");

                console.log(id);

                var data = {
                    func: "get_material",
                    oid: id
                };

                var json = JSON.stringify(data);
                
                ajax_handler(function(response){
                    
                    r = JSON.parse(response);

                    document.getElementById("title").value = r[0].titulo;
                    if(r[0].privacidade == 0){
                        document.getElementById("radioNao").checked = true;
                    }else{
                        document.getElementById("radioSim").checked = true;
                    }

                    CKEDITOR.instances.editor.setData(r[0].conteudo);

                    document.getElementById("select-tags").value = r[0].tags; 

                    $('#select-tags').selectize({
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

                }, json );

            }          
           
            $(document).ready(function() {

                CKEDITOR.replace( 'editor' );
                init();
                
            });
           
        } )( jQuery );

        
       

    </script>

</body>

</html>