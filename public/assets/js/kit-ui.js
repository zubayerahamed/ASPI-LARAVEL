/* ------------------------------------------------------------------------------
 *
 *  # Custom JS code
 *
 *  Place here all your custom js. Make sure it's loaded after app.js
 *
 * ---------------------------------------------------------------------------- */
var kit = kit || {};
kit.ui = kit.ui || {};
kit.ui.config = kit.ui.config || {};

kit.ui.config.initSelect2 = function () {
    $('.select2').select2();

    // Select2 with boostrap4 theme
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });
}

kit.ui.config.initColorpicker = function () {
    //Colorpicker
    $('.colorpicker').colorpicker()

    //color picker with addon
    $('.colorpicker2').colorpicker()
    $('.colorpicker2').on('colorpickerChange', function (event) {
        $('.colorpicker2 .fa-square').css('color', event.color.toString());
    });
}

kit.ui.config.initToastr = function () {
    // Override toaster defaults
    toastr.options = {
        closeButton: false,
        progressBar: true,
        timeOut: 2500,
        positionClass: "toast-bottom-right",
    };
}

kit.ui.config.initDateTimePicker = function () {
    $('.timepicker').each(function () {
        $(this).datetimepicker({
            format: "LT",
            icons: {
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down"
            }
        });
    });

    //Date picker
    $('.datepicker').each(function () {
        var allowMultiDate = $(this).data('multidate') != undefined && $(this).data('multidate') == 'Y' ? true : false;
        $(this).datetimepicker({
            format: 'YYYY-MM-DD',
            allowMultidate: allowMultiDate,
            multidateSeparator: ','
        });
    });

    $('.datetimepicker').each(function () {
        var allowMultiDate = $(this).data('multidate') != undefined && $(this).data('multidate') == 'Y' ? true : false;
        $(this).datetimepicker({
            format: 'YYYY-MM-DD hh:mm A',
            allowMultidate: allowMultiDate,
            multidateSeparator: ',',
            icons: {
                time: 'far fa-clock'
            }
        });
    });


    $('.datetimerangepicker').each(function () {
        var withTimePicker = $(this).data('timepicker') != undefined && $(this).data('timepicker') == 'Y' ? true : false;

        if (withTimePicker) {
            $(this).daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'YYYY-MM-DD hh:mm A'
                }
            });
        } else {
            $(this).daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        }

    });
}

kit.ui.config.initDualListbox = function () {
    $('.duallistbox').bootstrapDualListbox();
}

kit.ui.config.initBootstrapSwitch = function () {
    $("input[data-bootstrap-switch]").each(function () {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
}

kit.ui.config.initSummernote = function () {
    //$('textarea.summernote').summernote();
    $("textarea.summernote").summernote({
        tabsize: 2,
        height: 300,
        codemirror: {
            theme: "monokai",
        },
        toolbar: [
            ["style", ["style"]],
            ["font", ["bold", "underline", "clear"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["table", ["table"]],
            ["insert", ["link", "picture", "video"]],
            ["view", ["fullscreen", "codeview", "help"]],
        ],
        callbacks: {
            onImageUpload: function (files, editor, welEditable) {
                for (var i = 0; i < files.length; i++) {
                    sendSummernoteFile(files[i], this);
                }
            },
        },
    });
}

kit.ui.config.initDatatable = function () {
    $(".datatable").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"], 
        // dom: '<"datatable-header justify-content-start"f<"ms-sm-auto"l><"ms-sm-3"B>><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        buttons: {
            dom: {
                button: {
                    className: 'btn btn-secondary btn-sm'
                }
            },
            buttons: [{
                    extend: 'copy'
                },
                {
                    extend: 'csv'
                },
                {
                    extend: 'excel'
                },
                {
                    extend: 'pdf'
                },
                {
                    extend: 'print'
                },
                {
                    extend: 'colvis'
                }
            ]
        },
    }).buttons().container().css({
        width: '100%'
    }).appendTo('.dataTables_wrapper .col-md-6:eq(1)');
}

kit.ui.config.initFilePond = function () {
    $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
    $.fn.filepond.registerPlugin(FilePondPluginFileValidateSize);
    $.fn.filepond.registerPlugin(FilePondPluginImageResize);
    $.fn.filepond.registerPlugin(FilePondPluginFileValidateType);
    $.fn.filepond.registerPlugin(FilePondPluginImageCrop);
    $.fn.filepond.registerPlugin(FilePondPluginImageResize);
    $.fn.filepond.registerPlugin(FilePondPluginImageTransform);

    $.fn.filepond.setDefaults({
        maxFileSize: '3MB',
        acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg'],
        allowImageCrop: true,
        imageCropAspectRatio: null,
    });

    $('.filepond').each(function () {
        var allowMultiple = $(this).data('multiple-upload') != undefined && $(this).data('multiple-upload') == 'Y' ? true : false;
        if (!FilePond.find(this)) {
            $(this).filepond({
                allowMultiple: allowMultiple,
            });
        }
    });


    $.fn.filepond.setOptions({
        server: {
            process: getBasepath() + '/filepond',
            revert: getBasepath() + '/filepond',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        },
    });
}

kit.ui.init = function () {
    kit.ui.config.initSelect2();
    kit.ui.config.initDatatable();
    kit.ui.config.initColorpicker();
    kit.ui.config.initToastr();
    kit.ui.config.initDateTimePicker();
    kit.ui.config.initDualListbox();
    kit.ui.config.initBootstrapSwitch();
    kit.ui.config.initSummernote();
    kit.ui.config.initFilePond();
	console.log("KIT-UI JS code initialization done");
}

$(document).ready(function () {
    kit.ui.init();

    $(document).on('click', '.screen-item', function (e) {
        e.preventDefault();

        $('.screen-item').removeClass('active');
        $(this).addClass('active');

        var screenCode = $(this).data('screen');
        var fromfav = $(this).data('fav') != undefined && $(this).data('fav') != null && 'Y' == $(this).data('fav');
        var fromdef = $(this).data('def') != undefined && $(this).data('def') != null && 'Y' == $(this).data('def');
        if (fromdef) $(this).removeAttr('data-def');

        var url = '/' + screenCode;
        const questionCount = url.split("?").length - 1;
        if (questionCount === 1) {
            if (fromfav) {
                url = url + '&fromfav=&frommenu=Y';
            } else if (fromdef) {
                url = url + '&fromdef=&frommenu=Y';
            } else {
                url = url + '&frommenu=Y';
            }
        } else {
            if (fromfav) {
                url = url + '?fromfav=&frommenu=Y';
            } else if (fromdef) {
                url = url + '?fromdef=&frommenu=Y';
            } else {
                url = url + '?frommenu=Y';
            }
        }

        // $('.customize-aspi-offcanvas').click();
        // if($('.sidebar-mobile-expanded').length > 0){
        // 	$('.mobile-nav-close').click();
        // }

        sectionReloadAjaxReq({
            id: 'screen-container',
            url: url
        }, (data) => {
            // Update content header title and document title
            $(".content_header_title").html("");
            if(data.content_header_title) $(".content_header_title").html(data.content_header_title);

            if(data.subtitle) {
                document.title = "ASPI | " + data.subtitle;
            } else {
                document.title = "ASPI";
            }
        });
    })

});
