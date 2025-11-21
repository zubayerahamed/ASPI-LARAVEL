<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $user->id == null ? route('SA03.create') : route('SA03.update', ['id' => $user->id]) }}" method="POST">
            @csrf
            @if ($user->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $user->id }}">
            @endif

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="email">User Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="country">Businesses</label>
                        <select class="form-control select2bs4" id="business_ids" name="business_ids[]" multiple required>
                            @foreach ($businesses as $business)
                                <option value="{{ $business->id }}" {{ $user->businesses && $user->businesses->contains('id', $business->id) ? 'selected' : '' }}>{{ $business->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if ($user->id != null)
                    <div class="col-md-12"></div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" {{ $user->status == 'active' ? 'checked' : '' }}>
                                <label for="is_active" class="custom-control-label form-label">Is Active?</label>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('SA03', ['id' => 'RESET']) }}"
                            data-detailreloadid="header-table-container"
                            data-detailreloadurl="{{ route('SA03.header-table') }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($user->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('SA03.delete', ['id' => $user->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
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
