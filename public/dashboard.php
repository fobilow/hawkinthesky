<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="description" content="HawkInTheSky - Google Analytics Dashboard">
  <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta http-equiv="refresh" content="60">
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="/assets/css/theme.css"/>
</head>
<body>
<div class="infobar"><?= date('d M Y H:i A') ?></div>
<div class="container-fluid">
  <?php if(isset($statsRows)): ?>
  <?php foreach($statsRows as $row): ?>
  <div class="row">
      <?php foreach($row as $stats): ?>
      <div class="col-lg-3 col-md-3" style="border:1px solid #ddd;">
        <?php if($stats != null): $metrics = current($stats); ?>
          <h2 class="text-primary"><?= key($stats) ?></h2>
          <hr>
          
          <p class="stats-heading"><?= $metrics['ga:sessions']; ?>
            <br/><span class="stats-details"><?= Hawk::metricsName('ga:sessions') ?></span>
          </p>

          <p class="stats-heading"><?= $metrics['ga:pageviews']; ?>
            <br/><span class="stats-details"><?= Hawk::metricsName('ga:pageviews') ?></span>
          </p>

          <p class="stats-heading"><?= number_format($metrics['ga:bounceRate'],2 ); ?>%
            <br/><span class="stats-details"><?= Hawk::metricsName('ga:bounceRate') ?></span>
          </p>

          <p class="stats-heading"><?= number_format($metrics['ga:avgPageLoadTime'], 2); ?>s
            <br/><span class="stats-details"><?= Hawk::metricsName('ga:avgPageLoadTime') ?></span>
          </p>

        <?php endif ?>
      </div>
      <?php endforeach; ?>
  </div>
  <?php endforeach; ?>
  <?php endif; ?>

  <?php if(isset($authUrl)): ?>
    <div class="text-center">
      <h1 class="page-header">Hawk In The Sky </h1>
      <p class="text-muted" style="font-size:20px;">Google Analytics Dashboard</p>
      <p style="font-size:14px;">Login with the google account that has access to your analytics</p>
      <a class='btn btn-success btn-lg' href="<?= $authUrl ?>">Login with Google To Begin!</a>
    </div>
  <?php endif; ?>


  <div class="push"></div>
</div>
<div class="footer text-center">
  &copy; Hawk In The Sky
</div>
