@extends('backend.layouts.app')

@section('title','Error')

@section('custom_content')
<div class="page-error">
  <div class="page-inner">
      <h1>500</h1>
      <div class="page-description">
          Whoopps, something went wrong.
      </div>
      <!-- Search form -->
      @include('backend.layouts.partials.error_page_search')
  </div>
</div>
@endsection


