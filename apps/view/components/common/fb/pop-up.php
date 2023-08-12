<style>
  /* Style for the popup overlay */
.popup {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 9999;
}

/* Style for the popup content box */
.popup-content {
    position: relative;
    width: 300px;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    text-align: center;
}

/* Style for the login button */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #3b5998; /* Facebook brand color */
    color: #fff;
    font-size: 16px;
    cursor: pointer;
}

/* Style for the Facebook icon */
.bi-facebook {
    margin-right: 10px;
    font-size: 20px;
}

/* Style for the close icon */
.close-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
}

/* Add hover effect to the login button */
.btn:hover {
    background-color: #324d80; /* Darken the color on hover */
}

</style>
<div id="popup" class="popup">
    <div class="popup-content">
        <a class="btn btn-primary" href="/<?php echo home.route('userLogin'); ?>">Login</a>
        <p>Or Login via Facebook</p>
        <button class="btn btn-primary" onclick="openFacebookLoginPopup()">
            <i class="bi bi-facebook"></i> Login with Facebook
        </button>
        <span class="close-icon" id="closeButton">&times;</span>
    </div>
</div>

<script>
    // Check if the popup was closed before and set the default state accordingly
    var popupClosed = getCookie('popupClosed');
    if (popupClosed === 'true') {
        document.getElementById('popup').style.display = 'none';
    }

    // Close the popup and save the closing state in a cookie when the close button is clicked
    document.getElementById('closeButton').addEventListener('click', function() {
        document.getElementById('popup').style.display = 'none';
        setCookie('popupClosed', 'true', 1); // Set the cookie to expire after 30 days
    });
    
</script>