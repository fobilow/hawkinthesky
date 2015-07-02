<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="description" content="HawkInTheSky - Google Analytics Dashboard">
  <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta http-equiv="refresh" content="60">
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css"/>
  <style>
    body{
      background-color: #fff;
      color:#000;
      font-size:40px;
    }

    html, body {
      height: 100%;
    }

    .container-fluid {
      min-height: 100%;
      height: auto !important; /* This line and the next line are not necessary unless you need IE6 support */
      height: 100%;
      margin: 0 auto -30px; /* the bottom margin is the negative value of the footer's height */
    }
    .footer, .push {
      font-size:12px;
      height: 30px; /* .push must be the same height as .footer */
    }

    .infobar
    {
      background-color:#000;
      padding:5px;
      font-size:12px;
      color:#fff;
      text-align:right;
    }
  </style>
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
          <p class="text-primary" style="font-size:30px; margin-bottom:20px;"><?= key($stats) ?></p>
          <p style="line-height: 30px; margin-bottom:40px;"><?= $metrics['ga:sessions']; ?>
            <br/><span style="font-size:20px;"><?= Hawk::metricsName('ga:sessions') ?></span>
          </p>

          <p style="line-height: 30px; margin-bottom:40px;"><?= $metrics['ga:pageviews']; ?>
            <br/><span style="font-size:20px;"><?= Hawk::metricsName('ga:pageviews') ?></span>
          </p>

          <p style="line-height: 30px; margin-bottom:40px;"><?= number_format($metrics['ga:bounceRate'],2 ); ?>%
            <br/><span style="font-size:20px;"><?= Hawk::metricsName('ga:bounceRate') ?></span>
          </p>

          <p style="line-height: 30px; margin-bottom:40px;"><?= number_format($metrics['ga:avgPageLoadTime'], 2); ?>s
            <br/><span style="font-size:20px;"><?= Hawk::metricsName('ga:avgPageLoadTime') ?></span>
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
