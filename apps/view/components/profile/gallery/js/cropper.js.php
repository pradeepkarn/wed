<script>
    // var image = document.getElementById('imageInput');
    // var cropper;
    // var activeAspectRatio = null;

    // var tabs = document.querySelectorAll('.tab');
    // tabs.forEach(function(tab) {
    //     tab.addEventListener('click', function() {
    //         activeAspectRatio = tab.getAttribute('data-aspect-ratio');
    //         updateImageAndCropper();
    //     });
    // });
    // image.addEventListener('change', function() {
    //     activeAspectRatio = null;
    //     updateImageAndCropper()
    // })

    // function updateImageAndCropper() {
    //     var file = image.files[0];

    //     if (file) {
    //         var reader = new FileReader();

    //         reader.onload = function(e) {
    //             var img = new Image();
    //             img.src = e.target.result;

    //             img.onload = function() {
    //                 if (cropper) {
    //                     cropper.destroy();
    //                 }

    //                 var imageContainer = document.getElementById('imageContainer');
    //                 imageContainer.innerHTML = '';
    //                 var imgElement = document.createElement('img');
    //                 imgElement.src = e.target.result;
    //                 imgElement.id = 'croppedImage';
    //                 imageContainer.appendChild(imgElement);

    //                 cropper = new Cropper(imgElement, {
    //                     aspectRatio: activeAspectRatio === 'ratio1x1' ? 1 : (activeAspectRatio === 'ratio16x9' ? 16 / 9 : null),
    //                     crop: function(event) {
    //                         // Access the cropped data using event.detail
    //                     },
    //                 });
    //             };
    //         };

    //         reader.readAsDataURL(file);
    //     }
    // }

    // // Call the function initially to set up the initial cropper
    // updateImageAndCropper();

    var image = document.getElementById('imageInput');
var cropper;
var activeAspectRatio = null;

var tabs = document.querySelectorAll('.tab');
tabs.forEach(function(tab) {
    tab.addEventListener('click', function() {
        activeAspectRatio = tab.getAttribute('data-aspect-ratio');
        updateImageAndCropper();
    });
});

// Add a listener for the "Keep Original" option
var keepOriginalButton = document.getElementById('aspectKeepOriginal');
keepOriginalButton.addEventListener('click', function() {
    activeAspectRatio = null; // No cropping
    destroyCropper(); // Remove the Cropper instance and cropping area
});

image.addEventListener('change', function() {
    activeAspectRatio = null;
    updateImageAndCropper();
});

function updateImageAndCropper() {
    var file = image.files[0];

    if (file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;

            img.onload = function() {
                if (cropper) {
                    destroyCropper(); // Remove the existing Cropper instance and cropping area
                }

                var imageContainer = document.getElementById('imageContainer');
                imageContainer.innerHTML = '';
                var imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                imgElement.style.width = "100%";
                imgElement.id = 'croppedImage';
                imageContainer.appendChild(imgElement);

                if (activeAspectRatio) {
                    cropper = new Cropper(imgElement, {
                        aspectRatio: activeAspectRatio === 'ratio1x1' ? 1 : (activeAspectRatio === 'ratio16x9' ? 16 / 9 : null),
                        crop: function(event) {
                            // Access the cropped data using event.detail
                        },
                    });
                }
            };
        };

        reader.readAsDataURL(file);
    }
}

function destroyCropper() {
    if (cropper) {
        cropper.destroy();
        cropper = null; // Set cropper to null to indicate that it's removed
    }
}

// Call the function initially to set up the initial cropper
updateImageAndCropper();


    function handleAlbumUpload(res) {
        if (res.success === true) {
            swalert({
                title: 'Success',
                msg: res.msg,
                icon: 'success'
            });
            location.reload();
        } else if (res.success === false) {
            swalert({
                title: 'Failed',
                msg: res.msg,
                icon: 'error'
            });
        } else {
            swalert({
                title: 'Failed',
                msg: 'Something went wrong',
                icon: 'error'
            });
        }
    }

    $(document).ready(function() {
    $('#upload-album').on('submit', function(e) {
        e.preventDefault();
        // Create a new FormData object
        var formData = new FormData(this);

        if (cropper) {
            // Get the original image data as a Blob
            var canvas = cropper.getCroppedCanvas();
            var croppedWidth = canvas.width;
            var croppedHeight = canvas.height;
            canvas.toBlob(function(blob) {
                formData.append('croppedImage', blob, 'cropped.jpg');
                formData.append('croppedWidth', croppedWidth);
                formData.append('croppedHeight', croppedHeight);
                // Now you can send the cropped image data to the server
                submitFormData(formData);
            }, 'image/jpeg'); // Specify the image format here if needed
        } else {
            // No cropping, submit the original image data directly
            submitFormData(formData);
        }
    });

    $('#cropButton').on('click', function(e) {
        e.preventDefault();
        $('#upload-album').submit();
    });

    function submitFormData(formData) {
        $.ajax({
            type: 'POST',
            url: $('#upload-album').attr('action'),
            data: formData,
            dataType: 'json',
            contentType: false, // Set contentType to false when using FormData
            processData: false, // Set processData to false when using FormData
            success: function(res) {
                handleAlbumUpload(res);
            },
            error: function(error) {
                console.error('Error:', error.statusText);
            }
        });
    }
});

    // $(document).ready(function() {
    //     $('#upload-album').on('submit', function(e) {
    //         e.preventDefault();
    //         // Create a new FormData object
    //         var formData = new FormData(this);
    //         // Get the cropped image data as a Blob
    //         var canvas = cropper.getCroppedCanvas();
    //         var croppedWidth = canvas.width;
    //         var croppedHeight = canvas.height;
    //         canvas.toBlob(function(blob) {
    //             formData.append('croppedImage', blob, 'cropped.jpg');
    //             formData.append('croppedWidth', croppedWidth);
    //             formData.append('croppedHeight', croppedHeight);
    //             // Now you can send the FormData with the Blob to the server
    //             $.ajax({
    //                 type: 'POST',
    //                 url: $('#upload-album').attr('action'),
    //                 data: formData,
    //                 dataType: 'json',
    //                 contentType: false, // Set contentType to false when using FormData
    //                 processData: false, // Set processData to false when using FormData
    //                 success: function(res) {
    //                     handleAlbumUpload(res);
    //                 },
    //                 error: function(error) {
    //                     console.error('Error:', error.statusText);
    //                 }
    //             });
    //         }, 'image/jpeg'); // Specify the image format here if needed
    //     });

    //     $('#cropButton').on('click', function(e) {
    //         e.preventDefault();
    //         $('#upload-album').submit();
    //     });
    // });
</script>

<script>
     $(document).ready(function() {
        $('.setting-album-img').on('click', function() {
            var imgSrc = $(this).data('setting-imgsrc');
            var albumId = $(this).data('setting-albumid');
            var userId = $(this).data('setting-userid');
            var settinAs = $(this).data('setting-as');
            $.ajax({
                url: '/<?php echo home . route('setAsAlbumImgAjax'); ?>', // Replace with your server URL
                type: 'POST', 
                data: {
                    id: albumId,
                    src: imgSrc,
                    userid: userId,
                    set_as: settinAs
                }, 
                success: function(res) {
                    if (res.success === true) {
                        handleAlbumUpload(res);
                    } else if (res.success === false) {
                        handleAlbumUpload(res);
                    } else {
                        handleAlbumUpload(res);
                    }
                },
                error: function(error) {
                    console.error('AJAX error:', error);
                }
            });
        });
    });
     $(document).ready(function() {
        $('.remove-album-img').on('click', function() {
            var imgSrc = $(this).data('remove-imgsrc');
            var albumId = $(this).data('remove-albumid');
            var userId = $(this).data('remove-userid');
            $.ajax({
                url: '/<?php echo home . route('removeAlbumImgAjax'); ?>', // Replace with your server URL
                type: 'POST', 
                data: {
                    id: albumId,
                    src: imgSrc,
                    userid: userId,
                }, 
                success: function(res) {
                    if (res.success === true) {
                        handleAlbumUpload(res);
                    } else if (res.success === false) {
                        handleAlbumUpload(res);
                    } else {
                        handleAlbumUpload(res);
                    }
                },
                error: function(error) {
                    console.error('AJAX error:', error);
                }
            });
        });
    });
</script>