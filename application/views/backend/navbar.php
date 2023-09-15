<nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle hamburger hamburger-close navbar-toggle-left hided"
      data-toggle="menubar">
      <span class="sr-only">Toggle navigation</span>
      <span class="hamburger-bar"></span>
    </button>
    <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-collapse" data-toggle="collapse">
      <i class="icon wb-more-horizontal" aria-hidden="true"></i>
    </button>
    <div class="navbar-brand site-gridmenu-toggle" data-toggle="gridmenu">
      <img class="navbar-brand-logo" src="<?= base_url(); ?>assets/backend/images/logo-mrk.png" width="32" height="32">
      <span class="navbar-brand-text">
        <?= $this->app_info_model->AppDashboardName(); ?>
      </span>
    </div>

  </div>
  <div class="navbar-container container-fluid">
    <!-- Navbar Collapse -->
    <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
      <!-- Navbar Toolbar -->
      <ul class="nav navbar-toolbar">
        <li class="hidden-float" id="toggleMenubar">
          <a data-toggle="menubar" href="#" role="button">
            <i class="icon hamburger hamburger-arrow-left">
              <span class="sr-only">Toggle menubar</span>
              <span class="hamburger-bar"></span>
            </i>
          </a>
        </li>
        <li class="hidden-xs" id="toggleFullscreen">
          <a class="icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
            <span class="sr-only">Toggle fullscreen</span>
          </a>
        </li>
        <li class="hidden-xs">
          <a class="icon wb-globe" href="<?= base_url(); ?>" role="button" target="_blank">
            <span class="sr-only"></span>
          </a>
        </li>
      </ul>
      <!-- End Navbar Toolbar -->
      <!-- Navbar Toolbar Right -->
      <?php
      $levelUser = $this->user_model->GetLevelUser();

      if ($levelUser == 'moderator') {
        $levelUserModified = 'IRBAN';
      } elseif ($levelUser == 'superadmin') {
        $levelUserModified = 'ADMINISTRATOR';
      } else {
        $levelUserModified = str_replace("contributor", "SKPD", $levelUser);
      }
      ?>
      <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
        <li><a href="javascript:;">
            <?= $this->user_model->GetNameUser(); ?> | <i>
              <?= $levelUserModified ?>
            </i>
          </a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)" data-animation="scale-up"
            aria-expanded="false" role="button">
            <span class="flag-icon flag-icon-id"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li role="presentation">
              <a href="javascript:void(0)" role="menuitem">
                <span class="flag-icon flag-icon-id"></span> Indonesian</a>
            </li>
            <li role="presentation">
              <a href="javascript:void(0)" role="menuitem">
                <span class="flag-icon flag-icon-us"></span> English</a>
            </li>

          </ul>
        </li>
        <!--
          <li class="dropdown">
            <a data-toggle="dropdown" href="javascript:void(0)" title="Notifications" aria-expanded="false"
            data-animation="scale-up" role="button">
              <i class="icon wb-bell" aria-hidden="true"></i>
              <span class="badge badge-danger up">5</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
              <li class="dropdown-menu-header" role="presentation">
                <h5>NOTIFICATIONS</h5>
                <span class="label label-round label-danger">New 5</span>
              </li>
              <li class="list-group" role="presentation">
                <div data-role="container">
                  <div data-role="content">
                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <i class="icon wb-order bg-red-600 white icon-circle" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">A new order has been placed</h6>
                          <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">5 hours ago</time>
                        </div>
                      </div>
                    </a>
                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <i class="icon wb-user bg-green-600 white icon-circle" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">Completed the task</h6>
                          <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">2 days ago</time>
                        </div>
                      </div>
                    </a>
                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <i class="icon wb-settings bg-red-600 white icon-circle" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">Settings updated</h6>
                          <time class="media-meta" datetime="2015-06-11T14:05:00+08:00">2 days ago</time>
                        </div>
                      </div>
                    </a>
                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <i class="icon wb-calendar bg-blue-600 white icon-circle" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">Event started</h6>
                          <time class="media-meta" datetime="2015-06-10T13:50:18+08:00">3 days ago</time>
                        </div>
                      </div>
                    </a>
                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <i class="icon wb-chat bg-orange-600 white icon-circle" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">Message received</h6>
                          <time class="media-meta" datetime="2015-06-10T12:34:48+08:00">3 days ago</time>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </li>
              <li class="dropdown-menu-footer" role="presentation">
                <a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">
                  <i class="icon wb-settings" aria-hidden="true"></i>
                </a>
                <a href="javascript:void(0)" role="menuitem">
                    All notifications
                  </a>
              </li>
            </ul>
          </li>
          <li class="dropdown">
            <a data-toggle="dropdown" href="javascript:void(0)" title="Messages" aria-expanded="false"
            data-animation="scale-up" role="button">
              <i class="icon wb-envelope" aria-hidden="true"></i>
              <span class="badge badge-info up">3</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
              <li class="dropdown-menu-header" role="presentation">
                <h5>MESSAGES</h5>
                <span class="label label-round label-info">New 3</span>
              </li>
              <li class="list-group" role="presentation">
                <div data-role="container">
                  <div data-role="content">
                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-online">
                            <img src="<?= base_url(); ?>assets/backend/portraits/2.jpg" alt="..." />
                            <i></i>
                          </span>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">Mary Adams</h6>
                          <div class="media-meta">
                            <time datetime="2015-06-17T20:22:05+08:00">30 minutes ago</time>
                          </div>
                          <div class="media-detail">Anyways, i would like just do it</div>
                        </div>
                      </div>
                    </a>
                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-off">
                            <img src="<?= base_url(); ?>assets/backend/portraits/3.jpg" alt="..." />
                            <i></i>
                          </span>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">Caleb Richards</h6>
                          <div class="media-meta">
                            <time datetime="2015-06-17T12:30:30+08:00">12 hours ago</time>
                          </div>
                          <div class="media-detail">I checheck the document. But there seems</div>
                        </div>
                      </div>
                    </a>
                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-busy">
                            <img src="<?= base_url(); ?>assets/backend/portraits/4.jpg" alt="..." />
                            <i></i>
                          </span>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">June Lane</h6>
                          <div class="media-meta">
                            <time datetime="2015-06-16T18:38:40+08:00">2 days ago</time>
                          </div>
                          <div class="media-detail">Lorem ipsum Id consectetur et minim</div>
                        </div>
                      </div>
                    </a>
                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-away">
                            <img src="<?= base_url(); ?>assets/backend/portraits/5.jpg" alt="..." />
                            <i></i>
                          </span>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">Edward Fletcher</h6>
                          <div class="media-meta">
                            <time datetime="2015-06-15T20:34:48+08:00">3 days ago</time>
                          </div>
                          <div class="media-detail">Dolor et irure cupidatat commodo nostrud nostrud.</div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </li>
              <li class="dropdown-menu-footer" role="presentation">
                <a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">
                  <i class="icon wb-settings" aria-hidden="true"></i>
                </a>
                <a href="javascript:void(0)" role="menuitem">
                    See all messages
                  </a>
              </li>
            </ul>
          </li>
          -->
        <li class="dropdown">
          <a class="navbar-avatar dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"
            data-animation="scale-up" role="button">
            <span class="avatar avatar-online">
              <?php
              if ($this->user_model->GetPictureUser() !== null) {
                ?>
                <img src="<?php echo base_url() . $this->user_model->GetPictureUser(); ?>" alt="..."
                  id="picture-user-navbar">
                <?php
              } else {
                ?>
                <img src="<?= base_url(); ?>assets/backend/portraits/1.jpg" alt="..." id="picture-user-navbar">
                <?php
              }
              ?>
              <i></i>
            </span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li role="presentation">
              <a href="<?= base_url(); ?>backend/user_profile" role="menuitem"><i class="icon wb-user-circle"
                  aria-hidden="true"></i> Profil </a>
            </li>
            <li role="presentation">
              <a href="<?= base_url(); ?>backend/logout" role="menuitem"><i class="icon wb-power"
                  aria-hidden="true"></i> Logout</a>
            </li>
          </ul>
        </li>
      </ul>
      <!-- End Navbar Toolbar Right -->
    </div>
    <!-- End Navbar Collapse -->

  </div>
</nav>