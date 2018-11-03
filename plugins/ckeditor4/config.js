/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.contentsCss = 'plugins/ckeditor4/fonts.css';
	config.font_names = 'Beautiful Script/Beautiful Script;' + config.font_names;
	config.extraPlugins = 'image_upload';
	config.removePlugins = 'image,flash,iframe,forms';
	config.allowedContent = true;
	//config.extraPlugins = 'ckeditor-gwf-plugin';
	//config.font_names = 'GoogleWebFonts';
};
