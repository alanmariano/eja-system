CKEDITOR.plugins.add( 'image_upload', {
    icons: 'image_upload',
    init: function( editor ) {

        editor.addCommand( 'image_upload', new CKEDITOR.dialogCommand( 'imgDialog' ) );

        

        editor.ui.addButton( 'image_upload', {
            label: 'Banco de imagens',
            command: 'image_upload',
            toolbar: 'insert'
        });


        CKEDITOR.dialog.add( 'imgDialog', this.path + 'dialogs/img.js' );

    }
});