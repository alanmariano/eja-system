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
                        label: 'Busca de imagens'
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
                            jQuery("#"+this._.inputId).selectize({
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
            var img = editor.document.createElement( 'img' );

            var url = "upload.php";

            var iframe = document.getElementById(frame_id).contentDocument || document.getElementById(frame_id).contentWindow.document ;
            var file = iframe.getElementsByName("image-upload-file")[0].files[0]; 
            console.log(file);
            var formData = new FormData();
            
            formData.append('file', file);

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