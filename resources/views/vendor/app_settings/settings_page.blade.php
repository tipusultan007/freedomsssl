@extends('layouts/layoutMaster')

@section('title', 'সেটিংস')
@section('content')
    @include('app_settings::_settings')
@endsection

@section('page-script')
  <script>
    $("textarea").on('input',function() {
      var id = $(this)[0].id;
      var total_count = $(this).val().length;
      $(`#text_count_${id}`).text('Total Characters: '+total_count);

    })
  </script>
@endsection
