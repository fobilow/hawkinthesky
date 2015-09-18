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
      $end   = date('Y-m-t');
      break;
    case 'week':
      $start = date('Y-m-d', strtotime('-7 days'));
      $end   = date('Y-m-d');
      break;
    case 'day':
    default:
      $start = date('Y-m-d');
      $end   = date('Y-m-d');
      break;
  }
}
else
{
  $start = date('Y-m-d');
  $end   = date('Y-m-d');
}

$errors        = [];
$statsRows     = [];
$client_id     = Hawk::$config['ga']['client_id'];
$client_secret = Hawk::$config['ga']['client_secret'];
$redirect_uri  = Hawk::$config['ga']['redirect_uri'];

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setAccessType('offline');
$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

$service = new Google_Service_Analytics($client);
if(isset($_SESSION['access_token']) && $_SESSION['access_token'])
{
  $client->setAccessToken($_SESSION['access_token']);
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

  $_SESSION['user'] = $properties[0]['owner'];
  $storedProperties = Hawk::getProperties($_SESSION['user'], true);

  $dataGa       = $service->data_ga;
  $realTimeData = $service->data_realtime;

  $stats = [];
  foreach($properties as $property)
  {
    //skip properties that have been disabled
    if(isset($storedProperties[$property['ga_property_id']])
      && $storedProperties[$property['ga_property_id']]['disabled'] == 0
    )
    {
      /**
       * @var Google_Service_Analytics_GaData $data
       */
      $metrics = 'ga:sessions,ga:pageviews,ga:uniquePageviews,'
        . 'ga:users,ga:newUsers,ga:avgPageLoadTime,ga:bounceRate';

      try
      {
        $data = $dataGa->get(
          'ga:' . $property['ga_property_id'],
          $start,
          $end,
          $metrics
        );

        $results              = Hawk::formatStats(
          $data->getTotalsForAllResults()
        );
        $results['siteName'] = $property['name'];
        $results['divClass'] = "site_" . substr(md5($property['name']), 0, 8);

        //get real time stats
        $rData = $realTimeData->get(
          'ga:' . $property['ga_property_id'],
          'rt:activeUsers'
        );

        $results = array_merge($results, $rData->getTotalsForAllResults());
        $stats[] = $results;
      }
      catch(Exception $e)
      {
        $errors[] = $e->getMessage();
      }
    }
  }
}

header("Content-Type: application/json");
echo json_encode($stats);




