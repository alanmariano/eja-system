var selectizePlugin;
var search_input_id;
var plugin_tags;
var frame_id;
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
                                        console.log(response); 
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
            var dialog = this;
            
            //creating img html tag
            var img = editor.document.createElement( 'img' );

            //getting file
            var iframe = document.getElementById(frame_id).contentDocument || document.getElementById(frame_id).contentWindow.document ;
            var file = iframe.getElementsByName("image-upload-file")[0].files[0]; 
            console.log(file);
    
            //getting tags
            var tags = selectizePlugin[0].selectize.items;
            console.log(tags);

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
                        img.setAttribute ( 'src', "http://localhost/tcc"+response.img_path );
                        editor.insertElement( img );
                    }
                    console.log(response); 
                }
            });

        }
    };
});