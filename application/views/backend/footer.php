<!-- Footer -->
<footer class="site-footer">
  <div class="site-footer-legal">&copy;
    <?= $this->app_info_model->AppYear(); ?> <a href="<?= base_url(); ?>backend"><?= $this->app_info_model->AppName(); ?></a>
    <?= $this->app_info_model->AppVersion(); ?>
  </div>
  <div class="site-footer-right">
    Crafted with <i class="red-600 wb wb-heart"></i> by <a href="<?= $this->app_info_model->LinkCopyright(); ?>"
      target="_blank"><?= $this->app_info_model->AppCopyright(); ?></a>
  </div>
</footer>
<!-- Core  -->
<script src="<?= base_url(); ?>assets/backend/vendor/jquery/jquery.js"></script>
<script src="<?= base_url(); ?>assets/backend/vendor/bootstrap/bootstrap.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/vendor/animsition/jquery.animsition.js"></script>
<script src="<?= base_url(); ?>assets/backend/vendor/asscroll/jquery-asScroll.js"></script>
<script src="<?= base_url(); ?>assets/backend/vendor/mousewheel/jquery.mousewheel.js"></script>
<script src="<?= base_url(); ?>assets/backend/vendor/asscrollable/jquery.asScrollable.all.js"></script>
<script src="<?= base_url(); ?>assets/backend/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
<!-- Plugins -->
<script src="<?= base_url(); ?>assets/backend/vendor/switchery/switchery.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/vendor/intro-js/intro.js"></script>
<script src="<?= base_url(); ?>assets/backend/vendor/screenfull/screenfull.js"></script>
<script src="<?= base_url(); ?>assets/backend/vendor/slidepanel/jquery-slidePanel.js"></script>
<script src="<?= base_url(); ?>assets/backend/vendor/datatables/jquery.dataTables.js"></script>

<script src="<?= base_url(); ?>assets/backend/js/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/plugins/jquery-validation/js/additional-methods.min.js"></script>


<!--<script src="<?= base_url(); ?>assets/backend/vendor/datatables-fixedheader/dataTables.fixedHeader.js"></script>-->
<script src="<?= base_url(); ?>assets/backend/vendor/datatables-bootstrap/dataTables.bootstrap.js"></script>
<script src="<?= base_url(); ?>assets/backend/vendor/datatables-responsive/dataTables.responsive.js"></script>
<script src="<?= base_url(); ?>assets/backend/vendor/datatables-tabletools/dataTables.tableTools.js"></script>
<script src="<?= base_url(); ?>assets/backend/vendor/asrange/jquery-asRange.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/vendor/bootbox/bootbox.js"></script>
<!-- Scripts -->
<script src="<?= base_url(); ?>assets/backend/js/core.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/site.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/sections/menu.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/sections/menubar.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/sections/gridmenu.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/sections/sidebar.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/configs/config-colors.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/configs/config-tour.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/components/asscrollable.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/components/animsition.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/components/slidepanel.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/components/switchery.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/components/datatables.js"></script>
<!--<script src="<?= base_url(); ?>assets/backend/examples/js/tables/datatable.js"></script>-->
<script src="<?= base_url(); ?>assets/backend/examples/js/uikit/icon.js"></script>
<!-- Custom -->
<script type="text/javascript" src="<?= base_url(); ?>assets/backend/js/plugins/moment/min/moment.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/backend/js/plugins/moment/min/lang/id.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/backend/js/plugins/livestamp/livestamp.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/backend/js/plugins/tinymce/tinymce.min.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/backend/js/plugins/uniform/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/backend/js/plugins/growl/jquery.growl.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/backend/js/plugins/jquery.scrollto.min.js"></script>

<script src="<?= base_url(); ?>assets/backend/vendor/select2/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/vendor/bootstrap-select/bootstrap-select.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/components/select2.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/components/bootstrap-select.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/custom.js"></script>


<script src="<?= base_url(); ?>assets/backend/js/custom.js"></script>

<script>
  (function (document, window, $) {
    'use strict';
    var Site = window.Site;
    $(document).ready(function () {
      Site.run();
      $(".uniformcheckbox").uniform();
    });
  })(document, window, jQuery);
</script>
</body>

</html>
<!-----------------------------------------------------------------END------------------------------------------------------------------->