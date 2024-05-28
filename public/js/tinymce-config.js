tinymce.init({
    selector: '#content_id',
    plugins: 'code link autolink anchor emoticons image imagetools media lists advlist',
    toolbar: 'undo redo styles bold italic underline strikethrough forecolor backcolor numlist bullist subscript superscript code link anchor emoticons image media blockquote',
    statusbar: false,
    // toolbar: 'alignleft aligncenter alignright',
    automatic_uploads: true,
    document_base_url: '/',
    relative_urls: false,
    remove_script_host: true,
    convert_urls: false,
    images_upload_url: '/upload/images/postImageAcceptor',
    images_upload_base_path: '../uploads',
    images_reuse_filename: true,
    file_picker_types: 'image',
    file_picker_callback: function(cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.onchange = function() {
            var file = this.files[0];

            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function () {
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);
                cb(blobInfo.blobUri(), { title: file.name });
            };
        };
        input.click();
    }
});
