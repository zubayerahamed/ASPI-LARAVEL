<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $brand->id == null ? route('MD11.create') : route('MD11.update', ['id' => $brand->id]) }}" method="POST">
            @csrf
            @if ($brand->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $brand->id }}">
                <input type="hidden" name="remove_thumbnail" value="NO">
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Brand Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $brand->name }}" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="4">{{ $brand->description }}</textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label" for="website">Website</label>
                        <input type="text" class="form-control" id="website" name="website" value="{{ $brand->website }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label" for="support_email">Support Email</label>
                        <input type="text" class="form-control" id="support_email" name="support_email" value="{{ $brand->support_email }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label" for="support_phone">Support Phone</label>
                        <input type="text" class="form-control" id="support_phone" name="support_phone" value="{{ $brand->support_phone }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label" for="warranty_period">Warranty Period</label>
                        <input type="text" class="form-control" id="warranty_period" name="warranty_period" value="{{ $brand->warranty_period }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="thumbnail">Thumbnail</label>
                        <div class="row">
                            @if ($brand->id != null && $brand->thumbnail != null)
                                <div class="col-md-12 mb-3 thumbnail-image-container">
                                    <img class="border mb-3" src="{{ $brand->thumbnail->originalFile }}" width="100%" />
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
                                       data-accepted-file-types="image/*"
                                       data-instant-upload="true"
                                       data-allow-image-edit="true"
                                       data-allow-image-preview="true">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_featured" name="is_featured" {{ $brand->is_featured ? 'checked' : '' }}>
                            <label for="is_featured" class="custom-control-label form-label">Is Featured?</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_popular" name="is_popular" {{ $brand->is_popular ? 'checked' : '' }}>
                            <label for="is_popular" class="custom-control-label form-label">Is Popular?</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_highlighted" name="is_highlighted" {{ $brand->is_highlighted ? 'checked' : '' }}>
                            <label for="is_highlighted" class="custom-control-label form-label">Is Highlighted?</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_listed" name="is_listed" {{ $brand->is_listed ? 'checked' : '' }}>
                            <label for="is_listed" class="custom-control-label form-label">Is Listed?</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" {{ $brand->is_active ? 'checked' : '' }}>
                            <label for="is_active" class="custom-control-label form-label">Is Active?</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('MD11', ['id' => 'RESET']) }}"
                            data-detailreloadid="header-table-container"
                            data-detailreloadurl="{{ route('MD11.header-table') }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($brand->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('MD11.delete', ['id' => $brand->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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
