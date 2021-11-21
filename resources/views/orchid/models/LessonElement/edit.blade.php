<div id="lesson-element">
    <lesson-element type-select-id="{{ $typeSelectId }}" url="{{ $url }}" id="{{ $id }}">
        {!! $layouts !!}
    </lesson-element>
</div>

@push('head')
    <script src="{{mix('js/lesson-element.js')}}" defer></script>
@endpush
