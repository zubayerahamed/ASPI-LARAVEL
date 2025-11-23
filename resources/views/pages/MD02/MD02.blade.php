<div class="row">
    @if ($allowCustomCategory == true)
        <div class="col-md-4">
            <div class="main-form-container">
                @include('pages.MD02.MD02-main-form')
            </div>
        </div>
    @endif

    <div class="{{ $allowCustomCategory == true ? 'col-md-8' : 'col-md-12' }}">
        <div class="header-table-container">
            @include('pages.MD02.MD02-header-table')
        </div>
    </div>
</div>