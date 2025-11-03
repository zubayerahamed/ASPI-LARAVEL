@extends('layouts.app')

@section('subtitle')
    {{ $subtitle }}
@endsection

@section('content_header_title')
    {{ $content_header_title }}
@endsection

@section('content_body')
    <div class="screen-container">
        @if ($page)
            @include($page)
        @endif
    </div>
@endsection
