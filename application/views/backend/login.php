<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Halaman Login | Pemeriksaan Anggaran">
  <meta name="author" content="fannykaunang">
  <title>
    Halaman Login | Pemeriksaan Anggaran
  </title>
  <link rel="apple-touch-icon" href="<?= base_url(); ?>assets/backend/images/apple-touch-icon.png">
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/backend/images/favicon.png">
  <!-- Stylesheets -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/css/bootstrap-extend.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/css/site.min.css">

  <!-- Plugins -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/animsition/animsition.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/asscrollable/asScrollable.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/switchery/switchery.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/intro-js/introjs.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/slidepanel/slidePanel.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/flag-icon-css/flag-icon.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/examples/css/pages/login-v3.min.css">
  <!-- Fonts -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/fonts/web-icons/web-icons.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/fonts/brand-icons/brand-icons.min.css">
  <link rel='stylesheet' href="<?= base_url(); ?>assets/backend/fonts-custom/fonts.css">
  <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/css/custom.css">
  <!--[if lt IE 9]>
    <script src="<?= base_url(); ?>assets/backend/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <script src="<?= base_url(); ?>assets/backend/media-match/media.match.min.js"></script>
    <script src="<?= base_url(); ?>assets/backend/respond/respond.min.js"></script>
    <![endif]-->
  <!-- Scripts -->
  <script src="<?= base_url(); ?>assets/backend/vendor/modernizr/modernizr.js"></script>
  <script src="<?= base_url(); ?>assets/backend/vendor/breakpoints/breakpoints.js"></script>
  <script>
    Breakpoints();
  </script>

</head>

<body class="page-login-v3 layout-full">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
  <!-- Page -->
  <div id="mycanvas"><canvas id="animated"></canvas></div>

  <div class="page animsition vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
      <div class="panel">
        <div class="panel-body">
          <div class="brand">
            <img class="brand-img" src="<?= base_url(); ?>assets/backend/images/logo-mrk.png" alt="" width="80px">
            <h2 class="brand-text font-size-16">
              <?= $this->app_info_model->AppName(); ?>
            </h2>
            <h2 class="brand-text font-size-18">
              <?= $this->app_info_model->AppDashboardName(); ?>
            </h2>
          </div>
          <form method="post" name="FormLogin" action="<?= base_url(); ?>backend/login">
            <div class="form-group form-material floating">
              <input id="EmailUser" name="EmailUser" class="form-control" required
                title="Masukkan email atau nomer handphone" />
              <label class="floating-label">Email / Handphone</label>
            </div>
            <div class="form-group form-material floating">
              <input type="password" id="PasswordUser" name="PasswordUser" class="form-control" required
                title="Masukkan password" />
              <label class="floating-label">Password</label>
            </div>
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
              value="<?= $this->security->get_csrf_hash(); ?>" />

            <p>
              <?php if (isset($errorlogin)) {
                echo $errorlogin;
              }
              ; ?>
            </p>

            <button type="submit" class="btn btn-danger btn-block btn-lg margin-top-40">Login</button>
            <br />

            <p class="text-right hidden">
              Lupa password? <a href="<?= base_url(); ?>backend/reset_password">Reset Password</a>
            </p>

            <!-- <p class="text-right">
              Kembali ke <a href="<?= base_url(); ?>">Halaman Depan</a>
            </p> -->

          </form>
          <br />
        </div>
      </div>

      <!-- <div class="modal fade modal-fade-in-scale-up" id="DialogInformation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">INFORMASI</h4>
            </div>
            <div class="modal-body text-left">
              <h4>
               Gagal login?
              </h4>
              <p>
                Demi keamanan, silahkan melakukan perubahan password melalui menu reset password.
              </p>
              <p>
                Bila ada perubahan alamat email, silahkan hubungi Administrator. Terimakasih
              </p>
            </div>    
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"> Tutup </button>              
            </div>                
          
          </div>
       </div>
      </div> -->

      <footer class="page-copyright page-copyright-inverse">
        <p><a href="<?= base_url(); ?>"><?= $this->app_info_model->AppName(); ?></a></p>
        <p>Copyright &copy;
          <?= $this->app_info_model->AppYear(); ?>
          <?= $this->app_info_model->AppVersion(); ?>. <a href="https://inspektorat.merauke.go.id"
            target="_blank">inspektorat.merauke.go.id</a> All RIGHT RESERVED.
        </p>
        <div class="social">
          <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-twitter" aria-hidden="true"></i>
          </a>
          <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-facebook" aria-hidden="true"></i>
          </a>
          <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-google-plus" aria-hidden="true"></i>
          </a>
        </div>
      </footer>
    </div>
  </div>
  <!-- End Page -->
  <?= $this->frontend_model->InsertVisitorLog(); ?>
  <!-- Core  -->
  <script src="<?= base_url(); ?>assets/backend/vendor/jquery/jquery.js"></script>
  <script src="<?= base_url(); ?>assets/backend/vendor/bootstrap/bootstrap.js"></script>
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
  <script src="<?= base_url(); ?>assets/backend/vendor/jquery-placeholder/jquery.placeholder.js"></script>
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
  <script src="<?= base_url(); ?>assets/backend/js/components/jquery-placeholder.js"></script>
  <script src="<?= base_url(); ?>assets/backend/js/components/material.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/backend/js/plugins/login/EasePack.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/backend/js/plugins/login/TweenLite.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/backend/js/plugins/login/animated.js"></script>
  <script>
    $(function () {
      "use strict";
      CanvasBG.init({
        Loc: {
          x: window.innerWidth / 2,
          y: window.innerHeight / 3.3
        },
      });
    });
  </script>
  <script>
    (function (document, window, $) {
      'use strict';
      var Site = window.Site;
      $(document).ready(function () {
        Site.run();
      });
    })(document, window, jQuery);


  //$("#DialogInformation").modal('show');

  </script>
</body>

</html>


<!--<?= $this->secure_model->InsertSystemLog('SystemLog', 'Halaman login', 'akses'); ?>-->