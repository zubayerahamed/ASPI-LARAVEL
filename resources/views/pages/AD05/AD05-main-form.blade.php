<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $profile->id == null ? route('AD05.create') : route('AD05.update', ['id' => $profile->id]) }}" method="POST">
            @csrf
            @if ($profile->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $profile->id }}">
                <input type="hidden" name="name" value="{{ $profile->name }}">
            @endif

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Profile</label>
                        <div class="input-group">
                            <input  type="text" 
                                    class="form-control searchsuggest2" 
                                    name="name" 
                                    value="{{ $profile->name }}"
                                    placeholder="Create or Open Existing..."
                                    {{ $profile->id != null ? 'disabled' : '' }}
                                    {{ $profile->id == null ? 'required' : '' }}>
                            <div class="input-group-append btn-search"
                                data-reloadurl="{{ route('search.index', ['fragmentcode' => 'LAD05', 'suffix' => 0]) . '?hint=' }}"
                                data-reloadid="search-suggest-results-container"
                                data-fieldid="name"
                                data-mainscreen=true
                                data-mainreloadurl="{{ route('AD05', ['id' => '']) }}"
                                data-mainreloadid="main-form-container"
                                data-detailreloadurl="{{ route('AD05.detail-table', ['id' => 'RESET', 'profile_id' => '']) }}"
                                data-detailreloadid="detail-table-container">
                                <div class="input-group-text">
                                    <i class="ph ph-magnifying-glass"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="description">Description</label>
                        <input type="text" id="description" name="description" class="form-control" value="{{ $profile->description }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="seqn">Sequence</label>
                        <input type="number" class="form-control" id="seqn" name="seqn" value="{{ $profile->seqn }}" min="0" required>
                    </div>
                </div>

                <div class="col-md-12"></div>

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" {{ $profile->is_active ? 'checked' : '' }}>
                            <label for="is_active" class="custom-control-label form-label">Is Active?</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button 
                        data-reloadid="main-form-container" 
                        data-reloadurl="{{ route('AD05', ['id' => 'RESET']) }}" 
                        data-detailreloadid="detail-table-container" 
                        data-detailreloadurl="{{ route('AD05.detail-table', ['id' => 'RESET', 'profile_id' => 'RESET']) }}"
                        type="reset" 
                        class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($profile->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('AD05.delete', ['id' => $profile->id]) }}" type="button"  class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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
