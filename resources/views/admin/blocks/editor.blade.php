
<script type="text/javascript">

function initTinymce() {
        tinymce.init({
            selector: '.wysihtml5',  // change this value according to your HTML
            plugins: 'image code link',
            a11y_advanced_options: true,
            images_upload_handler: example_image_upload_handler,
            height: 400,
            image_class_list: [
                {title: 'None', value: ''},
                {title: 'Left', value: 'alignleft'},
                {title: 'Right', value: 'alignright'},
                {title: 'Center', value: 'alignnone size-full'}
            ]
        });
    }
    

</script>