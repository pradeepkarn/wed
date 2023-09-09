<style>
    <?php 
    $prof = $context->prof;
    $rgb_left = $context->rgb_left;
    $rgb_right = $context->rgb_right;
    $img_detail_ht = $prof->is_public==1?"100vh":"100%";
    $prof->cover = $prof->is_public==1?$prof->cover:"default-cover.jpg";
    ?>
    #profile-name {
        font-weight: 650;
    }

    .profile-cover {
        height: 300px;
        position: relative;
        background-image: url(/<?php echo MEDIA_URL; ?>/images/profiles/<?php echo $prof->cover; ?>);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    .img-details {
        position: relative;
        min-height: <?php echo $img_detail_ht; ?>;
        top: -50px;
    }


    @media screen and (min-width: 768px) {
        .v-center {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        div#cam-div {
            position: relative;
            background-color: rgba(0, 0, 0, 0.6);
            height: 40px;
            width: 40px;
            border-radius: 50%;
            bottom: 60px;
            left: 155px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        div#cam-div i#profile-img-camera-btn {
            position: absolute;
            font-size: 20px;
            font-weight: 700;
            z-index: +10;
            cursor: pointer;
            color: white;

        }

        div#cam-div-cover {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.6);
            height: 40px;
            width: 40px;
            border-radius: 50%;
            top: 230px;
            right: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        div#cam-div-cover i#cover-img-camera-btn {
            position: absolute;
            font-size: 20px;
            font-weight: 700;
            z-index: +10;
            cursor: pointer;
            color: white;

        }

    }

    @media screen and (max-width: 767px) {
        .v-center {
            display: flex;
            flex-direction: column;
            /* Arrange items vertically */
            align-items: center;
            /* Center horizontally */
            justify-content: center;
            /* Center vertically */
            gap: 20px;
        }

        .img-details {
            position: relative;
            min-height: <?php echo $img_detail_ht; ?>;
            top: -100px;
        }

        div#cam-div {
            position: relative;
            background-color: rgba(0, 0, 0, 0.6);
            height: 40px;
            width: 40px;
            border-radius: 50%;
            bottom: 60px;
            left: 155px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        div#cam-div i#profile-img-camera-btn {
            position: absolute;
            font-size: 20px;
            font-weight: 700;
            z-index: +10;
            cursor: pointer;
            color: white;

        }

        div#cam-div-cover {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.6);
            height: 40px;
            width: 40px;
            border-radius: 50%;
            top: 230px;
            right: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        div#cam-div-cover i#cover-img-camera-btn {
            position: absolute;
            font-size: 20px;
            font-weight: 700;
            z-index: +10;
            cursor: pointer;
            color: white;

        }
    }

    img#user-profile-img {
        cursor: pointer;
        position: relative;
        height: 200px;
        width: 200px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid <?php echo $rgb_left; ?>;
    }

    .below-cover {
        position: relative;
    }


    .profile-section {
        display: flex;
        position: absolute;
        width: 100%;
        height: 100%;
        /* Set the height of the section to your desired value */
        overflow: hidden;
        /* Hide any content that may overflow from the child divs */
    }

    .grad-left,
    .grad-right {
        flex: 1;
        /* Each child div takes half of the width of .profile-section */
        height: 100%;
        /* The gradient divs should cover the full height of .profile-section */
    }

    .grad-left {
        /* Define the gradient background for the left side */
        background: linear-gradient(to bottom, <?php echo $rgb_left; ?>, rgb(0, 0, 0));
    }

    .grad-right {
        /* Define the gradient background for the right side */
        background: linear-gradient(to bottom, <?php echo $rgb_right; ?>, rgb(0, 0, 0));
    }
    select.form-select,textarea.form-control,input[type='text'],input[type='number'],input[type='date']{
        border: 1px solid green;
    }
    /* .is_public_div{
        position: relative;
        align-items: center;
        display: flex;
        justify-content: space-between;
    } */
    /* .is_public_div input[type='checkbox']{
        position: absolute;
        
    } */
</style>

