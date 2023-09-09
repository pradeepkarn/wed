<!-- ======= Contact Section ======= -->
<section id="contact" class="contact">

  <div class="container" data-aos="fade-up">

    <header class="section-header">
      <h2>Contact</h2>
      <p>Contact Us</p>
    </header>

    <div class="row gy-4">

      <div class="col-lg-6">

        <div class="row gy-4">
          <div class="col-md-6">
            <div class="info-box">
              <i class="bi bi-geo-alt"></i>
              <h3>Address</h3>
              <p>Darbhanga, Bihar</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box">
              <i class="bi bi-telephone"></i>
              <h3>Call Us</h3>
              <p>+91 8825137323</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box">
              <i class="bi bi-envelope"></i>
              <h3>Email Us</h3>
              <p>pkarn@live.in</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box">
              <i class="bi bi-clock"></i>
              <h3>Open Hours</h3>
              <p>Always</p>
            </div>
          </div>
        </div>

      </div>

      <div class="col-lg-6">
        <form id="send-my-message-form" action="/<?php echo home.route('sendContactMessageAjax'); ?>" method="post">
          <div class="row gy-4">

            <div class="col-md-6">
              <input type="text" name="name" class="form-control" placeholder="Your Name" required>
            </div>

            <div class="col-md-6 ">
              <input type="email" class="form-control" name="email" placeholder="Your Email" required>
            </div>

            <div class="col-md-12">
              <input type="text" class="form-control" name="subject" placeholder="Subject" required>
            </div>

            <div class="col-md-12">
              <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
            </div>

            <div class="col-md-12 text-center">
            <p id="please-wait-text" class="text-center">Please wait ...
                  <img src="/<?php echo MEDIA_URL; ?>/site/loading.gif" alt="Loading...">
                </p>
                <?php ajaxActive("#please-wait-text"); ?>
              <!-- <div class="loading">Loading</div> -->
              <!-- <div class="error-message"></div>
              <div class="sent-message">Your message has been sent. Thank you!</div> -->

              <button type="submit" class="btn btn-primary" id="send-my-message-btn">Send Message</button>
            </div>

          </div>
        </form>

      </div>

    </div>

  </div>

</section><!-- End Contact Section -->
<script>
  function handleContactForm(res) {
    if (res.success === true) {
      swalert({
        title: 'Success',
        msg: res.msg,
        icon: 'success'
      });
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
</script>
<?php
send_to_server("#send-my-message-btn", "#send-my-message-form", "handleContactForm");
?>