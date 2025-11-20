<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $term->id == null ? route('MD04.create') : route('MD04.update', ['id' => $term->id]) }}" method="POST">
            @csrf
            @if ($term->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $term->id }}">
                <input type="hidden" name="remove_thumbnail" value="NO">
            @endif

            <input type="hidden" name="attribute_id" value="{{ $term->attribute_id }}">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Option Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $term->name }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label" for="seqn">Sequence</label>
                        <input type="number" class="form-control" id="seqn" name="seqn" value="{{ $term->seqn }}" min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="color">Color</label>
                        <div class="input-group colorpicker2">
                            <input type="text" class="form-control" id="color" name="color" value="{{ $term->color }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-square"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="thumbnail">Thumbnail</label>
                        <div class="row">
                            @if ($term->id != null && $term->thumbnail != null)
                                <div class="col-md-12 mb-3 thumbnail-image-container">
                                    <img class="border mb-3" src="{{ $term->thumbnail->originalFile }}" width="100%" />
                                    <a href="#" class="btn btn-default col-12 remove-thumbnail-btn d-flex align-items-center justify-content-center gap-2"><i class="ph ph-trash"></i> <span>Remove Image</span></a>
                                </div>
                            @endif
                            <div class="col-md-12">
                                <input type="file"
                                       class="filepond"
                                       name="thumbnail"
                                       id="thumbnail"
                                       data-multiple-upload="N"
                                       data-max-file-size="2MB"
                                       data-accepted-file-types="image/*, application/pdf, video/*"
                                       data-instant-upload="true"
                                       data-allow-image-edit="true"
                                       data-allow-image-preview="true">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_default" name="is_default" {{ $term->is_default ? 'checked' : '' }}>
                            <label for="is_default" class="custom-control-label form-label">Is Default?</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('MD04', ['id' => 'RESET', 'attribute_id' => $term->attribute_id]) }}"
                            data-detailreloadid="header-table-container"
                            data-detailreloadurl="{{ route('MD04.header-table', ['attribute_id' => $term->attribute_id]) }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($term->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('MD04.delete', ['id' => $term->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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
