<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php echo $application->getName() ?></title>
  <meta charset="utf-8"/>
  <?php Ld_Ui::headerCss() ?>
  <script type="text/javascript" src="<?php echo Ld_Ui::getJsUrl('/jquery/jquery.js', 'js-jquery') ?>"></script>
<?php if (defined('LD_COMPRESS_JS') && constant('LD_COMPRESS_JS')) : ?>
  <script type="text/javascript" src="<?php echo Ld_Ui::getJsUrl('/ld/ld.c.js', 'lib-admin') ?>"></script>
<?php else : ?>
  <script type="text/javascript" src="<?php echo Ld_Ui::getJsUrl('/ld/ld.js', 'lib-admin') ?>"></script>
<?php endif ?>
</head>
<body class="bootstrap">

    <?php Ld_Ui::topBar(); ?>

    <div class="container">

        <?php Ld_Ui::topNav(); ?>

        <div class="page-header">
          <h1>
            <a href="<?php echo $application->getUrl() ?>"><?php echo $application->getName() ?></a>
            <!--
            <small>Supporting text or tagline</small>
            -->
          </h1>
        </div>

        <?php echo $content ?>

        <footer class="footer">
          <div class="container">
            <p>
            Powered by <strong><?php echo $application->getPackage()->getName() ?></strong>
            with the help of <a href="http://www.limonade-php.net/">Limonade</a>
            via <a href="http://ladistribution.net/">La Distribution</a>
            </p>
          </div>
        </footer>

    </div>

</body>
</html>