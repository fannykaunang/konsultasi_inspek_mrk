<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">
  <title><?=$this->app_info_model->AppNameTitleDashboard();?></title>
  <link rel="apple-touch-icon" href="<?=base_url();?>assets/backend/images/apple-touch-icon.png">
  <link rel="shortcut icon" href="<?=base_url();?>assets/backend/images/favicon.ico">
  <!-- Stylesheets -->
  <link rel="stylesheet" href="<?=base_url();?>assets/backend/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/backend/css/bootstrap-extend.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/backend/css/site.min.css">

  <!-- Plugins -->
  <link rel="stylesheet" href="<?=base_url();?>assets/backend/vendor/animsition/animsition.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/backend/vendor/asscrollable/asScrollable.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/backend/vendor/switchery/switchery.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/backend/vendor/intro-js/introjs.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/backend/vendor/slidepanel/slidePanel.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/backend/vendor/flag-icon-css/flag-icon.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/backend/examples/css/pages/login-v3.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/backend/js/plugins/growl/jquery.growl.css">
  <!-- Fonts -->
  <link rel="stylesheet" href="<?=base_url();?>assets/backend/fonts/web-icons/web-icons.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/backend/fonts/brand-icons/brand-icons.min.css">
  <link rel='stylesheet' href="<?=base_url();?>assets/backend/fonts-custom/fonts.css">
  <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?=base_url();?>assets/backend/css/custom.css">
  <!--[if lt IE 9]>
    <script src="<?=base_url();?>assets/backend/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <script src="<?=base_url();?>assets/backend/media-match/media.match.min.js"></script>
    <script src="<?=base_url();?>assets/backend/respond/respond.min.js"></script>
    <![endif]-->
  <!-- Scripts -->
  <script src="<?=base_url();?>assets/backend/vendor/modernizr/modernizr.js"></script>
  <script src="<?=base_url();?>assets/backend/vendor/breakpoints/breakpoints.js"></script>
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
	
  <div class="page animsition vertical-align text-center" data-animsition-in="fade-in"data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
      <div class="panel">
        <div class="panel-body">
          <div class="brand">
            <img class="brand-img" src="<?=base_url();?>assets/backend/images/logo-mrk.png" alt="" width="100px">
            <h2 class="brand-text font-size-18"><?=$this->app_info_model->AppName();?></h2>
          </div>

          <div id="BlockResetPassword">         
            <h4>RESET PASSWORD</h4>            
            <form name="FormResetPassword" id="FormResetPassword">
              <div class="form-group form-material floating">
                <input type="email" id="EmailUser" name="EmailUser" class="form-control" required title="email"/>
                <label class="floating-label">Email</label>
              </div>
             
              <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
              
              <p>
                <?php if(isset($errorlogin)){echo $errorlogin;};?>
              </p>
              
              <button type="submit" class="btn btn-danger btn-block btn-lg margin-top-40">Kirim Kode</button> 
              <br/>
                      
            </form>
          </div>

          <div id="BlockConfirmation" style="display: none;">      

            <h4>MASUKKAN KODE KONFIRMASI</h4>            
            <form name="FormCodeConfirmation" id="FormCodeConfirmation">
              <div class="form-group form-material floating">
                <input type="text" id="Key" name="Key" class="form-control" title="Kode"/>
                <label class="floating-label">Masukkan Kode</label>
              </div>
              <input type="hidden" id="Email" name="Email"/>
              <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
              <button type="submit" class="btn btn-info btn-block btn-lg margin-top-40">Konfirmasi</button> 
              <br/>
                      
            </form>
          </div>

          <div id="BlockSetNewPassword" style="display: none;">         
            <h4>SET PASSWORD BARU</h4>            
            <form name="FormSetNewPassword" id="FormSetNewPassword">
              <div class="form-group form-material floating">
                <input type="password" id="NewPassword" name="NewPassword" class="form-control" title="Password baru"/>
                <label class="floating-label">Password Baru</label>
              </div>
              <div class="form-group form-material floating">
                <input type="password" id="NewPasswordAgain" name="NewPasswordAgain" class="form-control" title="Password baru (ulangi)"/>
                <label class="floating-label">Password Baru Lagi</label>
              </div>
              
              <input type="hidden" id="Key" name="Key"/>
              <input type="hidden" id="Email" name="Email"/>
              <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
              
              <button type="submit" class="btn btn-warning btn-block btn-lg margin-top-40">Simpan</button> 
              <br/>
                      
            </form>
          </div>



            <p class="text-right">
              Webpanel <a href="<?=base_url();?>backend">Login</a>
            </p>
            <p class="text-right">
              Kembali ke <a href="<?=base_url();?>">Halaman Depan</a>
            </p>
          
          <br/>
         
         
         
        </div>
      </div>
      <footer class="page-copyright page-copyright-inverse">
        <p><a href="<?=base_url();?>"><?=$this->app_info_model->AppName();?></a></p>
        <p>Copyright &copy; <?=$this->app_info_model->AppYear();?> <?=$this->app_info_model->AppVersion();?>. All RIGHT RESERVED.</p>
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
  <!-- Core  -->
  <script src="<?=base_url();?>assets/backend/vendor/jquery/jquery.js"></script>
  <script src="<?=base_url();?>assets/backend/vendor/bootstrap/bootstrap.js"></script>
  <script src="<?=base_url();?>assets/backend/vendor/animsition/jquery.animsition.js"></script>
  <script src="<?=base_url();?>assets/backend/vendor/asscroll/jquery-asScroll.js"></script>
  <script src="<?=base_url();?>assets/backend/vendor/mousewheel/jquery.mousewheel.js"></script>
  <script src="<?=base_url();?>assets/backend/vendor/asscrollable/jquery.asScrollable.all.js"></script>
  <script src="<?=base_url();?>assets/backend/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
  <!-- Plugins -->
  <script src="<?=base_url();?>assets/backend/vendor/switchery/switchery.min.js"></script>
  <script src="<?=base_url();?>assets/backend/vendor/intro-js/intro.js"></script>
  <script src="<?=base_url();?>assets/backend/vendor/screenfull/screenfull.js"></script>
  <script src="<?=base_url();?>assets/backend/vendor/slidepanel/jquery-slidePanel.js"></script>
  <script src="<?=base_url();?>assets/backend/vendor/jquery-placeholder/jquery.placeholder.js"></script>
  <!-- Scripts -->
  <script src="<?=base_url();?>assets/backend/js/core.js"></script>
  <script src="<?=base_url();?>assets/backend/js/site.js"></script>
  <script src="<?=base_url();?>assets/backend/js/sections/menu.js"></script>
  <script src="<?=base_url();?>assets/backend/js/sections/menubar.js"></script>
  <script src="<?=base_url();?>assets/backend/js/sections/gridmenu.js"></script>
  <script src="<?=base_url();?>assets/backend/js/sections/sidebar.js"></script>
  <script src="<?=base_url();?>assets/backend/js/configs/config-colors.js"></script>
  <script src="<?=base_url();?>assets/backend/js/configs/config-tour.js"></script>
  <script src="<?=base_url();?>assets/backend/js/components/asscrollable.js"></script>
  <script src="<?=base_url();?>assets/backend/js/components/animsition.js"></script>
  <script src="<?=base_url();?>assets/backend/js/components/slidepanel.js"></script>
  <script src="<?=base_url();?>assets/backend/js/components/switchery.js"></script>
  <script src="<?=base_url();?>assets/backend/js/components/jquery-placeholder.js"></script>
  <script src="<?=base_url();?>assets/backend/js/components/material.js"></script>
	<script type="text/javascript" src="<?=base_url();?>assets/backend/js/plugins/login/EasePack.min.js"></script>
  <script type="text/javascript" src="<?=base_url();?>assets/backend/js/plugins/login/TweenLite.min.js"></script>
  <script type="text/javascript" src="<?=base_url();?>assets/backend/js/plugins/login/animated.js"></script>
  
  <script src="<?=base_url();?>assets/backend/js/plugins/jquery-validation/js/jquery.validate.min.js"></script>
  <script src="<?=base_url();?>assets/backend/js/plugins/jquery-validation/js/additional-methods.min.js"></script>
  <script src="<?=base_url();?>assets/backend/vendor/bootbox/bootbox.js"></script>
  <script type="text/javascript" src="<?=base_url();?>assets/backend/js/plugins/growl/jquery.growl.js"></script>
  <script src="<?=base_url();?>assets/backend/js/custom.js"></script>

  

  <script>
	$(function(){
			"use strict";
			CanvasBG.init({
				Loc : {
					x : window.innerWidth / 2,
					y : window.innerHeight / 3.3
				},
			});			
	});
	</script>
  <script>
  (function(document, window, $) {
    'use strict';
    var Site = window.Site;
    $(document).ready(function() {
      Site.run();
    });
  })(document, window, jQuery);
  </script>

  <script>
    $(function(){
      //------------------------------------------------------------------------------------//
      $("#FormResetPassword").validate({     
        rules: {
          Email: {
            required: true,
            email: true  
          }
        },
        messages: {
          Email: {
            required: 'Harus diisi',
            email: 'Format harus benar'
          }
        }     
      });
      $("#FormResetPassword").submit(function(e){
        e.preventDefault();
        if($("#FormResetPassword").valid()){       
          //////////////////////
          bootbox.dialog({
            message: "Apakah anda yakin akan mereset akun ini?",
            title: "Konfirmasi",
            buttons: {        
              danger: {
                label: "Tidak",
                className: "btn-default",
                callback: function(){
                  
                }
              },
              main: {
                label: "Ya",
                className: "btn-primary",
                callback: function() {
                    var form = $("#FormResetPassword").serialize();
                    $.ajax({
                      url: '<?=base_url();?>backend/reset_password/RequestKey',
                      type: 'POST',
                      dataType: 'json',
                      data:form,
                      success: function(respon){
                        if(respon.status=='sukses'){                                      
                          $.growl({title:respon.status, message: respon.message});   
                          $("#FormCodeConfirmation").find("#Email").val(respon.email);                       
                          $("#BlockResetPassword").hide();
                          $("#BlockConfirmation").show();
                          $("#FormCodeConfirmation").find("#Key").focus();
                        }  

                        if(respon.status=='gagal'){                                      
                          $.growl.warning({title:respon.status, message: respon.message});                          
                          
                        }                      
                      },
                      timeout: 20000, function(){
                        $.growl.error({title: 'Timeout', message: 'Request timeout'});
                      },
                      error: function(){
                        myLoader.hide();
                        $.growl.error({title: 'Error', message: 'Ajax request'});
                      }
                    });               
                }
              }
            }       
          });             
        }       
      }); 
    });
  </script>

  <script>
    $(function(){
      //------------------------------------------------------------------------------------//
      $("#FormCodeConfirmation").validate({     
        rules: {
          Key: {
            required: true
          }
        },
        messages: {
          Key: {
            required: 'Harus diisi',
          }
        }     
      });
      $("#FormCodeConfirmation").submit(function(e){
        e.preventDefault();
        if($("#FormCodeConfirmation").valid()){       
          //////////////////////
          bootbox.dialog({
            message: "Apakah anda yakin akan mengirimkan kode konfirmasi ini?",
            title: "Konfirmasi",
            buttons: {        
              danger: {
                label: "Tidak",
                className: "btn-default",
                callback: function(){
                  
                }
              },
              main: {
                label: "Ya",
                className: "btn-primary",
                callback: function() {
                    var form = $("#FormCodeConfirmation").serialize();
                    $.ajax({
                      url: '<?=base_url();?>backend/reset_password/SendCodeConfirmation',
                      type: 'POST',
                      dataType: 'json',
                      data:form,
                      success: function(respon){
                        if(respon.status=='sukses'){                                      
                          $.growl({title:respon.status, message: respon.message});   
                          $("#FormSetNewPassword").find("#Key").val(respon.Key);                       
                          $("#FormSetNewPassword").find("#Email").val(respon.Email);
                          $("#BlockResetPassword").hide();
                          $("#BlockConfirmation").hide();
                          $("#BlockSetNewPassword").show();
                          $("#FormSetNewPassword").find("#NewPassword").focus();
                        }  

                        if(respon.status=='gagal'){                                      
                          $.growl.warning({title:respon.status, message: respon.message}); 
                        }                       
                      },
                      timeout: 20000, function(){
                        $.growl.error({title: 'Timeout', message: 'Request timeout'});
                      },
                      error: function(){
                        myLoader.hide();
                        $.growl.error({title: 'Error', message: 'Ajax request'});
                      }
                    });               
                }
              }
            }       
          });             
        }       
      }); 
    });
  </script>

  <script>
    $(function(){
      //------------------------------------------------------------------------------------//
      $("#FormSetNewPassword").validate({     
        rules: {
          NewPassword: {
            required: true

          },
          NewPasswordAgain: {
            required: true,
            equalTo: '#NewPassword'
          }
        },
        messages: {
          NewPassword: {
            required: 'Harus diisi'            
          },
          NewPasswordAgain: {
            required: 'Harus diisi',
            equalTo: 'Harus sama'
          }
        }     
      });
      $("#FormSetNewPassword").submit(function(e){
        e.preventDefault();
        if($("#FormSetNewPassword").valid()){       
          //////////////////////
          bootbox.dialog({
            message: "Apakah anda yakin akan menyimpan password baru ini?",
            title: "Konfirmasi",
            buttons: {        
              danger: {
                label: "Tidak",
                className: "btn-default",
                callback: function(){
                  
                }
              },
              main: {
                label: "Ya",
                className: "btn-primary",
                callback: function() {
                    var form = $("#FormSetNewPassword").serialize();
                    $.ajax({
                      url: '<?=base_url();?>backend/reset_password/SetNewPassword',
                      type: 'POST',
                      dataType: 'json',
                      data:form,
                      success: function(respon){
                        if(respon.status=='sukses'){                                      
                          $.growl({title:respon.status, message: respon.message});   
                          setTimeout(function(){ window.location='<?=base_url();?>backend'}, 1000);                      
                        }  

                        if(respon.status=='gagal'){                                      
                          $.growl.warning({title:respon.status, message: respon.message}); 
                        }                       
                      },
                      timeout: 20000, function(){
                        $.growl.error({title: 'Timeout', message: 'Request timeout'});
                      },
                      error: function(){
                        myLoader.hide();
                        $.growl.error({title: 'Error', message: 'Ajax request'});
                      }
                    });               
                }
              }
            }       
          });             
        }       
      }); 
    });
  </script>


</body>
</html>


<!--<?=$this->secure_model->InsertSystemLog('SystemLog','Halaman login','akses');?>-->