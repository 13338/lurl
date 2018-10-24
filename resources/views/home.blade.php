@extends('app')

@section('title', __('link.title'))

@section('content')
<form class="form-signin" action="{{ route('store') }}" method="POST">
    @csrf
    <h1>{{ __('link.header') }}</h1>
    <div class="input-group mb-3">
        <input type="text" class="form-control" id="link" placeholder="{{ __('link.input') }}" autofocus="autofocus" name="link" value="https://pikabu.ru/@1338">
        <div class="input-group-append">
            <button class="btn btn-dark" id="submit" type="button">{{ __('link.create') }}</button>
        </div>
    </div>
    <div id="prepend"></div>
</form>
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
</script>
<script type="text/javascript">
    $('#submit').click(function(event) {
        event.preventDefault();
        var link = $('#link').val();
        $.ajax({
            url: '{{ route('store') }}',
            type: 'POST',
            data: {link: link},
        })
        .done(function(data) {
            $('#prepend').prepend(`
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="link-${data.short}" value="{{ Request::root() }}/${data.short}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-success copy" type="button" onclick="copyText(this)" data-copy="link-${data.short}">{{ __('link.copy') }}</button>
                    </div>
                </div>
            `);
            $('#link-' + data.short).select();
        })
        .fail(function() {
            $('#link').addClass('is-invalid');
        })
        .always(function() {
            $('#link').val('');
        });

    });
    function copyText(element) {
        var copy = $(element).data('copy');
        var copyText = document.getElementById(copy);
        copyText.select();
        document.execCommand('copy');
        $('.copy').text('{{ __('link.copy') }}');
        $(element).text('{{ __('link.copied') }}');
    }
</script>
@endsection