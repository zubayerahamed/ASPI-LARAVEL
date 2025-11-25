<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $psa->id == null ? route('MD09.create') : route('MD09.update', ['id' => $psa->id]) }}" method="POST">
            @csrf
            @if ($psa->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $psa->id }}">
            @endif

            <div class="row">

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="group_id">Associated Group</label>
                        <select class="form-control select2bs4" id="group_id" name="group_id" required>
                            <option value="">-- Select Group --</option>
                            @foreach ($psGroups as $group)
                                <option value="{{ $group->id }}" {{ $psa->group_id == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Name</label>
                        <div class="input-group">
                            <input type="text"
                                   class="form-control searchsuggest2"
                                   name="name"
                                   value="{{ $psa->name }}"
                                   placeholder="Create or Open Existing..."
                                   required>
                            <div class="input-group-append btn-search"
                                 data-reloadurl="{{ route('search.index', ['fragmentcode' => 'LMD09', 'suffix' => 0]) . '?hint=' }}"
                                 data-reloadid="search-suggest-results-container"
                                 data-fieldid="name"
                                 data-mainscreen=true
                                 data-mainreloadurl="{{ route('MD09', ['id' => '']) }}"
                                 data-mainreloadid="main-form-container"
                                 data-detailreloadurl="{{ route('MD09.detail-table', ['id' => 'RESET', 'attribute_id' => '']) }}"
                                 data-detailreloadid="detail-table-container">
                                <div class="input-group-text">
                                    <i class="ph ph-magnifying-glass"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="type">Type</label>
                        <select class="form-control select2bs4" id="type" name="type" required>
                            <option value="">-- Select Type --</option>
                            <option value="text" {{ $psa->type == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="textarea" {{ $psa->type == 'textarea' ? 'selected' : '' }}>Textarea</option>
                            <option value="select" {{ $psa->type == 'select' ? 'selected' : '' }}>Dropdown</option>
                            <option value="checkbox" {{ $psa->type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                            <option value="radio" {{ $psa->type == 'radio' ? 'selected' : '' }}>Radio</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="default_value">Default Value</label>
                        <textarea class="form-control" name="default_value" id="default_value" rows="1">{{ $psa->default_value }}</textarea>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('MD09', ['id' => 'RESET']) }}"
                            data-detailreloadid="detail-table-container"
                            data-detailreloadurl="{{ route('MD09.detail-table', ['id' => 'RESET', 'attribute_id' => 'RESET']) }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($psa->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('MD09.delete', ['id' => $psa->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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
