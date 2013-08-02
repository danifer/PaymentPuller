<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <title>
      <?php if (!include_slot('title')): ?>
        <?php echo sfConfig::get('app_site_title') ?>
      <?php endif; ?>
    </title>
    <link rel="shortcut icon" href="/favicon.ico" />

    <?php use_stylesheet('../bootstrap/css/bootstrap.min.css') ?>
    <?php use_stylesheet('../bootstrap/css/bootstrap-responsive.min.css') ?>
    <?php use_stylesheet('main.css') ?>
    <?php include_stylesheets() ?>

    <?php use_javascript('../bootstrap/js/bootstrap.min.js') ?>
    <?php use_javascript('../bootstrap/js/jquery.js') ?>
    <?php use_javascript('../bootstrap/js/bootstrap-transition.js') ?>
    <?php use_javascript('../bootstrap/js/bootstrap-alert.js') ?>
    <?php use_javascript('../bootstrap/js/bootstrap-modal.js') ?>
    <?php use_javascript('../bootstrap/js/bootstrap-dropdown.js') ?>
    <?php use_javascript('../bootstrap/js/bootstrap-scrollspy.js') ?>
    <?php use_javascript('../bootstrap/js/bootstrap-tab.js') ?>
    <?php use_javascript('../bootstrap/js/bootstrap-tooltip.js') ?>
    <?php use_javascript('../bootstrap/js/bootstrap-popover.js') ?>
    <?php use_javascript('../bootstrap/js/bootstrap-button.js') ?>
    <?php use_javascript('../bootstrap/js/bootstrap-collapse.js') ?>
    <?php use_javascript('../bootstrap/js/bootstrap-carousel.js') ?>
    <?php use_javascript('../bootstrap/js/bootstrap-typeahead.js') ?>
    <?php include_javascripts() ?>

    <style type="text/css">
      /*body {
        padding-top: 60px;
        padding-bottom: 40px;
      }*/
    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>

  <body>
    <div class="container main">
      <div class="content">
        <div class="navbar navbar-inverse">
          <div class="navbar-inner">
            <div class="container">
              <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>

              <div class="nav-collapse collapse">
                <ul class="nav pull-right header">
                  <li><?php echo link_to('Gross Revenue', 'report/monthly') ?></li>
                  <li><?php echo link_to('home', '@homepage') ?></li>
                </ul>
              </div><!--/.nav-collapse -->
            </div>
          </div>
        </div>

        <?php if ($sf_user->hasFlash('info')): ?>
        <div class="alert alert-info">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <?php echo $sf_user->getFlash('info') ?>
        </div>
        <?php endif; ?>

        <?php if ($sf_user->hasFlash('notice')): ?>
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <?php echo $sf_user->getFlash('notice') ?>
        </div>
        <?php endif; ?>
        
        <?php if ($sf_user->hasFlash('error')): ?>
        <div class="alert alert-error">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <?php echo $sf_user->getFlash('error') ?>
        </div>
        <?php endif; ?>

        <h1 class="title"><?php include_slot('title') ?></h1>
        <?php echo $sf_content ?>
        
      </div>
      <hr />
      <footer>
        <div class="row">
          <div class="span4">
            <p>
              Copyright &copy; <?php echo date('Y') ?> <?php echo sfConfig::get('app_site_title') ?>
            </p>
          </div>
          <div class="span4">
            <ul class="nav inline">
              <li><?php /*echo link_to('home', '@homepage')*/ ?></li>
            </ul>
          </div>
        </div>
      </footer>
    </div> <!-- /container -->

    <!-- Modal -->
    <div id="modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="modalLabel">&nbsp;</h3>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      </div>
    </div>
  </body>
</html>
