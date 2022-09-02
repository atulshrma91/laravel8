@extends('layouts.guest')

@section('content')

<div class="page-header login-page header-filter" filter-color="" >
  <div class="container">
    <div class="row">
      <h2>{{ __('termsconditions.title') }}</h2>
      <div>{!! __('termsconditions.body') !!}</div>
    </div>
  </div>
</div>


@endsection
