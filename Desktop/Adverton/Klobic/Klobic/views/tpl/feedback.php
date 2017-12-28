<?php if(PRODUCTION) { ?>
    <script type="text/javascript" charset="utf-8" src="/js/feedback.min.js?v=<?php echo APP_VERSION; ?>" async="true"></script>
<?php } else { ?>
    <script type="text/javascript" charset="utf-8" src="/js/app/feedback.js?v=<?php echo APP_VERSION; ?>" async="true"></script>
<?php } ?>
<div class="feedback-box">
  <div class="content"> <a class='close' href="#">x</a>
    <div class="confirm">
      <h1><strong>BOOOM!</strong> <span>We'll get in touch with you soon.</span></h1>
    </div>
    <div class="header">How can we help you?</div>
    <section>
      <textarea name="feedback"></textarea>
      <button id='submit' class="BannerItem__bannerBuyContainer"> Send</button>
    </section>
  </div>
</div>
<button id="feedback">Support</button>