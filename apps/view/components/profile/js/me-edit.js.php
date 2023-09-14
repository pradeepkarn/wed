<?php
$prof = $context->prof;
?>
<script>
    // for relations
    const elmnts = `<div class="col-md-6">
    <div class="mb-3">
        <label class="form-label"><?php echo lang('global')->relation_type ?? "Relation type"; ?>:</label>
        <input type="text" placeholder="<?php echo lang('global')->relative_details ?? "Cousin Brother, Uncle, etc."; ?>" class="form-control my-2" name="rel_type[]">
    </div>
</div>
<div class="col-md-6">
    <div class="mb-3">
        <label class="form-label"><?php echo lang('global')->relative_name ?? "Name"; ?>:</label>
        <input type="text" placeholder="<?php echo lang('global')->relative_name ?? "Name"; ?>" class="form-control my-2" name="rel_name[]">
    </div>
</div>
<div class="col-md-12">
    <div class="mb-3">
        <label class="form-label"><?php echo lang('global')->details ?? "details"; ?>:</label>
        <textarea class="form-control" placeholder="<?php echo lang('global')->work_details ?? "Name"; ?>" name="about_rel[]" rows="4"></textarea>
    </div>
    <hr>
</div>`;

    $(document).ready(function() {
        $("#add-more-relations").click(function() {
            $("#more-rel-div").append(elmnts);
        });
    });

    // for mobiles
    const moreMobiles = `<div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label"><?php echo lang('global')->mobile ?? "Mobile"; ?>:</label>
                            <input type="text" name="contacts[]" class="form-control my-2 custom-number-input">
                        </div>
                    </div>`;
    $(document).ready(function() {
        $("#add-more-mobiles").click(function() {
            $("#more-mobile-div").append(moreMobiles);
        });
    });
    // for image uploads
    const image = document.getElementById('user-profile-img');
    const fileInput = document.getElementById('profile-img-fileInput');
    const camDiv = document.getElementById('cam-div');

    const imageCover = document.getElementById('user-profile-cover');
    const fileInputCover = document.getElementById('cover-img-fileInput');
    const camDivCover = document.getElementById('cam-div-cover');


    // JavaScript code
    uploadImg(image, fileInput, camDiv);
    uploadImg(image, fileInput, image);

    uploadImg(imageCover, fileInputCover, camDivCover, bg = true);
    // uploadImg(imageCover, fileInputCover, imageCover, bg = true);

    function uploadImg(image, fileInput, camDiv, bg = false) {
        camDiv.addEventListener('click', function() {
            fileInput.click();
        });


        // Prevent default behavior for dragover event to allow drop
        // image.addEventListener('dragover', function(event) {
        //     event.preventDefault();
        // });

        // Handle the drop event
        // image.addEventListener('drop', function(event) {
        //     event.preventDefault();

        //     const file = event.dataTransfer.files[0];
        //     checkImg(file, image, bg)
        // });

        // Handle file selection using the file input
        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            checkImg(file, image, bg)
        });
    }

    function checkImg(file, image, bg = false) {
        if (file) {
            // Check if the selected file is an image
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function() {
                    if (bg === true) {
                        image.style.background = `url('${reader.result}')`;
                        image.style.backgroundSize = 'cover'; // Optional: Set the background size to cover
                        image.style.backgroundPosition = 'center';
                    } else {
                        image.src = reader.result;
                    }

                }
                reader.readAsDataURL(file);
            } else {
                // Display an error message if the selected file is not an image
                alert('Please select an image file.');
                return;
            }
        }
    }
</script>

<script>
    const districtSelect = document.querySelector("#district-select");
    document.addEventListener('DOMContentLoaded', () => {
        const stateSelect = document.querySelector("#state-select");
        setDistric(stateSelect);
        stateSelect.addEventListener('change', () => {
            setDistric(stateSelect);
        });
    });
    // set the distrct
    const setDistric = (stateSelect) => {
        const selectedOption = stateSelect.options[stateSelect.selectedIndex];
        const districtsData = selectedOption.getAttribute('data-districts');
        const districts = JSON.parse(districtsData);
        updateDistrictOptions(districts, districtSelect);
    }
    // set the distric according to state
    function updateDistrictOptions(districts, districtSelect) {
        // Clear existing options
        districtSelect.innerHTML = "";
        // Add new options based on the selected state's districts
        districts.forEach(district => {
            const option = document.createElement("option");
            option.value = district;
            option.textContent = district;
            if (district == "<?php echo $prof->city; ?>") {
                option.selected = true;
            }
            districtSelect.appendChild(option);
        });
    }
</script>