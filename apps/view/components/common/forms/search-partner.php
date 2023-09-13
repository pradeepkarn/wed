<form action="/<?php echo home . route('search'); ?>" method="get">
    <div class="row">
        <div class="col-6 my-2">
            <div class="form-floating">
                <select class="form-select" name="state" id="state-select" aria-label="Floating label select example">
                    <?php
                    $data = json_decode(jsonData('/india/states-and-districts.json'));
                    foreach ($data->states as $key => $st) {
                        $st = obj($st);
                    ?>
                        <option data-districts='<?php echo json_encode($st->districts); ?>' value="<?php echo $st->state; ?>"><?php echo $st->state; ?></option>
                    <?php  } ?>
                </select>
                <label for="state-select"><?php echo lang('global')->state??"State"; ?></label>
            </div>
        </div>
        <div class="col-6 my-2">
            <div class="form-floating">
                <select class="form-select" name="city" id="district-select" aria-label="Floating label select example">
                </select>
                <label for="district-select"><?php echo lang('global')->city??"City"; ?></label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 my-2">
            <div class="form-floating">
                <select class="form-select" id="ageFromSelect" name="age_from" aria-label="Floating label select example">
                    <?php for ($i = 18; $i < 81; $i++) {
                        echo "<option value='$i'>$i</option>";
                    } ?>
                </select>
                <label for="ageFromSelect"><?php echo lang('global')->age_from??"Age from"; ?></label>
            </div>
        </div>
        <div class="col-6 my-2">
            <div class="form-floating">
                <select class="form-select" id="ageToSelect" name="age_to" aria-label="Floating label select example">
                    <?php for ($i = 19; $i < 82; $i++) {
                        echo "<option value='$i'>$i</option>";
                    } ?>
                </select>
                <label for="ageToSelect"><?php echo lang('global')->age_to??"Age to"; ?></label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="text-center col text-white my-2 d-grid">
        <?php if (authenticate()) : ?>
            <button <?php if (authenticate()) {echo "type='submit'";} else{echo "type='button'";} ?>  class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                    <span><?php echo lang('global')->search??"Search"; ?></span>
                    <i class="bi bi-search"></i>
            </button>
            <?php else : ?>
            <a href="/<?php echo home.route('userLogin'); ?>" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                    <span><?php echo lang('nav')->login??"Login"; ?>/<?php echo lang('nav')->register??"Register"; ?></span>
                    <i class="bi bi-person"></i>
            </a>
            <?php endif; ?>
        </div>

    </div>
</form>
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
            districtSelect.appendChild(option);
        });
    }
</script>

<script>
    function updateAgeToOptions() {
        const ageFromSelect = document.getElementById("ageFromSelect");
        const ageToSelect = document.getElementById("ageToSelect");
        const selectedAgeFrom = parseInt(ageFromSelect.value);

        // Clear existing options in "Age To" select
        ageToSelect.innerHTML = "";

        // Add new options to "Age To" select based on selected "Age From"
        for (let i = selectedAgeFrom + 1; i < 81; i++) {
            const option = document.createElement("option");
            option.value = i;
            option.textContent = i;
            ageToSelect.appendChild(option);
        }
    }
    ageFromSelect.addEventListener("change", updateAgeToOptions);
</script>