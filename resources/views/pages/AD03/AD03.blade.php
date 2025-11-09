
{{-- <input type="file" class="filepond" name="filepond-upload" data-multiple-upload="N" /> --}}

{{-- <div class="col-md-12">
    <div class="form-group">
        <label for="thumbnail">Thumbnail</label>
        <div class="row">
            <div class="col-md-12">
                <input type="file" class="filepond" name="thumbnail">
            </div>
        </div>
    </div>
</div> --}}

<div class="row">
    <div class="col-md-4">
        <div class="main-form-container">
            @include('pages.AD03.AD03-main-form')
        </div>
    </div>

    <div class="col-md-8">
        <div class="header-table-container">
            @include('pages.AD03.AD03-header-table')
        </div>
    </div>
</div>

{{-- <script>
    $(document).ready(function () {
        kit.ui.init();
    });
</script> --}}