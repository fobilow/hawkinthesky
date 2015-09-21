<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="description" content="HawkInTheSky - Google Analytics Dashboard">
  <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="assets/css/jquery.bxslider.css"/>
  <link rel="stylesheet" href="assets/css/<?= $theme; ?>.css"/>
</head>
<body>
<div class="infobar">
  <?php if(isset($statsRows)): ?>
    <div class="pull-left"><a href="/configure.php">Configure</a></div>
  <?php endif; ?>
  <div class="pull-right"><?= date('d M Y H:i A') ?></div>
  <div class="clearfix"></div>
</div>
<div class="container-fluid">
  <?php if(isset($statsRows)): ?>
    <div class="row">
      <?php foreach($statsRows as $stats): ?>
        <div class="<?= $colStyles; ?> stats-panel ">
          <?php if($stats != null): $metrics = current($stats); ?>
            <div class="<?= $metrics['divClass']; ?>">
            <h2 class="text-primary"><?= key($stats) ?></h2>
              <ul class="bxslider">
                  <li>
                   <div class="screen1" style="padding:10px;">
                    <p class="stats-heading">
                      <span class="stats-sessions">--</span>
                      <br/><span class="stats-details"><?= Hawk::metricsName('ga:sessions') ?></span>
                    </p>

                    <p class="stats-heading">
                      <span class="stats-pageviews">--</span>
                      <br/><span class="stats-details"><?= Hawk::metricsName('ga:pageviews') ?></span>
                    </p>

                    <p class="stats-heading">
                      <span class="stats-bouncerate">--</span>
                      <br/><span class="stats-details"><?= Hawk::metricsName('ga:bounceRate') ?></span>
                    </p>

                    <p class="stats-heading">
                      <span class="stats-avgpageloadtime">--</span>
                      <br/><span class="stats-details"><?= Hawk::metricsName('ga:avgPageLoadTime') ?></span>
                    </p>
                   </div>
                  </li>
                  <li>
                    <div class="screen2" style="padding:10px;">
                      <p class="stats-heading">
                        <span class="stats-activeusers">--</span>
                        <br/><span class="stats-details"><?= Hawk::metricsName('rt:activeUsers') ?></span>
                      </p>
                      <p class="stats-heading">
                        <span class="stats-uniquepageviews">--</span>
                        <br/><span class="stats-details"><?= Hawk::metricsName('ga:uniquePageviews') ?></span>
                      </p>
                      <p class="stats-heading">
                        <span class="stats-users">--</span>
                        <br/><span class="stats-details"><?= Hawk::metricsName('ga:users') ?></span>
                      </p>
                      <p class="stats-heading">
                        <span class="stats-newusers">--</span>
                        <br/><span class="stats-details"><?= Hawk::metricsName('ga:newUsers') ?></span>
                      </p>

                    </div>
                  </li>
              </ul>
            </div>
          <?php endif ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if(isset($authUrl)): ?>
    <div class="text-center">
      <h1 class="page-header">Hawk In The Sky </h1>
      <p class="text-muted" style="font-size:20px;">Google Analytics Dashboard</p>
      <p style="font-size:14px;">Login with the google account that has access to your analytics</p>
      <a class='btn btn-success btn-lg' href="<?= $authUrl ?>">Login with Google To Begin!</a>
    </div>
  <?php endif; ?>
  <?php if($errors): ?>
    <div class="text-center">
      <h1 class="page-header">Hawk In The Sky </h1>
      <p class="text-muted" style="font-size:20px;">Google Analytics Dashboard</p>
      <p style="font-size:14px;">I encountered some errors while trying to connect to your analytics account</p>
      <ul style="font-size:12px; color:red;">
        <?php foreach($errors as $error): ?>
          <li><?= $error ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>


  <div class="push"></div>
</div>
<div class="footer text-center">
  &copy; Hawk In The Sky
</div>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script src="assets/js/jquery.bxslider.js"></script>
<script>
  function getStats()
  {
    $.get('/get-stats.php?view=<?= $view ?>', function(data){
      $.each(data, function(key, stats){
        $('.'+stats.divClass+' .stats-sessions').text(stats['ga:sessions']);
        $('.'+stats.divClass+' .stats-pageviews').text(stats['ga:pageviews']);
        $('.'+stats.divClass+' .stats-bouncerate').text(stats['ga:bounceRate']);
        $('.'+stats.divClass+' .stats-avgpageloadtime').text(stats['ga:avgPageLoadTime']);
        $('.'+stats.divClass+' .stats-activeusers').text(stats['rt:activeUsers']);
        $('.'+stats.divClass+' .stats-uniquepageviews').text(stats['ga:uniquePageviews']);
        $('.'+stats.divClass+' .stats-users').text(stats['ga:users']);
        $('.'+stats.divClass+' .stats-newusers').text(stats['ga:newUsers']);
      });
    });
  }

  getStats();
  setInterval(getStats, 60000);

  $(document).ready(function(){
    $('.bxslider').bxSlider({speed: 1000, controls: false, auto: true, pause: 10000});
  });
</script>
