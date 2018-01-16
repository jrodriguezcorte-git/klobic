<?php if(PRODUCTION) { ?>
    <script type="text/javascript" charset="utf-8" src="/js/feedback.min.js?v=<?php echo APP_VERSION; ?>" async="true"></script>
<?php } else { ?>
    <script type="text/javascript" charset="utf-8" src="/js/app/feedback.js?v=<?php echo APP_VERSION; ?>" async="true"></script>
<?php } ?>
<div class="feedback-box">
  <div class="content"> <a class='close' href="#">x</a>
    <div class="confirm">
      <h1><strong>BOOOM!</strong> <span>Nosotros te contactaremos en breve.</span></h1>
    </div>
    <div class="header">¿Cómo podemos ayudarte?</div>
    <section>
      <textarea name="feedback"></textarea>
      <button id='submit' class="BannerItem__bannerBuyContainer"> Enviar</button>
    </section>
  </div>
</div>
<button id="feedback">Soporte</button>