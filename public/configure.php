<?php
include_once '../vendor/autoload.php';
include_once 'inc.php';
include_once 'logic.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="description" content="HawkInTheSky - Google Analytics Dashboard">
  <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="/assets/css/theme.css"/>
</head>
<body>
<div class="infobar">
  <div class="pull-left"><a href="/">Dashboard</a></div>
  <div class="pull-right"><?= date('d M Y H:i A') ?></div>
  <div class="clearfix"></div>
</div>
<div class="container-fluid">
    <h1>Configure The Hawk</h1>
    <table class="table">
      <tr>
        <th>Website</th>
        <th>Logo</th>
        <th>Status</th>
      </tr>
    <?php foreach(Hawk::getProperties(true) as $property): ?>
      <tr>
        <td width="20%">
          <strong><?= $property['name'] ?></strong>
          <br/><small class="text-muted"><?= $property['url'] ?></small>
        </td>
        <td width="50%">
          <input type="text" class="form-control" placeholder="http://"/>
        </td>
        <td class="30%">
          <a href="configure.php?id=<?= $property['ga_property_id']; ?>&action=<?= ($property['disabled'])? 'enable' : 'disable' ?>"><?= ($property['disabled'])? 'Enable' : 'Disable' ?></a></td>
      </tr>
    <?php endforeach; ?>
    </table>
    <button class="btn btn-success">Save</button>

  <div class="push"></div>
</div>
<div class="footer text-center">
  &copy; Hawk In The Sky
</div>
