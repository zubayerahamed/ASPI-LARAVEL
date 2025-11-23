<div class="row">
    @if ($allowCustomAttribute)
        <div class="col-md-4">
            <div class="main-form-container">
                @include('pages.MD03.MD03-main-form')
            </div>
        </div>
    @endif

    <div class="{{ $allowCustomAttribute ? 'col-md-8' : 'col-md-12' }}">
        <div class="header-table-container">
            @include('pages.MD03.MD03-header-table')
        </div>
    </div>
</div>