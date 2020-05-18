@extends('backend.layouts.app')

@section('title','Page Not Found!')

@section('custom_content')
<div class="page-error">
  <div class="page-inner">
      <h1>404</h1>
      <div class="page-description">
          The page you were looking for could not be found.
      </div>
      <!-- Search form -->
      @include('backend.layouts.partials.error_page_search')
  </div>
</div>
@endsection



