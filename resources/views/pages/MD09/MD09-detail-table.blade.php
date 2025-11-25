@if (
    isset($attributeDetail) 
    && $attributeDetail != null 
    && $attributeDetail->attribute_id != 'RESET'
    && $psa != null
    && ($psa->type == 'select' || $psa->type == 'radio')
)
    <div class="card card-default">

        <div class="card-header">
            <h3 class="card-title">Product option details</h3>
        </div>

        <div class="card-body">
            <form id="detailform" action="{{ $attributeDetail->id == null ? route('MD09.detail-table.create') : route('MD09.detail-table.update', ['id' => $attributeDetail->id]) }}" method="POST">
                @csrf
                @if ($attributeDetail->id != null)
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $attributeDetail->id }}">
                    
                @endif

                <input type="hidden" name="attribute_id" value="{{ $attributeDetail->attribute_id }}">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="label">Label</label>
                            <input type="text" class="form-control" id="label" name="label" value="{{ $attributeDetail->label }}" required>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1 text-left">
                        <button
                                data-reloadid="detail-table-container"
                                data-reloadurl="{{ route('MD09.detail-table', ['id' => 'RESET', 'attribute_id' => $attributeDetail->attribute_id]) }}"
                                type="reset"
                                class="btn btn-sm btn-default btn-detail-reset d-flex align-items-center gap-2">
                            <i class="ph ph-broom"></i> <span>Clear</span>
                        </button>
                    </div>
                    <div class="flex-grow-1 justify-content-end d-flex gap-2">
                        @if ($attributeDetail->id == null)
                            <button type="submit" class="btn btn-sm btn-primary btn-detail-submit d-flex align-items-center gap-2">
                                <i class="ph ph-floppy-disk"></i> <span>Save</span>
                            </button>
                        @else
                            <button data-url="{{ route('MD09.detail-table.delete', ['id' => $attributeDetail->id]) }}" type="button" class="btn btn-sm btn-danger btn-detail-delete d-flex align-items-center gap-2">
                                <i class="ph ph-trash"></i> <span>Delete</span>
                            </button>
                            <button type="submit" class="btn btn-sm btn-primary btn-detail-submit d-flex align-items-center gap-2">
                                <i class="ph ph-floppy-disk"></i> <span>Update</span>
                            </button>
                        @endif
                    </div>
                </div>

            </form>
        </div>

        @if (!$detailList->isEmpty())
            <div class="table-responsive data-table-responsive">
                <table class="table table-hover table-bordered p-0 m-0 MD09-datatable-fragment">
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th class="text-right" data-no-sort="Y">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detailList as $x)
                            <tr>
                                <td>
                                    <a data-reloadurl="{{ route('MD09.detail-table', ['id' => $x->id, 'attribute_id' => $x->attribute_id]) }}" class="detail-dataindex" data-reloadid="detail-table-container" href="#">{{ $x->label }}</a>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        <button data-url="{{ route('MD09.detail-table.delete', ['id' => $x->id]) }}" type="button" class="btn btn-sm btn-danger btn-table-delete d-flex align-items-center">
                                            <i class="ph ph-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        @endif

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            kit.ui.init();

            $('.btn-detail-reset').off('click').on('click', function(e){
				e.preventDefault();

				sectionReloadAjaxReq({
					id : $(this).data('reloadid'),
					url : $(this).data('reloadurl')
				});
			});

            $('.btn-detail-submit').off('click').on('click', function(e){
                console.log('here');
				e.preventDefault();
				submitMainForm(null, $('form#detailform'));
			});

			$('.btn-detail-delete').off('click').on('click', function(e){
				e.preventDefault();
				sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
			});


            $('.MD09-datatable-fragment').on('click', 'a.detail-dataindex', function(e) {
                e.preventDefault();

                sectionReloadAjaxReq({
                    id: $(this).data('reloadid'),
                    url: $(this).data('reloadurl')
                });
            });

            
            $('.MD09-datatable-fragment').on('click', 'button.btn-table-delete', function(e) {
                e.preventDefault();
                sweetAlertConfirm(() => {
                    deleteRequest($(this).data('url'));
                });
            });
        })
    </script>
@endif
