<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TCC Alan</title>
    <meta name="description" content="TCC Alan">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">




    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="assets/scss/style.css">    
    <link rel="stylesheet" href="assets/css/select2.min.css">  
    <link href="assets/css/lib/vector-map/jqvmap.min.css" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->


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
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Título</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="text-input" name="text-input" placeholder="Título" class="form-control"><small class="form-text text-muted">Insira o título de seu material</small></div>
                            </div>
                            <div class="row form-group">
                            <div class="col col-md-3"><label class=" form-control-label">Material privado</label></div>
                            <div class="col col-md-9">
                              <div class="form-check">
                                <div class="radio">
                                  <label for="radio1" class="form-check-label ">
                                    <input type="radio" id="radio1" name="radios" value="option1" class="form-check-input">Sim
                                  </label>
                                </div>
                                <div class="radio">
                                  <label for="radio2" class="form-check-label ">
                                    <input type="radio" id="radio2" checked="true" name="radios" value="option2" class="form-check-input">Não
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="textarea-input" class=" form-control-label">Tags</label></div>
                                <div class="col-12 col-md-9">
                                <select data-placeholder="Classifique seu material" id="select-tags" class="form-control js-example-tags" multiple="multiple">
                                    
                                </select>
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

    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>


    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/widgets.js"></script>
    <script src="plugins/ckeditor4/ckeditor.js"></script> 
    <script src="assets/js/select2.min.js"></script>   

    <script>

        function ajax_handler(func){
            var xhttp = new XMLHttpRequest();
            try{
                xhttp.open("POST", "ajax_handler.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("tipo=1&message=oieee");
            }catch(err){
                alert("couldnt complete request. Is JS enabled for that domain?\\n\\n" + err.message);
                return false;
            }
            

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    func(this.responseText);
                    //document.getElementById("demo").innerHTML = this.responseText;
                }
            };
        }
        
        function submitForm() {
            ajax_handler(function(teste){
                alert(teste);
            } );
            
        }

        ( function ( $ ) {
            "use strict";

          
           
            $(document).ready(function() {
                CKEDITOR.replace( 'editor' );

                $(".js-example-tags").select2({
                    
                    placeholder: 'Classifique seu material',
                    tags: true
                });
            });
           
        } )( jQuery );

        
       

    </script>

</body>

</html>