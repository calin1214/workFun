$(document).ready(function () {
    exportCsv();

    openImage();
});

function exportCsv() {
    $('#export_csv').on('click', function () {
        $.ajax({
            url: '/user/export',
            method: 'POST',
            xhrFields: {
                responseType: 'blob'
            },
            success: function (data) {
                let blobUrl = window.URL.createObjectURL(data);

                let link = document.createElement('a');
                link.href = blobUrl;
                link.download = 'exported_data.csv';
                link.click();

                window.URL.revokeObjectURL(blobUrl);
            }
        });
    });
}

function openImage() {
    $('.image-link').on('click', function (event) {
        event.preventDefault();
        let modal = $('#image_modal');
        let modalImage = $('#modal_image');

        modalImage.attr('src', $(this).find('img').attr('src'));
        modal.css('display', 'block');
    });

    $('.close').on('click', function () {
        $('#image_modal').css('display', 'none');
    });
}