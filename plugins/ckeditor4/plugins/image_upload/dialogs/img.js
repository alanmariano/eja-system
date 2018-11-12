/*
 Copyright (c) 2018, Alan Mariano da Silva - https://github.com/alanmariano. All rights reserved.
 For licensing, see LICENSE.md
*/

var selectizePlugin;
var search_input_id;
var plugin_tags;
var frame_id;
var path = "http://localhost/tcc";
CKEDITOR.dialog.add( 'imgDialog', function ( editor ) {
    return {
        title: 'Banco de imagens',
        minWidth: 500,
        minHeight: 300,
        contents: [
            {
                id: 'tab-search',
                label: 'Pesquisa de imagens',
                elements: [
                    {
                        type: 'text',
                        id: 'search-input',
                        label: 'Busca de imagens',
                        onShow: function(element){
                            search_input_id = this._.inputId;
                        }
                    },
                    {
                        type: 'button',
                        id: 'btn-search-images',
                        label: 'Buscar',
                        title: 'Buscar imagens',
                        onClick: function() {

                            if(document.getElementById(search_input_id).value != ""){
                                
                                var json = {
                                    func: 'search_images',
                                    titulo: document.getElementById(search_input_id).value
                                };

                                var data = JSON.stringify(json);
                                
                                jQuery.ajax({
                                    url: 'ajax_handler.php', 
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    data: data,                         
                                    type: 'post',
                                    success: function(php_script_response){
                                        var response = JSON.parse(php_script_response);
                                        document.getElementById('div-images-results').innerHTML = '';
                                        var html = '';
                                        response.images.forEach(element => {
                                            html += "<img class='images-result' src = '"+ path + element +"' alt=''>";
                                        });
                                        document.getElementById('div-images-results').innerHTML = html;
                                        //console.log(response); 
                                    },
                                    error: function(error){
                                        console.log(error);
                                    }
                                });
                            }else{
                                console.log("campo de pesquisa vazio");
                            }
                            
                            //alert( 'Clicked: ' + this.id + document.getElementById(search_input_id).value);
                        }
                    },
                    {
                        type: 'html',
                        html: '<div id="div-images-results"> </div>'
                    }
                ]

            },
            {
                id: 'tab-upload',
                label: 'Cadastro de imagem',
                elements: [
                    {
                        type: 'text',
                        id: 'image-tags',
                        label: 'Tags',
                        onShow: function(element){
                            selectizePlugin = jQuery("#"+this._.inputId).selectize({
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
                            plugin_tags = this._.inputId;
                        }
                    },
                    {
                        type: 'file',
                        id: 'image-upload-file',
                        label: 'Selecione a imagem a ser enviada',
                        size: 38,
                        onChange: function(element){
                            frame_id = this._.frameId;
                        }
                    }
                    
                    
                ]
            }
        ],
        onOk: function(){
            //var dialog = this;
            
            var tab = CKEDITOR.dialog.getCurrent().definition.dialog._.currentTabId;

            var img = editor.document.createElement( 'img' );
            
            if(tab == 'tab-upload'){ //upload code
                //creating img html tag

                //getting file
                var iframe = document.getElementById(frame_id).contentDocument || document.getElementById(frame_id).contentWindow.document ;
                var file = iframe.getElementsByName("image-upload-file")[0].files[0]; 
        
                //getting tags
                var tags = selectizePlugin[0].selectize.items;

                var formData = new FormData();
                
                formData.append('file', file);
                formData.append('tags', JSON.stringify(tags));

                jQuery.ajax({
                    url: 'upload.php', 
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,                         
                    type: 'post',
                    success: function(php_script_response){
                        var response = JSON.parse(php_script_response);
                        if(response.status == "ok"){
                            img.setAttribute ( 'src', path+response.img_path );
                            editor.insertElement( img );
                        }
                        console.log(response); 
                    }
                });

            }else if(tab == 'tab-search'){ //if ok is clicked when search is active, try to get selected image to insert into editor html
                if(document.getElementsByClassName('images-result-selected').length > 0){
                    var src = document.getElementsByClassName('images-result-selected')[0].src;
                    img.setAttribute ( 'src', src );
                    editor.insertElement( img );
                }  
            }

            //clear form
            selectizePlugin[0].selectize.clear();
            document.getElementById('div-images-results').innerHTML = '';
            
            
        },
        onCancel: function(){
            selectizePlugin[0].selectize.clear();
            document.getElementById('div-images-results').innerHTML = '';
        }
    };
});

document.addEventListener('click',function(e){
    if(e.target && e.target.classList[0] == 'images-result'){
        if(document.getElementsByClassName('images-result-selected').length > 0){
            document.getElementsByClassName('images-result-selected')[0].classList.remove('images-result-selected'); 
        }
        e.target.className += ' images-result-selected';
    }
 })