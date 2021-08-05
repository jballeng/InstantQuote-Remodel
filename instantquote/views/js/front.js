
$(function () {
    'use strict';
    $("#srprequestquote").validate();
    var maxFiles = 3;
    var filecount = 0;
    var filemsg = 0;
    var files_failed = 0;
    var fail_serial = 0;

    $('#file_upload').fileupload({
        url: uploadUrl,
        dataType: 'json',
        maxFileSize: 2 * 1024 * 1024, // 2 MB
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|zip|pdf|cad|psd|doc?x|igs|dxf|xls|bmp)$/i,
        //singleFileUploads: true,
        messages: {
            maxFileSize: 'File exceeds maximum allowed size of 2 MB',
            maxNumberOfFiles: 'Maximum number of files exceeded',
        },
        done: function (e, data) {
            $('#upload_limit').hide();
            var response = data.response();
            if (response.result.hasOwnProperty("hasError") && response.result.hasOwnProperty("virusDetected")) {

                $("#upload_virus_detected").html('Virus detected in last uploaded file(s)');
                files_failed = 1;
                return;
            }
            if (response.result.hasOwnProperty("hasError") && response.result.hasOwnProperty("errorUpload")) {

                $("#upload_virus_detected").html(response.result.message);
                files_failed = 1;
                return;
            }
            $.each(data.originalFiles, function (index, file) {

                var updatedVal = $('#file_upload').val();
                var count = updatedVal.split(",");
                var fileCount = $(".uploadedeAttachments").length;
                var serverFile = data.result.files[index];
                var removeFileName = "'" + serverFile.name + "'";

                if ((fileCount < (maxFiles)) && !file.error) {
                    var append = '<span class="upload_successful remove_icon_block" style="display: inline-block;" onClick="remove_file(' + removeFileName + ')" id="' + serverFile.name + '_button">Remove</span>'
                            + '<span class="file_name"  id="' + serverFile.name + '_name">' + file.name + '</span> <input type="hidden" class="uploadedeAttachments" name="attachmentsServer[]" value="' + serverFile.name + '"  id="' + serverFile.name + '_attachement" /> ';
                    $('<div class="preview_container"/>').html(append).appendTo('#files');
                } else if (fileCount >= maxFiles && !file.error) {
                    $('#upload_limit').show();
                    return false;
                }
            });
            $('#upload_msg_block').show();
            if (files_failed > 0) {
                $('#upload_msg_block').html('File upload completed with <span style="color: red;">' + files_failed + ' errors</span>');
            } else {
                $.each(data.result.files, function (index, file) {
                    $('#file_uploaded').val($('#file_uploaded').val() + file.name + ',');
                });
                $('#upload_msg_block').html('All file(s) uploaded successfully');
            }

        },
        progressall: function (e, data) {
            var progress = 0;
            progress = parseInt(data.loaded / data.total * 100, 10);

            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    );
            $('#progress-caption').html(progress + ' %');
            var updatedVal = $('#file_upload').val();
            var count = updatedVal.split(",");
            var fileCount = count.length;
            if ((fileCount < maxFiles)) {
                $('.upload_progress_bar').show();
            }
            if (progress >= 100) {
                filecount = 0;
                $('.upload_progress_bar').fadeOut('1000');

                setTimeout(function () {
                    $('#progress-caption').html('0 %');
                    $('#progress .progress-bar').css('width', '0%');
                }, 1200);
            }
        },
        fail: function (e, data) {
            $.each(data.files, function (e, file) {
                if (file.error) {
                    var append = '<span class="upload_successful remove_icon_block" style="display: inline-block; padding-right: 25px;"></span><span class="file_name" style="color: red;">' + file.name + ' - Upload failed - ' + file.error + '</span>';
                    $('<div class="preview_container"/>').html(append).appendTo('#files');
                    files_failed++;
                }
            });
        },
        processalways: function (e, data) {
            $.each(data.files, function (e, file) {
                //console.log(file);
                if (file.error) {
                    var append = '<span class="remove_icon_block" style="display: inline-block;" onClick="remove_failed_file(' + ++fail_serial + ',' + files_failed + ');" id="fail_button_' + fail_serial + '">Remove</span><span id="fail_name_' + fail_serial + '" class="file_name" style="color: red;">' + file.name + ' - Upload failed - ' + file.error + '</span>';
                    $('<div class="preview_container"/>').html(append).appendTo('#files');
                    files_failed++;
                }
            });
        },
    }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    $('.rfq-help-img').each(function () {
        $(this).qtip({// Grab some elements to apply the tooltip to
            content: {
                text: $(this).parent().next().html()
            }, position: {
		my: 'right top',
		adjust: {
			    x: 30
			}
	    }
        });
    });
    setTimeout(function () {
        grecaptcha.render('RFQ-captcha-Form', {'sitekey': captchaSiteKey, 'callback': 'validCaptchaForm'});
    }, 150);

});
function validCaptchaFormRFQ(response) {

}
function remove_file(removeFileName)
{
    document.getElementById(removeFileName + '_button').style.display = 'none';
    document.getElementById(removeFileName + '_name').style.display = 'none';
    document.getElementById(removeFileName + '_attachement').remove();
}
function remove_failed_file(serial, files_failed)
{
    document.getElementById('fail_button_' + serial).style.display = 'none';
    document.getElementById('fail_name_' + serial).style.display = 'none';
}
