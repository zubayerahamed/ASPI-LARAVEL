@extends('adminlte::page')

{{-- Extend and customize the browser title --}}
@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle')
        | @yield('subtitle')
    @endif
@stop

{{-- Add common CSS customizations --}}
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/kit-ui.css') }}" />
    @vite(['resources/css/app.css'])
@endpush

{{-- Extend and customize the page content header --}}
@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted content_header_title">
            @yield('content_header_title')

            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Rename section content to content_body --}}
@section('content')
    <a href="{{ route('home') }}" class="basePath"></a>
    <a href="{{ route('AD18.create') }}" class="filepond-process-url"></a>
    <a href="{{ route('AD18.destroy') }}" class="filepond-revert-url"></a>

    @yield('content_body')

    {{-- Loading Mask, Search Suggest Modal --}}
    @include('partials.search-suggest-modal')
    @include('partials.loading-mask')
@stop

{{-- Custom Preloader --}}
@section('preloader')
    @include('partials.preloader-mask')
@stop

{{-- Create a common footer --}}
@section('footer')
    <div class="float-right">
        Version: {{ config('app.version', '1.0.0') }}
    </div>

    <strong>
        Copyright &copy; {{ date('Y') }}
        <a href="{{ config('app.company_url', 'https://www.zayaanit.com') }}" target="_blank">
            {{ config('app.company_name', 'ZAYAAN IT') }}
        </a>
    </strong>
@stop

{{-- Add common Javascript/Jquery code --}}
@push('js')
    <script src="{{ asset('assets/js/kit-functions.js') }}"></script>
    <script src="{{ asset('assets/js/kit-ui.js') }}"></script>
@endpush
