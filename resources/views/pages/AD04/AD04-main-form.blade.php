<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $attribute->id == null ? route('AD04.create') : route('AD04.update', ['id' => $attribute->id]) }}" method="POST">
            @csrf
            @if ($attribute->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $attribute->id }}">
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Attribute Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $attribute->name }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label" for="seqn">Sequence</label>
                        <input type="number" class="form-control" id="seqn" name="seqn" value="{{ $attribute->seqn }}" min="0">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="display_layout">Display Type</label>
                        <select class="form-control select2bs4" id="display_layout" name="display_layout" required>
                            <option value="">-- Select Display Type --</option>
                            <option value="TEXT_SWATCH" {{ $attribute->display_layout == 'TEXT_SWATCH' ? 'selected' : '' }}>Text</option>
                            <option value="DROPDOWN_SWATCH" {{ $attribute->display_layout == 'DROPDOWN_SWATCH' ? 'selected' : '' }}>Dropdown</option>
                            <option value="VISUAL_SWATCH" {{ $attribute->display_layout == 'VISUAL_SWATCH' ? 'selected' : '' }}>Visual</option>
                        </select>
                    </div>
                </div>
                

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_image_visual_swatch" name="is_image_visual_swatch" {{ $attribute->is_image_visual_swatch ? 'checked' : '' }}>
                            <label for="is_image_visual_swatch" class="custom-control-label form-label">Use image from product variation</label>
                        </div>
                        <i class="text-sm text-muted ml-4">for Visual Swatch only</i>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_searchable" name="is_searchable" {{ $attribute->is_searchable ? 'checked' : '' }}>
                            <label for="is_searchable" class="custom-control-label form-label">Is Searchable?</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_comparable" name="is_comparable" {{ $attribute->is_comparable ? 'checked' : '' }}>
                            <label for="is_comparable" class="custom-control-label form-label">Is Comparable?</label>
                        </div>
                    </div>
                </div>

                 <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_used_in_product_listing" name="is_used_in_product_listing" {{ $attribute->is_used_in_product_listing ? 'checked' : '' }}>
                            <label for="is_used_in_product_listing" class="custom-control-label form-label">Is Used in Product Listing?</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" {{ $attribute->is_active ? 'checked' : '' }}>
                            <label for="is_active" class="custom-control-label form-label">Is Active?</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('AD04', ['id' => 'RESET']) }}"
                            data-detailreloadid="header-table-container"
                            data-detailreloadurl="{{ route('AD04.header-table') }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($attribute->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('AD04.delete', ['id' => $attribute->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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
    })
</script>