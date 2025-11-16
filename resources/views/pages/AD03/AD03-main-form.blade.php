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
                        <div class="icon-picker-container">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i id="selectedIconPreview" class="{{ $category->icon }}"></i></span>
                                </div>
                                <input type="text" class="form-control icon-input" name="icon" value="{{ $category->icon }}">
                                <div class="input-group-append">
                                    <div class="input-group-text toggle-icon-picker"><i class="ph ph-caret-down"></i></div>
                                </div>
                            </div>

                            <div class="icon-picker-dropdown" id="iconPickerDropdown">
                                <div class="icon-picker-search">
                                    <div class="input-group">
                                        <input type="text" id="iconSearch" class="form-control icon-search" placeholder="Search icons...">
                                        <div class="input-group-append">
                                            <div class="input-group-text reset-icon-search"><i class="ph ph-arrows-clockwise"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="icon-picker-icons" id="iconPickerIcons">
                                    <!-- Icons will be populated here -->
                                </div>
                            </div>
                        </div>
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
                        <label class="form-label" for="thumbnail">Thumbnail</label>
                        <div class="row">
                            @if ($category->id != null && $category->thumbnail != null)
                                <div class="col-md-12 mb-3 thumbnail-image-container">
                                    <img class="border mb-3" src="{{ $category->thumbnail->originalFile }}" width="100%" />
                                    <a href="#" class="btn btn-default col-12 remove-thumbnail-btn d-flex align-items-center justify-content-center gap-2"><i class="ph ph-trash"></i> <span>Remove Image</span></a>
                                </div>
                            @endif
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