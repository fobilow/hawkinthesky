<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="description" content="HawkInTheSky - Google Analytics Dashboard">
  <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta http-equiv="refresh" content="60">
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="/assets/css/<?= $theme; ?>.css"/>
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
        <div class="<?= $colStyles; ?> stats-panel" style="border:1px solid #ddd;">
          <?php if($stats != null): $metrics = current($stats); ?>
            <h2 class="text-primary"><?= key($stats) ?></h2>
            <hr>

            <p class="stats-heading"><?= number_format($metrics['ga:sessions'], 0, '.', ','); ?>
              <br/><span class="stats-details"><?= Hawk::metricsName('ga:sessions') ?></span>
            </p>

            <p class="stats-heading"><?= number_format($metrics['ga:pageviews'], 0, '.', ','); ?>
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
