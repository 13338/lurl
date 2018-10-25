
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

 $('#submit').click(function(event) {
    event.preventDefault();
    var link = $('#link').val();
    var form = $('#create-link-form').serialize();
    $.ajax({
        url: '/',
        type: 'POST',
        data: form,
    })
    .done(function(data) {
        $('#prepend').prepend(`
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="link-${data.short}" value="${data.value}">
                <div class="input-group-append">
                    <button class="btn btn-outline-success copy" type="button" onclick="copyText(this)" data-copy="link-${data.short}">Copy URL</button>
                </div>
            </div>
        `);
        $('#link-' + data.short).select();
    })
    .fail(function($xhr) {
        var data = $xhr.responseJSON;
        $('#errors').text('').show();
        $.each(data.errors, function(index, val) {
            $('#errors').append(val + '<br>');
        });
        $('#link').addClass('is-invalid');
    })
    .always(function() {
        $('#link').val('');
    });

});
$('#show-expired-input').click(function(event) {
    $('#expired-input').fadeToggle('fast', function() {
        $('#datetime').prop('disabled', function(i, v) {
            return !v;
        });
    });
});
$('#show-short-input').click(function(event) {
    $('#short-input').fadeToggle('fast', function() {
        $('#short').prop('disabled', function(i, v) {
            return !v;
        });
    });
});
$('.change-datetime').click(function(event) {
    var value = $(this).data('value');
    $('#datetime').val(value);
});
$('input').keydown(function(event) {
    $('#errors').fadeOut();
    $('#link').removeClass('is-invalid');
});
