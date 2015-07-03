<?php

/**
 * @author  oke.ugwu
 */
class Hawk
{
  private static $_dbConn;
  public static $config;

  public static function init()
  {
    self::$config = include '../config.php';
  }

  /**
   * @return \Simplon\Mysql\Mysql
   */
  public static function dbConn()
  {
    if(self::$_dbConn == null)
    {
      self::init();
      self::$_dbConn = new \Simplon\Mysql\Mysql(
        self::$config['database']['host'],
        self::$config['database']['username'],
        self::$config['database']['password'],
        self::$config['database']['database']
      );
    }

    return self::$_dbConn;
  }


  public static function registerProperties(Google_Service_Analytics $service)
  {
    $accountList = $service->management_accounts->listManagementAccounts();
    $accounts    = $accountList->getItems();
    /**
     * @var Google_Service_Analytics_Account $account
     */
    $webProperties = $service->management_webproperties;
    $return        = [];
    $data          = [];
    $data['owner'] = $accountList->getUsername();
    foreach($accounts as $account)
    {
      $data['ga_account_id'] = $account->getId();
      $properties            = $webProperties->listManagementWebproperties(
        $data['ga_account_id']
      );
      /**
       * @var Google_Service_Analytics_Webproperty $property
       */
      foreach($properties as $property)
      {
        $propertyId = $property->getDefaultProfileId();
        if($propertyId <= 0)
        {
          $items = $service->management_profiles->listManagementProfiles(
            $data['ga_account_id'],
            '~all'
          )->getItems();

          //Grab the property of the first profile if we have it.
          //For now that is all we care about. Maybe in the future we can handle
          //multiple profile more cleverly
          if(isset($items[0]))
          {
            /**
             * @var Google_Service_Analytics_Profile $item
             */
            $item       = $items[0];
            $propertyId = $item->getId();
          }
        }
        if($propertyId > 0)
        {
          $data['name']           = $property->getName();
          $data['ga_property_id'] = $propertyId;
          $data['url']            = $property->getWebsiteUrl();
          $data['time']           = time();

          $return[] = $data;

          //TODO - proper handling of duplicate keys and other sql errors
          try
          {
            self::dbConn()->insert('websites', $data, true);
          }
          catch(Exception $e)
          {
            error_log($e->getMessage());
          }
        }
        else
        {
          error_log(
            "Could not register " . $property->getName()
            . " because it has property_id=0"
          );
        }
      }
    }

    return $return;
  }

  /**
   * Returns an array of properties keyed by the property id
   *
   * @param string     $owner
   * @param bool|false $includeDisabled
   *
   * @return array
   */
  public static function getProperties($owner, $includeDisabled = false)
  {
    $append = ($includeDisabled) ? '' : ' AND disabled = 0';
    $result = self::dbConn()->fetchRowMany(
      sprintf(
        "SELECT * FROM websites WHERE owner='%s'" . $append,
        $owner
      )
    );

    $properties = [];
    foreach($result as $row)
    {
      $properties[$row['ga_property_id']] = $row;
    }

    return $properties;
  }

  public static function metricsName($name)
  {
    $lookup = [
      'ga:sessions'        => 'Sessions',
      'ga:pageviews'       => 'Page Views',
      'ga:uniquePageviews' => 'Unique PageViews',
      'ga:users'           => 'Users',
      'ga:newUsers'        => 'New Users',
      'ga:avgPageLoadTime' => 'Avg. Page Load Time',
      'ga:bounceRate'      => 'Bounce Rate'
    ];

    return isset($lookup[$name]) ? $lookup[$name] : '--';
  }
}

Hawk::init();
