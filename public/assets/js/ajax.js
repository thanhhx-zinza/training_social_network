$(document).ready(function() {
    $(document).on('submit', '.formAjax', function(e) {
        e.preventDefault();
        name = $(this).attr('name');
        $.ajax({
            url: $(this).attr('action'),
            type:$(this).attr('method'),
            data:$(this).serialize(),
            success:function(res) {
                $('#' + name).html(res);
            },
            error: function (request, error) {
                $('#main').html(error);
            }
        });
    });
});
