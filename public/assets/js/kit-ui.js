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
    $('.select2').select2({
        width: '100%'
    });

    // Select2 with boostrap4 theme
    $('.select2bs4').select2({
        theme: 'bootstrap4',
        width: '100%'
    });

    // Select2 with ajax data source
    $('.select2-ajax').each(function () {
        var sourceUrl = $(this).data('source-url');
        var placeholder = $(this).data('placeholder') != undefined ? $(this).data('placeholder') : 'Search...';

        $(this).select2({
            width: '100%',
            theme: 'bootstrap4',
            placeholder: placeholder,
            minimumInputLength: 1 ,// only start searching when the user has input 1 or more characters
            maximumInputLength: 20, // only allow terms up to 20 characters long
            ajax: {
                url: sourceUrl,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
        });
    });
}

kit.ui.config.initTypeahead = function () {
    $('.typeahead').each(function () {
        var sourceUrl = $(this).data('source-url');
        var minLength = $(this).data('min-length') != undefined ? parseInt($(this).data('min-length')) : 1;

        $(this).typeahead({
            minLength: minLength,
            highlight: true,
        }, {
            name: 'typeahead-dataset',
            limit: 10,
            source: function (query, syncResults, asyncResults) {
                $.get(sourceUrl, {
                        query: query
                    })
                    .done(function (data) {
                        asyncResults(data);
                    })
                    .fail(function () {
                        asyncResults([]);
                    });
            },
        });
    });

    // controller example for typeahead source URL
    // public function search(Request $request)
    // {
    //     $users = [];
    //     $query = $request->get('query');
    //
    //     if($query){
    //         $users = User::select("name")
    //                     ->where('name', 'LIKE', '%'. $query. '%')
    //                     ->get();
    //     }
    //    
    //     return response()->json($users);
    // }
}

kit.ui.config.initColorpicker = function () {
    //Colorpicker
    $('.colorpicker1').each(function () {
        $(this).colorpicker();
    });

    //color picker with addon
    $('.colorpicker2').each(function () {
        var $element = $(this);
        $element.colorpicker();

        // Update the color square on color change
        $element.on('colorpickerChange', function (event) {
            $element.find('.fa-square').css('color', event.color.toString());
        });

        // Set initial color square color
        var initialColor = $element.find('input').val();
        if (initialColor) {
            $element.find('.fa-square').css('color', initialColor);
        }
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

kit.ui.config.initDatatable = function (tableClass = 'datatable', allowButtons = true) {
    $("." + tableClass).each(function() {
        var table = $(this);
        var columns = [];
        
        // Find all th elements and check for data-no-sort attribute
        table.find('thead th').each(function(index) {
            var th = $(this);
            var columnConfig = {};
            
            // If data-no-sort='Y', disable sorting for this column
            if (th.data('no-sort') === 'Y') {
                columnConfig.orderable = false;
            }
            
            columns.push(columnConfig);
        });
        
        // Initialize DataTable with column configurations
        var dataTable = table.DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "columns": columns,
            // buttons: {
            //     dom: {
            //         button: {
            //             className: 'btn btn-secondary btn-sm'
            //         }
            //     },
            //     buttons: [
            //         {
            //             extend: 'copy'
            //         },
            //         {
            //             extend: 'csv'
            //         },
            //         {
            //             extend: 'excel'
            //         },
            //         {
            //             extend: 'pdf'
            //         },
            //         {
            //             extend: 'print'
            //         },
            //         {
            //             extend: 'colvis'
            //         }
            //     ]
            // },
        });
        
        dataTable.buttons().container().css({
            width: '100%'
        }).appendTo(table.closest('.dataTables_wrapper').find('.col-md-6:eq(1)'));

        if (!allowButtons) {
            // Remove buttons container
            dataTable.buttons().remove();
        }
    });
}

kit.ui.config.initFilePond = function () {
    $.fn.filepond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginFileValidateSize,
        FilePondPluginImageExifOrientation,
        FilePondPluginImagePreview,
        FilePondPluginImageCrop,
        FilePondPluginImageResize,
        FilePondPluginImageTransform,
        FilePondPluginImageEdit,
        FilePondPluginFileEncode,
        FilePondPluginFileRename,
        FilePondPluginFileMetadata,
        FilePondPluginFilePoster
    );

    $.fn.filepond.setDefaults({
        // File validation
        allowFileTypeValidation: true,
        allowFileSizeValidation: true,
        maxFileSize: '5MB',
        acceptedFileTypes: ['image/*', 'application/pdf'],

        // Image editing
        // allowImagePreview: true,
        // allowImageExifOrientation: true,
        // allowImageCrop: true,
        // allowImageResize: true,
        // allowImageTransform: true,
        // allowImageEdit: true,

        // Image transformation settings
        // imageCropAspectRatio: '1:1',
        // imageResizeTargetWidth: 200,
        // imageResizeTargetHeight: 200,
        // imageResizeMode: 'cover',
        // imageTransformOutputQuality: 90,
        // imageTransformOutputMimeType: 'image/jpeg',

        // File metadata and encoding
        // allowFileEncode: true,
        // allowFileRename: true,
        // fileRenameFunction: (file) => {
        //     return `upload_${Date.now()}_${file.name}`;
        // },
        // allowFileMetadata: true,
        // fileMetadataObject: {
        //     uploadedBy: 'demo-user',
        //     uploadDate: new Date().toISOString()
        // },

        // File poster for non-image files
        // allowFilePoster: true,

        // Multiple files
        // allowMultiple: true,
        // maxFiles: 5,

        // Instant upload disabled for demo
        instantUpload: false
    });

    $('.filepond').each(function () {
        var $element = $(this);

        // Skip if already initialized
        if (FilePond.find(this)) {
            return;
        }

        // Get configuration from data attributes
        var config = getFilePondConfig($element);
        // config.allowImagePreview = true;
        // config.allowImageExifOrientation = true;

        // Initialize with individual configuration
        $(this).filepond(config);
    });

    // Set server options (common for all instances)
    $.fn.filepond.setOptions({
        server: {
            process: {
                url: $('a.filepond-process-url').attr('href'),
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCSRFToken(),
                },
                onload: (response) => {
                    // Assuming the server returns a JSON object with a 'fileId' property
                    console.log("FilePond upload response:", response);
                    const res = JSON.parse(response);

                    if (res.error) {
                        showMessage('error', res.error);
                        return;
                    }

                    return res.media_id; // Adjust based on your server response
                }
            },
            revert: (uniqueFileId, load, error) => {
                console.log('Reverting file with ID:', uniqueFileId);
                // Make the DELETE request to your server
                fetch($('a.filepond-revert-url').attr('href') + '?id=' + uniqueFileId, { // Example of sending ID as query param
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': getCSRFToken(),
                        },
                    })
                    .then(res => {
                        if (res.ok) {
                            load(); // Call load() to inform FilePond the revert is successful
                        } else {
                            error('Error reverting file'); // Call error() if something went wrong
                            showMessage('error', 'Error reverting file');
                        }
                    })
                    .catch(() => {
                        error('Network error during revert');
                        showMessage('error', 'Network error during revert');
                    });
            },
            // work with return data from server

        },
    });
}

kit.ui.config.formRequiredLabel = function () {
    $('form').each(function () {
        $(this).find(':input[required]').each(function () {
            // Find the label inside the same .form-group and mark it
            $(this).closest('.form-group').find('label').addClass('required');
        });
    });
}

kit.ui.config.phosphorIconPicker = function(){
    // Selected icon preview
    const existIconClass = $('.icon-input').val();

    // Update the preview if it's a valid Phosphor icon class
    if (existIconClass != undefined  && existIconClass != null && existIconClass != '' && existIconClass.startsWith('ph ')) {
        $('#selectedIconPreview').attr('class', existIconClass);
        
        // Try to highlight the icon in the picker if it exists
        $('.icon-item').removeClass('selected');
        $(`.icon-item[data-icon="${existIconClass}"]`).addClass('selected');
        $('.icon-search').val(existIconClass);

        const filteredIcons = phosphorIcons.filter(iconClass => 
            iconClass.toLowerCase().includes(existIconClass.toLowerCase())
        );

        populateIcons(filteredIcons);
    } else {
        // Initialize the icon picker
        populateIcons();
    }

    // Toggle the dropdown
    $('.toggle-icon-picker').off('click').on('click', function() {
        $('.icon-picker-dropdown').toggle();
        if ($('.icon-picker-dropdown').is(':visible')) {
            $('.icon-search').trigger("focus");
        }
    });

    // Reset search
    $('.reset-icon-search').off('click').on('click', function() {
        $('.icon-search').val('');
        populateIcons(phosphorIcons);
    });

    // Handle icon selection
    $(document).on('click', '.icon-item', function() {
        const iconClass = $(this).data('icon');
        
        // Update the input field
        $('.icon-input').val(iconClass);
        
        // Update the preview
        $('#selectedIconPreview').attr('class', iconClass);
        
        // Highlight the selected icon
        $('.icon-item').removeClass('selected');
        $(this).addClass('selected');
        
        // Close the dropdown
        $('#iconPickerDropdown').hide();
    });

    // Handle search
    $('.icon-search').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        
        if (searchTerm === '') {
            populateIcons(phosphorIcons);
            return;
        }
        
        const filteredIcons = phosphorIcons.filter(iconClass => 
            iconClass.toLowerCase().includes(searchTerm)
        );
        
        populateIcons(filteredIcons);
    });

    // Handle manual input
    $('.icon-input').on('input', function() {
        const iconClass = $(this).val();
        
        // Update the preview if it's a valid Phosphor icon class
        if (iconClass.startsWith('ph ')) {
            $('#selectedIconPreview').attr('class', iconClass);
            
            // Try to highlight the icon in the picker if it exists
            $('.icon-item').removeClass('selected');
            $(`.icon-item[data-icon="${iconClass}"]`).addClass('selected');
        }
    });

    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.icon-picker-container').length) {
            $('#iconPickerDropdown').hide();
        }
    });
}

kit.ui.config.advancedSearch = function () {
    $('input.searchsuggest2').off('keypress').on("keypress", function(e) {
		var keycode = (e.keyCode ? e.keyCode : e.which);
        console.log('Keycode pressed: ' + keycode);
		if(keycode == '13'){   // Enter pressed
			e.preventDefault();
			$(this).siblings('.btn-search').trigger('click');
		}
	});

    $('.btn-search').off('click').on('click', function(e){
        e.preventDefault();

        $('#searchSuggestTableModal').modal('show');
		$('.search-suggest-results-container').html("");

        var searchValue = '';
		if($(this).siblings('input.searchsuggest2').length > 0){
			searchValue = $(this).siblings('input.searchsuggest2').val();
		} 

        sectionReloadAjaxPostReq({
			id : $(this).data('reloadid'),
			url : $(this).data('reloadurl') + searchValue
		}, {
			"fieldId" : $(this).data('fieldid'),
			"mainscreen" : $(this).data('mainscreen'),
			"mainreloadurl" : $(this).data('mainreloadurl'),
			"mainreloadid" : $(this).data('mainreloadid'),
			"extrafieldcontroller" : $(this).data('extrafieldcontroller'),
			"detailreloadurl" : $(this).data('detailreloadurl'),
			"detailreloadid" : $(this).data('detailreloadid'),
			"additionalreloadurl" : $(this).data('additionalreloadurl'),
			"additionalreloadid" : $(this).data('additionalreloadid'),
		});
    });

    $('.btn-search-clear').off('click').on('click', function(e){
		e.preventDefault();
		$(this).siblings('input.searchsuggest2').val("");
		$(this).siblings('input.search-val').val("");

		var ids = $(this).data('dependentfieldsid');
		if(ids == undefined) return;

		const idarr = ids.split(',');

		$.each(idarr, function(index, value) {
			$('#' + value).val("");
		});
	});

}



kit.ui.init = function () {
    kit.ui.config.initSelect2();
    kit.ui.config.initTypeahead();
    kit.ui.config.initDatatable();
    kit.ui.config.initColorpicker();
    kit.ui.config.initToastr();
    kit.ui.config.initDateTimePicker();
    kit.ui.config.initDualListbox();
    kit.ui.config.initBootstrapSwitch();
    kit.ui.config.initSummernote();
    kit.ui.config.initFilePond();
    kit.ui.config.formRequiredLabel();
    kit.ui.config.phosphorIconPicker();
    kit.ui.config.advancedSearch();
    console.log("KIT-UI JS code initialization done");
}

jQuery(function() { 
    kit.ui.init();

    $(document).on('click', '.search-suggest-modal-close-btn', function (e) {
        $('#searchSuggestTableModal').modal('hide');
        $('.search-suggest-results-container').html('');
    });

    $(document).on('click', '.screen-item', function (e) {
        e.preventDefault();

        $('.screen-item').removeClass('active');
        $(this).addClass('active');

        var screenCode = $(this).data('screen');
        var fromfav = $(this).data('fav') != undefined && $(this).data('fav') != null && 'Y' == $(this).data('fav');
        var fromdef = $(this).data('def') != undefined && $(this).data('def') != null && 'Y' == $(this).data('def');
        if (fromdef) $(this).removeAttr('data-def');

        var url = getBasepath() + '/' + screenCode;
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
            if (data.content_header_title) $(".content_header_title").html(data.content_header_title);

            if (data.subtitle) {
                document.title = "ASPI | " + data.subtitle;
            } else {
                document.title = "ASPI";
            }
        });
    });
});
// $(document).ready(function () {
    

// });
