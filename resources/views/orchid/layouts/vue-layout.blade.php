@extends('platform::layouts.base')

@section('content')
    <div id="orchid-vue-app">
        <div id="modals-container">
            @stack('modals-container')
        </div>

        <form id="post-form"
              class="mb-md-4"
              method="post"
              enctype="multipart/form-data"
              data-controller="form"
              data-action="keypress->form#disableKey
                           form#submit"
              data-form-validation="{{ $formValidateMessage }}"
              novalidate
        >
            {!! $layouts !!}
            @csrf
            @include('platform::partials.confirm')
        </form>

        <div data-controller="filter">
            <form id="filters" autocomplete="off" data-action="filter#submit"></form>
        </div>
    </div>

    <script src="{{mix('js/app.js')}}" defer></script>
@endsection
