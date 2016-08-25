<?php

require_once dirname(__FILE__).'/accesscheck.php';
ob_end_flush();
$upgrade_required = 0;
$canUpgrade = checkAccess('upgrade');

if (Sql_Table_exists($tables['config'], 1)) {
    $dbversion = getConfig('version');
    if ($dbversion != VERSION && $canUpgrade) {
        Error($GLOBALS['I18N']->get('Your database is out of date, please make sure to upgrade').'<br/>'.
     $GLOBALS['I18N']->get('Your version').' : '.$dbversion.'<br/>'.
     $GLOBALS['I18N']->get('phplist version').' : '.VERSION.
    '<br/>'.PageLink2('upgrade', $GLOBALS['I18N']->get('Upgrade'))
     );
        $upgrade_required = 1;
    }
} else {
    Info($GLOBALS['I18N']->get('Database has not been initialised').'. '.
  $GLOBALS['I18N']->get('go to').' '.
  PageLink2('initialise&firstinstall=1', $GLOBALS['I18N']->get('Initialise Database')).' '.
  $GLOBALS['I18N']->get('to continue'), 1);
    $GLOBALS['firsttime'] = 1;
    $_SESSION['firstinstall'] = 1;

    return;
}

## trigger this somewhere else?
refreshTlds();

# check for latest version
$checkinterval = sprintf('%d', getConfig('check_new_version'));
if (!isset($checkinterval)) {
    $checkinterval = 7;
}

$showUpdateAvail = !empty($_GET['showupdate']); ## just to check the design
$thisversion = VERSION;
$thisversion = preg_replace("/[^\.\d]/", '', $thisversion);
$latestversion = getConfig('updateavailable');
$showUpdateAvail = $showUpdateAvail || (!empty($latestversion) && !versionCompare($thisversion, $latestversion));

if (!$showUpdateAvail && $checkinterval) {

  ##https://mantis.phplist.com/view.php?id=16815
  $query = sprintf('select date_add(value, interval %d day) < now() as needscheck from %s where item = "updatelastcheck"', $checkinterval, $tables['config']);
    $needscheck = Sql_Fetch_Row_Query($query);
    if ($needscheck[0] != '0') {
        @ini_set('user_agent', NAME.' (phplist version '.VERSION.')');
        @ini_set('default_socket_timeout', 5);
        if ($fp = @fopen('https://www.phplist.com/files/LATESTVERSION', 'r')) {
            $latestversion = fgets($fp);
            $latestversion = preg_replace("/[^\.\d]/", '', $latestversion);
            @fclose($fp);
            if (!versionCompare($thisversion, $latestversion)) {
                ## remember this, so we can remind about the update, without the need to check the phplist site
        ## hmmm, this causes it to be "stuck" on the last version checked
        SaveConfig('updateavailable', $latestversion, 0, true);
                $showUpdateAvail = true;
            }
        }
        SaveConfig('updatelastcheck', date('Y-m-d H:i:s', time()), 0, true);
    }
}

if ($showUpdateAvail) {/*
    print '<div class="newversion note">';
    print $GLOBALS['I18N']->get('A new version of phpList is available!');
    print '<br/>';
    print '<br/>'.$GLOBALS['I18N']->get('The new version may have fixed security issues,<br/>so it is recommended to upgrade as soon as possible');
    print '<br/>'.$GLOBALS['I18N']->get('Your version').': <b>'.$thisversion.'</b>';
    print '<br/>'.$GLOBALS['I18N']->get('Latest version').': <b>'.$latestversion.'</b><br/>  ';
    print '<a href="https://www.phplist.com/latestchanges?utm_source=pl'.$thisversion.'&amp;utm_medium=updatenews&amp;utm_campaign=phpList" title="'.s('Read what has changed in the new version').'" target="_blank">'.$GLOBALS['I18N']->get('View what has changed').'</a>&nbsp;&nbsp;';
    print '<a href="https://www.phplist.com/download?utm_source=pl'.$thisversion.'&amp;utm_medium=updatedownload&amp;utm_campaign=phpList" title="'.s('Download the new version').'" target="_blank">'.$GLOBALS['I18N']->get('Download').'</a></div>';
*/}





?> <div class="row">
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box blue-bg">
						<i class="fa fa-cloud-download"></i>
						<div class="count"><?php
						  
        $count = Sql_query('SELECT count(*) FROM phplist_user_user');

				
$totalres = Sql_fetch_Row($count);
echo $total = $totalres[0];  




?></div>
						<div class="title">Total Email</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->
				
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box brown-bg">
						<i class="fa fa-shopping-cart"></i>
						<div class="count"><? $req = Sql_query("select sum(processed) from phplist_message" ); 
$total_req = Sql_Fetch_Row($req); 
echo $total = $total_req[0]; ?></div>
						<div class="title">Delivered</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->	
				
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box dark-bg">
						<i class="fa fa-thumbs-o-up"></i>
						<div class="count"><? $req = Sql_query("select count(*) from phplist_message where status='submitted'" ); 
$total_req = Sql_Fetch_Row($req); 
echo $total = $total_req[0]; ?></div>
						<div class="title">Opened Campaign </div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->
				
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box green-bg">
						<i class="fa fa-cubes"></i>
						<div class="count"><?php         $totalclicked = Sql_Fetch_Row_Query(sprintf("select count(distinct userid) from phplist_linktrack_uml_click "));
						
						echo $totalclicked[0];
  ?></div>
						<div class="title">Clicked</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->
				
			</div>
