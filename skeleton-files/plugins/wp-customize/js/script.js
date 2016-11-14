jQuery(document).ready(function($){

	// fade away update messages
	setTimeout(function(){
		$('.fade').fadeOut('slow');
	}, 5000);

    // spectrum color picker
    $("#wpcustomize_admin_bgcolor, #wpcustomize_admin_linkcolor, #wpcustomize_admin_linkhovercolor").spectrum({
        showPalette: true,
        showInput: true,
        preferredFormat: "hex3",
        palette: [
            ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
            ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
            ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
            ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
            ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
            ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
            ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
            ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"],
            ["#b6b6b6","#4c99ef"]
        ]
    });

    // media library upload file inputs
    $('.upload_button').click(function(e) {
        e.preventDefault();
        var btnClicked = $( this );
        var custom_uploader = wp.media({
            title: 'Select a File',
            button: {
                text: 'Upload Image'
            },
            multiple: false  // Set this to true to allow multiple files to be selected
        })
        .on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $( btnClicked ).parent().children( '.uploadfile' ).val( attachment.url );
        })
        .open();
    });

    // ace editor
    if ( typeof( ace ) !== 'undefinded' ) {

        /**
         * Custom CSS Textarea
         */
        if( $('textarea[id$="custom_css]"]').length ) {
            var custom_css_textarea = $('textarea[id$="custom_css]"]');
                custom_css_textarea.parents('tr').find('td').prop('colspan','2');
                custom_css_textarea.parents('tr').find('th').remove();
            $('<div id="custom_login[custom_css]_ace"/>').insertAfter(custom_css_textarea);
            var custom_css = ace.edit("custom_login[custom_css]_ace");
            custom_css.setOptions({
                minLines: 8,
                maxLines: 25,
                showGutter: true,
                displayIndentGuides: true,
                autoScrollEditorIntoView: true
            });
            custom_css.$blockScrolling = Infinity;
            custom_css.getSession().setMode("ace/mode/css");
            custom_css.setTheme("ace/theme/github");
            custom_css_textarea.hide();
            custom_css.getSession().setValue(custom_css_textarea.val());
            custom_css.getSession().on('change', function(){
                custom_css_textarea.val(custom_css.getSession().getValue());
            });
            custom_css.session.setUseWorker(true);
        }

        /**
         * Custom HTML Textarea
         */
        if( $('textarea[id$="custom_html]"]').length ) {
            var custom_html_textarea = $('textarea[id$="custom_html]"]');
                custom_html_textarea.parents('tr').find('td').prop('colspan','2');
                custom_html_textarea.parents('tr').find('th').remove();
            $('<div id="custom_login[custom_html]_ace"/>').insertAfter(custom_html_textarea);
            var custom_html = ace.edit("custom_login[custom_html]_ace");
            custom_html.setOptions({
                minLines: 8,
                maxLines: 25,
                showGutter: true,
                displayIndentGuides: false,
                autoScrollEditorIntoView: true
            });
            custom_html.$blockScrolling = Infinity;
            custom_html.getSession().setMode("ace/mode/html");
            custom_html.setTheme("ace/theme/github");
            custom_html_textarea.hide();
            custom_html.getSession().setValue(custom_html_textarea.val());
            custom_html.getSession().on('change', function(){
                custom_html_textarea.val(custom_html.getSession().getValue());
            });
            custom_html.session.setUseWorker(false);
        }

        /**
         * Custom JS Textarea
         */
        if( $('textarea[id$="custom_jquery]"]').length ) {
            var custom_js_textarea = $('textarea[id$="custom_jquery]"]');
                custom_js_textarea.parents('tr').find('td').prop('colspan','2');
                custom_js_textarea.parents('tr').find('th').remove();
            $('<div id="custom_login[custom_jquery]_ace"/>').insertAfter(custom_js_textarea);
            var custom_js = ace.edit("custom_login[custom_jquery]_ace");
            custom_js.setOptions({
                minLines: 8,
                maxLines: 25,
                showGutter: true,
                displayIndentGuides: false,
                autoScrollEditorIntoView: true
            });
            custom_js.$blockScrolling = Infinity;
            custom_js.getSession().setMode("ace/mode/javascript");
            custom_js.setTheme("ace/theme/github");
            custom_js_textarea.hide();
            custom_js.getSession().setValue(custom_js_textarea.val());
            custom_js.getSession().on('change', function(){
                custom_js_textarea.val(custom_js.getSession().getValue());
            });
            custom_js.session.setUseWorker(true);
        }

    } // ace

    // chosen select boxes
    $(".selectbox").chosen({
        disable_search: true
    });

}); // jquery readydoc
