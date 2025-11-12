<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $category->id == null ? route('AD03.create') : route('AD03.update', ['id' => $category->id]) }}" method="POST">
            @csrf
            @if ($category->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $category->id }}">
                <input type="hidden" name="remove_thumbnail" value="NO">
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="type">Parent category</label>
                        <select class="form-control select2bs4" id="parent_category_id" name="parent_category_id">
                            <option value="">-- Select Parent Category --</option>
                            @include('pages.AD03.AD03-category-recursive', [
                                'categoryTree' => $categoryTree,
                                'count' => 0,
                            ])
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label" for="seqn">Sequence number</label>
                        <input type="number" class="form-control" id="seqn" name="seqn" value="{{ $category->seqn }}" min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label" for="icon">Icon</label>
                        <input type="text" class="form-control" id="icon" name="icon" value="{{ $category->icon }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="4">{{ $category->description }}</textarea>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="thumbnail">Thumbnail</label>
                        <div class="row">
                            {{-- @if ($category->thumbnail != 'image_placeholder.jpg')
                                <div class="col-md-12 mb-3 thumbnail-image-container">
                                    <img class="elevation-2 thumbnail-image mb-3" src="{{ getUploadDirPath() . $category->thumbnail }}" width="100%" />
                                    <a href="#" class="btn btn-default col-12 remove-thumbnail-btn">Remove Image</a>
                                </div>
                            @endif --}}
                            <div class="col-md-12">
                                <input  type="file" 
                                        class="filepond" 
                                        name="thumbnail" 
                                        id="thumbnail"
                                        data-multiple-upload="N" 
                                        data-max-file-size="2MB" 
                                        data-accepted-file-types="image/*, application/pdf, video/*"
                                        data-instant-upload="true" 
                                        data-allow-image-edit="true"
                                        data-allow-image-preview="true"
                                    >
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label class="form-label text-muted opacity-75 fw-medium" for="formImage">Image</label>
                        <div class="dropzone-drag-area form-control" id="previews">
                            <div class="dz-message text-muted opacity-50" data-dz-message>
                                <span>Drag file here to upload</span>
                            </div>    
                            <div class="d-none" id="dzPreviewContainer">
                                <div class="dz-preview dz-file-preview">
                                    <div class="dz-photo">
                                        <img class="dz-thumbnail" data-dz-thumbnail>
                                    </div>
                                    <button class="dz-delete border-0 p-0" type="button" data-dz-remove>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="times"><path fill="#FFFFFF" d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="invalid-feedback fw-bold">Please upload an image.</div>
                    </div>
                </div>

                <div class="dropzone" id="formDropzone" data-url="{{ route('AD18.create') }}">
                    <div class="fallback">
                        <input name="file" type="file" multiple />
                    </div>
                </div> --}}

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_featured" name="is_featured" {{ $category->is_featured ? 'checked' : '' }}>
                            <label for="is_featured" class="custom-control-label form-label">Is Featured?</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" {{ $category->is_active ? 'checked' : '' }}>
                            <label for="is_active" class="custom-control-label form-label">Is Active?</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('AD03', ['id' => 'RESET']) }}"
                            data-detailreloadid="header-table-container"
                            data-detailreloadurl="{{ route('AD03.header-table') }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($category->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('AD03.delete', ['id' => $category->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
                            <i class="ph ph-trash"></i> <span>Delete</span>
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Update</span>
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        kit.ui.init();

        $('.btn-reset').off('click').on('click', function(e) {
            e.preventDefault();

            sectionReloadAjaxReq({
                id: $(this).data('reloadid'),
                url: $(this).data('reloadurl')
            });

            sectionReloadAjaxReq({
                id: $(this).data('detailreloadid'),
                url: $(this).data('detailreloadurl')
            });
        });

        $('.btn-submit').off('click').on('click', function(e) {
            e.preventDefault();
            submitMainForm();
        });

        $('.btn-delete').off('click').on('click', function(e) {
            e.preventDefault();
            sweetAlertConfirm(() => {
                deleteRequest($(this).data('url'));
            });
        });

        $('.remove-thumbnail-btn').off('click').on('click', function(e) {
            e.preventDefault();
            $('.thumbnail-image-container').remove();
            $('input[name="remove_thumbnail"]').val('YES');
        });
    })
</script>
<script>
    Dropzone.autoDiscover = false;

    /**
     * Setup dropzone
     */
    $('#mddainform').dropzone({
        previewTemplate: $('#dzPreviewContainer').html(),
        url: '/form-submit',
        addRemoveLinks: true,
        autoProcessQueue: false,       
        uploadMultiple: false,
        parallelUploads: 1,
        maxFiles: 1,
        acceptedFiles: '.jpeg, .jpg, .png, .gif',
        thumbnailWidth: 900,
        thumbnailHeight: 600,
        previewsContainer: "#previews",
        timeout: 0,
        init: function() 
        {
            myDropzone = this;

            // when file is dragged in
            this.on('addedfile', function(file) { 
                $('.dropzone-drag-area').removeClass('is-invalid').next('.invalid-feedback').hide();
            });
        },
        success: function(file, response) 
        {
            // hide form and show success message
            $('#formDropzone').fadeOut(600);
            setTimeout(function() {
                $('#successMessage').removeClass('d-none');
            }, 600);
        }
    });

    /**
     * Form on submit
     */
    $('#formSubmit').on('click', function(event) {
        event.preventDefault();
        var $this = $(this);
        
        // show submit button spinner
        $this.children('.spinner-border').removeClass('d-none');
        
        // validate form & submit if valid
        if ($('#formDropzone')[0].checkValidity() === false) {
            event.stopPropagation();

            // show error messages & hide button spinner    
            $('#formDropzone').addClass('was-validated'); 
            $this.children('.spinner-border').addClass('d-none');

            // if dropzone is empty show error message
            if (!myDropzone.getQueuedFiles().length > 0) {                        
                $('.dropzone-drag-area').addClass('is-invalid').next('.invalid-feedback').show();
            }
        } else {

            // if everything is ok, submit the form
            myDropzone.processQueue();
        }
    });

</script>
<script>
        Dropzone.options.dropzone = {
            maxFilesize: 12,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.ico,.pdf,.doc,.docx,.ppt,.pptx,.pps,.ppsx,.odt,.csv,.xls,.xlsx,.PSD",
            addRemoveLinks: true,
            timeout: 5000,
            removedfile: function(file) {
                var name = file.upload.filename;
                loadingMask2.show();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ route('AD18.create') }}',
                    data: {
                        filename: name
                    },
                    success: function(data) {
                        loadingMask2.hide();
                        showMessage(data.status, data.message);
                    },
                    error: function(e) {
                        loadingMask2.hide();
                        console.log(e);
                    }
                });
                var fileRef;
                return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
            success: function(file, response) {
                showMessage(response.status, response.message);
            },
            error: function(file, response) {
                return false;
            }
        };
    </script>
