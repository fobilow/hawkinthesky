<?php

include_once '../vendor/autoload.php';
include_once 'inc.php';
session_start();

if(isset($_GET['view']))
{
  switch($_GET['view'])
  {
    case 'month':
      $start = date('Y-m-01');
      $end = date('Y-m-t');
      break;
    case 'week':
      $start = date('Y-m-d', strtotime('-7 days'));
      $end = date('Y-m-d');
      break;
    case 'day':
    default:
      $start = date('Y-m-d');
      $end = date('Y-m-d');
      break;
  }
}
else
{
  $start = date('Y-m-d');
  $end = date('Y-m-d');
}

$errors        = [];
$client_id     = Hawk::$config['ga']['client_id'];
$client_secret = Hawk::$config['ga']['client_secret'];
$redirect_uri  = Hawk::$config['ga']['redirect_uri'];

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

$service = new Google_Service_Analytics($client);
/************************************************
 * If we have a code back from the OAuth 2.0 flow,
 * we need to exchange that with the authenticate()
 * function. We store the resultant access token
 * bundle in the session, and redirect to ourself.
 ************************************************/
if(isset($_GET['code']))
{
  $client->authenticate($_GET['code']);
  $_SESSION['access_token']  = $client->getAccessToken();
  $_SESSION['refresh_token'] = $client->getRefreshToken();
  $redirect                  = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

/************************************************
 * If we have an access token, we can make
 * requests, else we generate an authentication URL.
 ************************************************/
if(isset($_SESSION['access_token']) && $_SESSION['access_token'])
{
  $client->setAccessToken($_SESSION['access_token']);
}
else
{
  $authUrl = $client->createAuthUrl();
}

if($client->isAccessTokenExpired())
{
  unset($_SESSION['access_token']);
  if(isset($_SESSION['refresh_token']))
  {
    $client->refreshToken($_SESSION['refresh_token']);
    $_SESSION['refresh_token'] = $client->getRefreshToken();
  }
}

if($client->getAccessToken() && !$client->isAccessTokenExpired())
{
  $_SESSION['access_token'] = $client->getAccessToken();
  $properties               = Hawk::registerProperties($service);

  $dataGa = $service->data_ga;
  $stats  = [];
  foreach($properties as $property)
  {
    /**
     * @var Google_Service_Analytics_GaData $data
     */
    $metrics = 'ga:sessions,ga:pageviews,ga:uniquePageviews,'
      . 'ga:users,ga:newUsers,ga:avgPageLoadTime,ga:bounceRate';

    try
    {
      $data    = $dataGa->get(
        'ga:' . $property['ga_property_id'],
        $start,
        $end,
        $metrics
      );
      $stats[] = [$property['name'] => $data->getTotalsForAllResults()];
    }
    catch(Exception $e)
    {
      $errors[] = $e->getMessage();
    }
  }

  //complete the grid
  if($stats)
  {
    $cols = 4;
    $mod  = count($stats) % $cols;
    if($mod != 0)
    {
      $rem = $cols - $mod;
      for($i = 0; $i < $rem; $i++)
      {
        $stats[] = null;
      }
    }

    $statsRows = array_chunk($stats, $cols);
  }
}
include_once 'dashboard.php';






