<script>
    //     var image = document.getElementById('imageInput');
    // var cropper;

    // image.addEventListener('change', function () {
    //   var file = image.files[0];

    //   if (file) {
    //     var reader = new FileReader();

    //     reader.onload = function (e) {
    //       var img = new Image();
    //       img.src = e.target.result;

    //       img.onload = function () {
    //         if (cropper) {
    //           cropper.destroy();
    //         }

    //         var imageContainer = document.getElementById('imageContainer');
    //         imageContainer.innerHTML = '';
    //         var imgElement = document.createElement('img');
    //         imgElement.src = e.target.result;
    //         imgElement.id = 'croppedImage';
    //         imageContainer.appendChild(imgElement);

    //         cropper = new Cropper(imgElement, {
    //           aspectRatio: 1, // You can specify the aspect ratio here
    //           crop: function (event) {
    //             // Access the cropped data using event.detail
    //           },
    //         });
    //       };
    //     };

    //     reader.readAsDataURL(file);
    //   }
    // });



    // var cropButton = document.getElementById('cropButton');
    // cropButton.addEventListener('click', function () {
    //   var canvas = cropper.getCroppedCanvas();
    //   var croppedDataUrl = canvas.toDataURL('image/jpeg'); // You can change the format as needed
    //   // Send croppedDataUrl to the server using an AJAX request or form submission
    // });


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
    image.addEventListener('change', function() {
        activeAspectRatio = null;
        updateImageAndCropper()
    })

    function updateImageAndCropper() {
        var file = image.files[0];

        if (file) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var img = new Image();
                img.src = e.target.result;

                img.onload = function() {
                    if (cropper) {
                        cropper.destroy();
                    }

                    var imageContainer = document.getElementById('imageContainer');
                    imageContainer.innerHTML = '';
                    var imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.id = 'croppedImage';
                    imageContainer.appendChild(imgElement);

                    cropper = new Cropper(imgElement, {
                        aspectRatio: activeAspectRatio === 'ratio1x1' ? 1 : (activeAspectRatio === 'ratio16x9' ? 16 / 9 : null),
                        crop: function(event) {
                            // Access the cropped data using event.detail
                        },
                    });
                };
            };

            reader.readAsDataURL(file);
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
            // Get the cropped image data as a Blob
            var canvas = cropper.getCroppedCanvas();
            var croppedWidth = canvas.width;
            var croppedHeight = canvas.height;
            canvas.toBlob(function(blob) {
                formData.append('croppedImage', blob, 'cropped.jpg');
                formData.append('croppedWidth', croppedWidth);
                formData.append('croppedHeight', croppedHeight);
                // Now you can send the FormData with the Blob to the server
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
            }, 'image/jpeg'); // Specify the image format here if needed
        });

        $('#cropButton').on('click', function(e) {
            e.preventDefault();
            $('#upload-album').submit();
        });
    });
</script>

<script>
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