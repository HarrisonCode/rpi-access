console.log('Dashboard Loaded');

$(document).ready(() => {
    $(document).on('click', '#btn-logout', () => {
        var btn = $('#btn-logout');

        $.ajax({
            type: 'GET',
            url: `${baseUrl}dashboard/logout`,
            beforeSend: () => {
                btn.html('<i class="fa fa-spinner fa-pulse"></i>');
            },
            success: () => {
                document.location.href = baseUrl;
            },
            error: () => {
                document.location.href = baseUrl;
            }
        });
    });
});