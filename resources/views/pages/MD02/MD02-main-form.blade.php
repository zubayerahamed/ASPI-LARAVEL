<style>
    .kitfilepond{
        width: 100%;
        min-height: 160px;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        padding: .75rem .75rem;
        background-color: #fff;
        box-shadow: inset 0 0 0 transparent;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* 2 columns on mobile */
        gap: 8px;
        padding: 5px;
    }
    .file-preview{
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 4px;
        display: block;
    }
    .file-preview img{
        width: 100%;
        height: auto;
    }

    /* Tablet: 3 columns */
    @media (min-width: 768px) {
        .kitfilepond {
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        .file-preview img {
            height: 140px;
        }
    }

    /* Desktop: 4-5 columns */
    @media (min-width: 1024px) {
        .kitfilepond {
            grid-template-columns: repeat(3, 1fr);
            gap: 11.11%;
        }
        .file-preview img {
            width: 100%;
            height: 100%;
        }
    }
</style>

<div class="card card-default">
    <div class="card-body">
        <form id="mainform" action="{{ $category->id == null ? route('MD02.create') : route('MD02.update', ['id' => $category->id]) }}" method="POST">
            @csrf
            @if ($category->id != null)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $category->id }}">
                <input type="hidden" name="remove_thumbnail" value="NO">
            @endif

            

            <div class="row">
                <div class="col-md-12">
                    
                    <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="type">Parent category</label>
                        <select class="form-control select2bs4" id="parent_category_id" name="parent_category_id">
                            <option value="">-- Select Parent Category --</option>
                            @include('pages.MD02.MD02-category-recursive', [
                                'categoryTree' => $categoryTree,
                                'count' => 0,
                            ])
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label" for="seqn">Sequence number</label>
                        <input type="number" class="form-control" id="seqn" name="seqn" value="{{ $category->seqn }}" min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label" for="icon">Icon</label>
                        <div class="icon-picker-container">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i id="selectedIconPreview" class="{{ $category->icon }}"></i></span>
                                </div>
                                <input type="text" class="form-control icon-input" name="icon" value="{{ $category->icon }}">
                                <div class="input-group-append">
                                    <div class="input-group-text toggle-icon-picker"><i class="ph ph-caret-down"></i></div>
                                </div>
                            </div>

                            <div class="icon-picker-dropdown" id="iconPickerDropdown">
                                <div class="icon-picker-search">
                                    <div class="input-group">
                                        <input type="text" id="iconSearch" class="form-control icon-search" placeholder="Search icons...">
                                        <div class="input-group-append">
                                            <div class="input-group-text reset-icon-search"><i class="ph ph-arrows-clockwise"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="icon-picker-icons" id="iconPickerIcons">
                                    <!-- Icons will be populated here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="4">{{ $category->description }}</textarea>
                    </div>
                </div>

                

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_featured" name="is_featured" {{ $category->is_featured ? 'checked' : '' }}>
                            <label for="is_featured" class="custom-control-label form-label">Is Featured?</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="is_active" name="is_active" {{ $category->is_active ? 'checked' : '' }}>
                            <label for="is_active" class="custom-control-label form-label">Is Active?</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-left">
                    <button
                            data-reloadid="main-form-container"
                            data-reloadurl="{{ route('MD02', ['id' => 'RESET']) }}"
                            data-detailreloadid="header-table-container"
                            data-detailreloadurl="{{ route('MD02.header-table') }}"
                            type="reset"
                            class="btn btn-sm btn-default btn-reset d-flex align-items-center gap-2">
                        <i class="ph ph-broom"></i> <span>Clear</span>
                    </button>
                </div>
                <div class="flex-grow-1 justify-content-end d-flex gap-2">
                    @if ($category->id == null)
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Save</span>
                        </button>
                    @else
                        <button data-url="{{ route('MD02.delete', ['id' => $category->id]) }}" type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center gap-2">
                            <i class="ph ph-trash"></i> <span>Delete</span>
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary btn-submit d-flex align-items-center gap-2">
                            <i class="ph ph-floppy-disk"></i> <span>Update</span>
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    // let dropzoneInstances = {};
    // let uploadedFiles = [];
    // let logEntries = [];
    if (typeof window.dropzoneInstances === 'undefined') {
        window.dropzoneInstances = {};
    }
    if (typeof window.uploadedFiles === 'undefined') {
        window.uploadedFiles = [];
    }
    if (typeof window.logEntries === 'undefined') {
        window.logEntries = [];
    }

    function initDropzone(containerId = 'myDropzone') {
        const $container = $(`#${containerId}`);
        
        if (!$container.length) {
            console.error(`Dropzone container #${containerId} not found`);
            return;
        }

        // Destroy existing instance if it exists
        if (dropzoneInstances[containerId]) {
            dropzoneInstances[containerId].destroy();
            $container.html('');
            $container.removeClass("dz-started dz-drag-hover");
        }

        // Get configuration values from data attributes
        const maxFilesize = $container.data('maxfilesize');
        const maxFiles = $container.data('maxfiles');
        const acceptedFiles = $container.data('acceptedfiles');
        
        // Parse maxFilesize string (e.g., "2MB" -> 2)
        const parseMaxFilesize = (sizeString) => {
            if (!sizeString) return 2; // default
            
            const match = sizeString.match(/^(\d+)/);
            return match ? parseInt(match[1]) : 2;
        };

        // Configuration
        const config = {
            url: $('a.filepond-process-url').attr('href'),
            maxFilesize: parseMaxFilesize(maxFilesize),
            maxFiles: maxFiles ? parseInt(maxFiles) : 1,
            acceptedFiles: acceptedFiles || 'image/*',
            addRemoveLinks: true,
            timeout: 5000,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + file.name;
            },
            init: function() {
                // Store reference to this instance
                const dzInstance = this;
                
                // Add event handlers for this specific instance
                dzInstance.on("addedfile", function(file) {
                    console.log(`File added to ${containerId}:`, file.name);
                    addLog(`${containerId}: File added - ${file.name}`, "info");
                    
                    // Add to uploadedFiles array
                    uploadedFiles.push({
                        id: containerId,
                        name: file.name,
                        size: file.size,
                        status: 'queued'
                    });
                });
                
                dzInstance.on("removedfile", function(file) {
                    console.log(`File removed from ${containerId}:`, file.name);
                    addLog(`${containerId}: File removed - ${file.name}`, "warning");
                    
                    // Remove from uploadedFiles array
                    uploadedFiles = uploadedFiles.filter(f => 
                        !(f.id === containerId && f.name === file.name)
                    );
                });
                
                dzInstance.on("success", function(file, response) {
                    console.log(`Upload successful in ${containerId}:`, file.name);
                    addLog(`${containerId}: Upload successful - ${file.name}`, "success");
                    
                    // Update status in uploadedFiles
                    const fileIndex = uploadedFiles.findIndex(f => 
                        f.id === containerId && f.name === file.name
                    );
                    if (fileIndex !== -1) {
                        uploadedFiles[fileIndex].status = 'uploaded';
                        uploadedFiles[fileIndex].response = response;
                    }
                });
                
                dzInstance.on("error", function(file, errorMessage) {
                    console.error(`Upload error in ${containerId}:`, errorMessage);
                    addLog(`${containerId}: Upload error - ${file.name}: ${errorMessage}`, "error");
                    
                    // Update status in uploadedFiles
                    const fileIndex = uploadedFiles.findIndex(f => 
                        f.id === containerId && f.name === file.name
                    );
                    if (fileIndex !== -1) {
                        uploadedFiles[fileIndex].status = 'error';
                        uploadedFiles[fileIndex].error = errorMessage;
                    }
                });
                
                dzInstance.on("sending", function(file, xhr, formData) {
                    console.log(`Sending from ${containerId}:`, file.name);
                    // Add custom data if needed
                    formData.append("dropzoneId", containerId);
                });
            }
        };

        // Initialize Dropzone
        dropzoneInstances[containerId] = new Dropzone(`#${containerId}`, config);

        console.log(`Dropzone initialized for #${containerId} with config:`, config);
    }

    // Initialize all Dropzones on the page
    function initAllDropzones() {
        $('.dropzone').each(function() {
            const containerId = $(this).attr('id');
            if (containerId) {
                destroyDropzone(containerId);
                initDropzone(containerId);
            }
        });
    }

    // Helper function to add log
    function addLog(message, type = "info") {
        const timestamp = new Date().toLocaleTimeString();
        const logEntry = {
            timestamp: timestamp,
            message: message,
            type: type
        };
        
        logEntries.unshift(logEntry);
        console.log(`[${timestamp}] ${type.toUpperCase()}: ${message}`);
        
        // Optional: Update a log element on the page
        if ($('#dropzone-log').length) {
            const logHtml = `<div class="log-entry ${type}">${timestamp}: ${message}</div>`;
            $('#dropzone-log').prepend(logHtml);
        }
    }

    // Get a specific Dropzone instance
    function getDropzoneInstance(containerId) {
        return dropzoneInstances[containerId] || null;
    }

    // Remove all files from a specific Dropzone
    function removeAllFiles(containerId) {
        const dz = getDropzoneInstance(containerId);
        if (dz) {
            dz.removeAllFiles(true);
            addLog(`${containerId}: All files removed`, "warning");
            
            // Remove from uploadedFiles array
            uploadedFiles = uploadedFiles.filter(f => f.id !== containerId);
        }
    }

    // Process queue for a specific Dropzone
    function processQueue(containerId) {
        const dz = getDropzoneInstance(containerId);
        if (dz) {
            const queuedFiles = dz.getQueuedFiles();
            if (queuedFiles.length > 0) {
                dz.processQueue();
                addLog(`${containerId}: Processing ${queuedFiles.length} files`, "info");
            } else {
                addLog(`${containerId}: No files in queue to process`, "warning");
            }
        }
    }

    // Destroy a specific Dropzone instance
    function destroyDropzone(containerId) {
        if (dropzoneInstances[containerId]) {
            dropzoneInstances[containerId].destroy();
            delete dropzoneInstances[containerId];
            addLog(`${containerId}: Dropzone destroyed`, "warning");
        }
    }


    $(document).ready(function() {
        kit.ui.init();

        // Disable auto discovery to prevent conflicts
        //Dropzone.autoDiscover = false;
        
        // Initialize all dropzones on the page
        //initAllDropzones();
        
        // Optional: Reinitialize dropzones on AJAX content load
        // $(document).on('ajaxComplete', function() {
        //     // Wait a bit for DOM to be ready
        //     setTimeout(function() {
        //         $('.dropzone:not(.dz-started)').each(function() {
        //             const containerId = $(this).attr('id');
        //             if (containerId && !dropzoneInstances[containerId]) {
        //                 initDropzone(containerId);
        //             }
        //         });
        //     }, 100);
        // });

        $('.btn-reset').off('click').on('click', function(e) {
            e.preventDefault();

            sectionReloadAjaxReq({
                id: $(this).data('reloadid'),
                url: $(this).data('reloadurl')
            });

            sectionReloadAjaxReq({
                id: $(this).data('detailreloadid'),
                url: $(this).data('detailreloadurl')
            });
        });

        $('.btn-submit').off('click').on('click', function(e) {
            e.preventDefault();
            submitMainForm();
        });

        $('.btn-delete').off('click').on('click', function(e) {
            e.preventDefault();
            sweetAlertConfirm(() => {
                deleteRequest($(this).data('url'));
            });
        });

        $('.remove-thumbnail-btn').off('click').on('click', function(e) {
            e.preventDefault();
            $('.thumbnail-image-container').remove();
            $('input[name="remove_thumbnail"]').val('YES');
        });
    })
</script>