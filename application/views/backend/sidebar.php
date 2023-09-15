<div class="site-menubar">
  <div class="site-menubar-body">
    <div>
      <div>
        <ul class="site-menu">
          <li class="site-menu-category">Menu</li>
          <li class="site-menu-item <?php if (isset($dashboardmenu)) {
            echo $dashboardmenu;
          }
          ; ?>">
            <a href="<?= base_url(); ?>backend/dashboard" data-slug="dashboard">
              <i class="site-menu-icon wb-desktop" aria-hidden="true"></i>
              <span class="site-menu-title">DASBOR</span>
            </a>
          </li>
          <?php
          $ulevel = $this->user_model->GetLevelUser();
          if ($ulevel == 'SKPD') {
            ?>
            <li class="site-menu-item <?php if (isset($dashboardmenutambah)) {
              echo $dashboardmenutambah;
            }
            ; ?>">
              <a href="<?= base_url(); ?>backend/dashboard/add" data-slug="Tambah Pelaporan">
                <i class="site-menu-icon wb-desktop" aria-hidden="true"></i>
                <span class="site-menu-title">TAMBAH PELAPORAN</span>
              </a>
            </li>
          <?php } ?>
          <?php
          $ulevel = $this->user_model->GetLevelUser();
          if ($ulevel == 'superadmin') {
            ?>
            <li class="site-menu-item open has-sub <?php if (isset($skpd_menu)) {
              echo $skpd_menu;
            }
            ; ?>">
              <a href="javascript:void(0)" data-slug="layout">
                <i class="site-menu-icon wb-home" aria-hidden="true"></i>
                <span class="site-menu-title">SKPD</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item <?php if (isset($skpd_submenu)) {
                  echo $skpd_submenu;
                }
                ; ?>">
                  <a class="animsition-link" href="<?= base_url(); ?>backend/skpd" data-slug="layout-menu-collapsed">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Kelola Satuan Kerja</span>
                  </a>
                </li>
              </ul>
              <?php
          } else {
            $this->load->view('backend/no-blank');
          }
          ?>
            <?php
            $ulevel = $this->user_model->GetLevelUser();
            if ($ulevel == 'superadmin') {
              ?>
            <li class="site-menu-item open has-sub <?php if (isset($irban_menu)) {
              echo $irban_menu;
            }
            ; ?>">
              <a href="javascript:void(0)" data-slug="layout">
                <i class="site-menu-icon wb-star" aria-hidden="true"></i>
                <span class="site-menu-title">IRBAN</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item <?php if (isset($irban_submenu)) {
                  echo $irban_submenu;
                }
                ; ?>">
                  <a class="animsition-link" href="<?= base_url(); ?>backend/irban" data-slug="layout-menu-collapsed">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Kelola IRBAN</span>
                  </a>
                </li>
              </ul>
            <?php } ?>
            <?php
            $ulevel = $this->user_model->GetLevelUser();
            if ($ulevel == 'superadmin') {
              ?>
            <li class="site-menu-item open has-sub <?php if (isset($pesanmenu)) {
              echo $pesanmenu;
            }
            ; ?>">
              <a href="javascript:void(0)" data-slug="layout">
                <i class="site-menu-icon wb-bookmark" aria-hidden="true"></i>
                <span class="site-menu-title">PELAPORAN</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">

                <li class="site-menu-item <?php if (isset($pesansubmenu)) {
                  echo $pesansubmenu;
                }
                ; ?>">
                  <a class="animsition-link" href="<?= base_url(); ?>backend/pesan" data-slug="layout-menu-collapsed">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Pelaporan Masuk</span>
                  </a>
                </li>

                <li class="site-menu-item <?php if (isset($categorysubmenu)) {
                  echo $categorysubmenu;
                }
                ; ?>">
                  <a class="animsition-link" href="<?= base_url(); ?>backend/category" data-slug="layout-menu-collapsed">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Kategori Pelaporan</span>
                  </a>
                </li>

                <li class="site-menu-item <?php if (isset($filemanagersubmenu)) {
                  echo $filemanagersubmenu;
                }
                ; ?>">
                  <a class="animsition-link" href="<?= base_url(); ?>backend/file_manager"
                    data-slug="layout-menu-collapsed">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">File Pelaporan</span>
                  </a>
                </li>
              </ul>
            </li>
            <?php
            } else {
              $this->load->view('backend/no-blank');
            }
            ?>
          <?php
          $ulevel = $this->user_model->GetLevelUser();
          if ($ulevel == 'superadmin') {
            ?>
            <li class="site-menu-item open has-sub <?php if (isset($settingsmenu)) {
              echo $settingsmenu;
            }
            ; ?>">
              <a href="javascript:void(0)" data-slug="layout">
                <i class="site-menu-icon wb-settings" aria-hidden="true"></i>
                <span class="site-menu-title">PENGATURAN</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">

                <li class="site-menu-item has-sub <?php if (isset($settingsbackendmenu)) {
                  echo $settingsbackendmenu;
                }
                ; ?> <?php if (isset($settingsbackendmenuopen)) {
                    echo $settingsbackendmenuopen;
                  }
                  ; ?>">
                  <a href="javascript:void(0)" data-slug="forms-editor">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Backend</span>
                    <span class="site-menu-arrow"></span>
                  </a>
                  <ul class="site-menu-sub">
                    <li class="site-menu-item <?php if (isset($settingsgeneralsubmenu)) {
                      echo $settingsgeneralsubmenu;
                    }
                    ; ?> ">
                      <a class="animsition-link" href="<?= base_url(); ?>backend/settings_general"
                        data-slug="layout-menu-collapsed">
                        <i class="site-menu-icon " aria-hidden="true"></i>
                        <span class="site-menu-title">Pengaturan Umum</span>
                      </a>
                    </li>
                    <li class="site-menu-item <?php if (isset($usersubmenu)) {
                      echo $usersubmenu;
                    }
                    ; ?> ">
                      <a class="animsition-link" href="<?= base_url(); ?>backend/user" data-slug="layout-menu-collapsed">
                        <i class="site-menu-icon " aria-hidden="true"></i>
                        <span class="site-menu-title">Pengguna</span>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <?php
          } else {
            $this->load->view('backend/no-blank');
          }
          ?>
          <?php
          $ulevel = $this->user_model->GetLevelUser();
          if ($ulevel == 'superadmin') {
            ?>
            <li class="site-menu-item open has-sub <?php if (isset($logsmenu)) {
              echo $logsmenu;
            }
            ; ?>">
              <a href="javascript:void(0)" data-slug="layout">
                <i class="site-menu-icon wb-alert-circle" aria-hidden="true"></i>
                <span class="site-menu-title">LOGS</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item <?php if (isset($logsvisitorsubmenu)) {
                  echo $logsvisitorsubmenu;
                }
                ; ?>">
                  <a class="animsition-link" href="<?= base_url(); ?>backend/logs_visitor"
                    data-slug="layout-menu-collapsed">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Pengunjung</span>
                  </a>
                </li>
                <li class="site-menu-item <?php if (isset($logsusersubmenu)) {
                  echo $logsusersubmenu;
                }
                ; ?>">
                  <a class="animsition-link" href="<?= base_url(); ?>backend/logs_user" data-slug="layout-menu-collapsed">
                    <i class="site-menu-icon " aria-hidden="true"></i>
                    <span class="site-menu-title">Pengguna</span>
                  </a>
                </li>
              </ul>
            </li>
            <?php
          } else {
            $this->load->view('backend/no-blank');
          }
          ?>
          <li class="site-menu-item open has-sub <?php if (isset($helpmenu)) {
            echo $helpmenu;
          }
          ; ?>">
            <a href="javascript:void(0)" data-slug="layout">
              <i class="site-menu-icon wb-help-circle" aria-hidden="true"></i>
              <span class="site-menu-title">BANTUAN</span>
              <span class="site-menu-arrow"></span>
            </a>
            <ul class="site-menu-sub">
              <li class="site-menu-item <?php if (isset($helpaboutsubmenu)) {
                echo $helpaboutsubmenu;
              }
              ; ?>">
                <a class="animsition-link" href="<?= base_url(); ?>backend/help/about"
                  data-slug="layout-menu-collapsed">
                  <i class="site-menu-icon " aria-hidden="true"></i>
                  <span class="site-menu-title">Tentang</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="site-menubar-footer">
    <a href="<?= base_url(); ?>backend/user_profile" class="fold-show active" data-placement="top" data-toggle="tooltip"
      data-original-title="Pengaturan">
      <span class="icon wb-settings" aria-hidden="true"></span>
    </a>
    <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Lock">
      <span class="icon wb-eye-close" aria-hidden="true"></span>
    </a>
    <a href="<?= base_url(); ?>backend/logout" data-placement="top" data-toggle="tooltip" data-original-title="Logout">
      <span class="icon wb-power" aria-hidden="true"></span>
    </a>
  </div>
</div>