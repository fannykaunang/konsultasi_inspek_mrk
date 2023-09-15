<!-----------------------------------------------------------------BEGIN----------------------------------------------------------------->
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">
  <title><?php if (!empty($page_title)) echo $page_title; ?></title>
  <link rel="apple-touch-icon" href="<?= base_url(); ?>assets/backend/images/apple-touch-icon.png">
  <link rel="icon" type="image/png" href="<?= base_url(); ?>assets/frontend/themes/2023/logo-merauke.ico">
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
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/datatables-bootstrap/dataTables.bootstrap.css">
  <!--<link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/datatables-fixedheader/dataTables.fixedHeader.css">-->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/datatables-responsive/dataTables.responsive.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/examples/css/tables/datatable.css">
  <!-- Fonts -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/fonts/font-awesome/font-awesome.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/fonts/web-icons/web-icons.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/fonts/brand-icons/brand-icons.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/formvalidation/formValidation.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/js/plugins/uniform/css/uniform.default.min.css">

  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/js/plugins/growl/jquery.growl.css">

  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/select2/select2.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/vendor/bootstrap-select/bootstrap-select.css">
  <!-- Custom -->
  <?php $this->load->view('backend/themes'); ?>
  <link rel='stylesheet' href="<?= base_url(); ?>assets/backend/fonts-custom/fonts.css">
  <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
  <link rel='stylesheet' href="<?= base_url(); ?>assets/backend/css/custom.css">
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