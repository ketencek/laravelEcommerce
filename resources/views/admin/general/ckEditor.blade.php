@push('scripts')
<script type="text/javascript" src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        <?php foreach ($names as $name) : ?>
            CKEDITOR.replace('{{ $name }}', {
                language: 'en',
                filebrowserImageUploadUrl: "{{ route('admin.ckeditor', array('folder'=>$folder)) }}",
                toolbar: [{
                        name: 'document',
                        items: ['Source']
                    },
                    {
                        name: 'basicstyles',
                        items: ['Bold', 'Italic', 'Underline']
                    },
                    {
                        name: 'paragraph',
                        items: ['NumberedList', 'BulletedList', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                    },
                    {
                        name: 'links',
                        items: ['Link', 'Unlink', 'Anchor']
                    },
                    {
                        name: 'insert',
                        items: ['Image', 'Table', 'SpecialChar']
                    },
                    {
                        name: 'styles',
                        items: ['Format', 'FontSize']
                    },
                    {
                        name: 'tools',
                        items: ['Maximize']
                    }
                ]
            });
        <?php endforeach; ?>
    });
</script>
@endpush