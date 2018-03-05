<?php
require_once (realpath ( dirname ( __FILE__ ) . "/../config.php" ));
require_once (LIBRARY_PATH . "/templateFunctions.php");
require_once (LIBRARY_PATH . "/databaseFunctions.php");
// 4.247 ratio for header image
echo '
<div><img class="logo" src="images/layout/CTLLogo4CNA.png" alt="CenturyLink Logo" height="42" width="178"></div>
<div class="container-fluid">
	<ul class="nav nav-tabs" role="tablist">
        <li role="presentation" ';
								if ($tab == "commands" || $tab == null) {
									echo 'class="active"';
								}
								echo '>
            <a href="#commands" aria-controls="commands" role="tab" data-toggle="tab">Command</a>
        </li>';
								if (isset ( $_SESSION ["user"] )) {
								// TODO: add tab for Proposed command changes
								/*
								 * echo '
								 * <li role="presentation" ';
								 * if ($tab == "groups") {
								 * echo 'class="active"';
								 * }
								 * echo '>
								 * <a href="#groups" aria-controls="group" role="tab" data-toggle="tab">Group</a>
								 * </li>';
								 */
								echo '
        <li role="presentation" ';
								if ($tab == "users") {
									echo 'class="active"';
								}
								echo '>
            <a href="#users" aria-controls="users" role="tab" data-toggle="tab">Admin</a>
        </li>';
								echo '
        <li role="presentation" ';
								if ($tab == "server") {
									echo 'class="active"';
								}
								echo '>
            <a href="#server" aria-controls="server" role="tab" data-toggle="tab">Jumphost</a>
        </li>';
								echo '
        <li role="presentation" ';
								if ($tab == "venders") {
									echo 'class="active"';
								}
								echo '>
            <a href="#venders" aria-controls="venders" role="tab" data-toggle="tab">Vendor</a>
        </li>';
								echo '
        <li role="presentation" ';
								if ($tab == "memberdevice") {
									echo 'class="active"';
								}
								echo '>
            <a href="#memberdevice" aria-controls="memberdevice" role="tab" data-toggle="tab">User/Device Group Lookup</a>
        </li>';
								}  //end logged in tabs
								echo '
        <li role="presentation" ';
								if ($tab == "logging") {
									echo 'class="active"';
								}
								echo '>
            <a href="#logging" aria-controls="logging" role="tab" data-toggle="tab">Rejected Command Log</a>
        </li>';
								echo '
        <li role="presentation" ';
								if ($tab == "whoLoggedIn") {
									echo 'class="active"';
								}
								echo '>
            <a href="#whoLoggedIn" aria-controls="whoLoggedIn" role="tab" data-toggle="tab">Who is logged in</a>
        </li>';
								echo'
		<li role="presentation" ';
								if ($tab == "numberspage") {
									echo 'class="active"'; 
								}
								echo '>
        	<a href="#numberspage" aria-controls="numberspage" role="tab" data-toggle="tab">Stats</a>
        </li>';
								echo'
		<li role="presentation" ';
								if ($tab == "toptenpage") {
									echo 'class="active"';
								}
								echo '>
        	<a href="#toptenpage" aria-controls="toptenpage" role="tab" data-toggle="tab">Top Twenty</a>
        </li>';
// 								echo'
// 		<li role="presentation" ';
// 								if ($tab == "legacypage-tab") {
// 									echo 'class="active"';
// 								}
// 								echo '>
//         	<a href="#legacypage-tab" aria-controls="legacypage-tab" role="tab" data-toggle="tab">Legacy ROC</a>
//         </li>';
echo '							
    </ul>
</div>
<div class="tab-content">';
	// COMMANDS TAB
	if ($tab == "commands" || $tab == null) {
		echo '<div role="tabpanel" class="tab-pane active" id="commands">';
	} else {
		echo '<div role="tabpanel" class="tab-pane" id="commands">';
	}
	
	$_SERVER ["REQUEST_METHOD"] = "GET";
	
	$dbf = new DatabaseFunctions ();
	$commandResults = $dbf->fetchCommandsTable ();
	$commands = $commandResults->fetchAll ();
	for($i = 0; $i < count ( $commands ); $i ++) {
		// making a unique key since the database can't for checking duplicates
		$commands [$i] ["commandKey"] = $commands [$i] ["groupname"] . $commands [$i] ["regex"] . $commands [$i] ["vendor"];
	}
	$jsonCommands = json_encode ( $commands );
	echo '<script>var commandsData = JSON.parse(JSON.stringify(' . $jsonCommands . '));</script>';
	// get all groups used for filtering
	$commandGroupResults = $dbf->fetchDistinctColumn ( "commandpatterns", "groupname" );
	$commandGroups = $commandGroupResults->fetchAll ();
	$jsonCommandGroups = json_encode ( $commandGroups );
	echo '<script>var commandGroupsData = JSON.parse(JSON.stringify(' . $jsonCommandGroups . '));</script>';
	// get all vendors used for filtering
	$commandVendorResults = $dbf->fetchDistinctColumn ( "commandpatterns", "vendor" );
	$commandVendors = $commandVendorResults->fetchAll ();
	$jsonCommandVendors = json_encode ( $commandVendors );
	echo '<script>var commandVendorsData = JSON.parse(JSON.stringify(' . $jsonCommandVendors . '));</script>';
	// get regex
	$commandRegexResults = $dbf->fetchDistinctColumn ( "commandpatterns", "regex" );
	$commandRegex = $commandRegexResults->fetchAll ();
	$jsonCommandRegex = json_encode ( $commandRegex );
	echo '<script>var commandRegexData = JSON.parse(JSON.stringify(' . $jsonCommandRegex . '));</script>';
	$sortOn = array (
			array (
					"id" => "groupname",
					0 => "groupname",
					"text" => "Group",
					1 => "Group" 
			),
			array (
					"id" => "vendor",
					0 => "vendor",
					"text" => "Vendor",
					1 => "Vendor" 
			),
			array (
					"id" => "regex",
					0 => "regex",
					"text" => "Regex",
					1 => "Regex" 
			),
			array (
					"id" => "allow",
					0 => "allow",
					"text" => "Allow",
					1 => "Allow" 
			) 
	);
	
	// get group names for add, edit
	$groupNameResults = $dbf->fetchColumn ( "commandgroup", "groupname" );
	$groupNames = $groupNameResults->fetchAll ();
	$jsonGroupNames = json_encode ( $groupNames );
	echo '<script>var groupNamesData = JSON.parse(JSON.stringify(' . $jsonGroupNames . '));</script>';
	// get vendors fro add, edit
	$vendorResults = $dbf->fetchColumn ( "vendors", "vendor" );
	$vendorNames = $vendorResults->fetchAll ();
	$jsonVendorNames = json_encode ( $vendorNames );
	echo '<script>var vendorNamesData = JSON.parse(JSON.stringify(' . $jsonVendorNames . '));</script>';
	// build the opt for check box
	$allow = array (
			array (
					"id" => "-1",
					0 => "-1",
					"text" => "Disallow",
					1 => "Disallow" 
			),
			array (
					"id" => "0",
					0 => "0",
					"text" => "Needs Confirmation",
					1 => "Needs Confirmation"
			),
			array (
					"id" => "1",
					0 => "1",
					"text" => "Allow",
					1 => "Allow" 
			) 
	);
	$jsonAllow = json_encode ( $allow );
	echo '<script>var allowData = JSON.parse(JSON.stringify(' . $jsonAllow . '));</script>';
	// build dropdown for the cloning
	$cloneResults = $dbf->fetchDistinctColumn ( "commandpatterns", "groupname" );
	$cloneGroups = $cloneResults->fetchAll ();
	$json = json_encode ( $cloneGroups );
	echo '<script>var cloneGroupsData = JSON.parse(JSON.stringify(' . $json . '));</script>';
	
	// if you did a search
	if (isset ( $_SESSION ["cSearchResultsSession"] )) {
		$savedResults = $dbf->fetchSavedFilter();
		$searchResultsC = $savedResults->fetchAll ();
		for($i = 0; $i < count ( $searchResultsC ); $i ++) {
			// making a unique key since the database can't for checking duplicates
			$searchResultsC [$i] ["commandKey"] = $searchResultsC [$i] ["groupname"] . $searchResultsC [$i] ["regex"] . $searchResultsC [$i] ["vendor"];
		}
		$jsonCommands = json_encode ( $searchResultsC );
		echo '<script>var commandsFilteredData = JSON.parse(JSON.stringify(' . $jsonCommands . '));</script>';
		// Must pass in variables (as an array) to use in template
		$masterArray = [ 
				"commands" => $searchResultsC,
				"groupNames" => $groupNames,
				"vendorNames" => $vendorNames,
				"allow" => $allow,
				"cloneGroups" => $cloneGroups,
				"commandGroups" => $commandGroups,
				"commandVendors" => $commandVendors,
				"commandRegex" => $commandRegex,
				"sortOn" => $sortOn 
		];
		renderTabWithContentFile ( "commands.php", $masterArray );
	}				// if you did not do a search
	else {
		$jsonCommands = json_encode ( $commands );
		echo '<script>var commandsFilteredData = JSON.parse(JSON.stringify(' . $jsonCommands . '));</script>';
		// Must pass in variables (as an array) to use in template
		$masterArray = [ 
				"commands" => $commands,
				"groupNames" => $groupNames,
				"vendorNames" => $vendorNames,
				"allow" => $allow,
				"cloneGroups" => $cloneGroups,
				"commandGroups" => $commandGroups,
				"commandVendors" => $commandVendors,
				"commandRegex" => $commandRegex,
				"sortOn" => $sortOn 
		];
		renderTabWithContentFile ( "commands.php", $masterArray );
	}
	echo '</div>';
	
	// STATS TAB
	if ($tab == "numberspage") {
		echo '<div role="tabpanel" class="tab-pane active" id="numberspage">';
	} else {
		echo '<div role="tabpanel" class="tab-pane" id="numberspage">';
	}
	
	$nextSundayUNIX = strtotime("next Sunday");
	$nextSunday = new DateTime();
	$nextSunday->setTimestamp($nextSundayUNIX);
	$i = new DateInterval('P1W');
	$start = new DateTime("2017-4-16");
	$dateRange = new DatePeriod($start, $i, $nextSunday);
	$periodWeeks = array_reverse(iterator_to_array($dateRange));
	$weeklyTotals = array();
	$j = 0;
	foreach ($periodWeeks as $aWeek) {
		$weeklyTotals[$j] = array(
				"rejectedWeekTotal" => 0,
				"allCmdWeekTotal" => 0,
				"newUsersWeekTotal" => 0,
				"rocCmdsWeekTotal" => 0,
				"allUsersWeekTotal" => 0,
				"allDevicesWeekTotal" => 0,
				"allFunctionWeekTotal" => 0,
				"rocUsersWeekTotal" => 0,
				"aWeek" => $aWeek->format('Y-m-d')
		);
		$j++;
	}
	
	$nextDayUNIX = strtotime("tomorrow");
	$nextDay = new DateTime();
	$nextDay->setTimestamp($nextDayUNIX);
	$k = new DateInterval('P1D');
	$sixWeeksUNIX = strtotime("-6 weeks");
	$start = new DateTime();
	$start->setTimestamp($sixWeeksUNIX);
	$dateRange = new DatePeriod($start, $k, $nextDay);
	$periodDays = array_reverse(iterator_to_array($dateRange));
	$dailyTotals = array();
	$j = 0;
	foreach ($periodDays as $aDay) {
		$dailyTotals[$j] = array(
				"rejectedDayTotal" => 0,
				"allCmdDayTotal" => 0,
				"newUsersDayTotal" => 0,
				"rocCmdsDayTotal" => 0,
				"allUsersDayTotal" => 0,
				"allDevicesDayTotal" => 0,
				"allFunctionDayTotal" => 0,
				"rocUsersDayTotal" => 0,
				"aDay" => $aDay->format('Y-m-d')
		);
		$j++;
	}
	
	$rejectedCmdTotal = countAndArray("rejcmds", $periodWeeks, $weeklyTotals,"rejectedWeekTotal", $periodDays, $dailyTotals, "rejectedDayTotal");
	$rejectedCountTotal = $rejectedCmdTotal["allCountTotal"];
	//$rejectedCmdArray = $rejectedCmdTotal["allArray"];
	
	$rejectedCmdCount = $dbf->fetchLogBeforeStatTable();
	$rejectedCmdCountArray = $rejectedCmdCount->fetchAll();
	foreach ($rejectedCmdCountArray as $row) {
		$rejectedCountTotal = 1 + $rejectedCountTotal;
		$j = 0;
		foreach ($periodWeeks as $aWeek) {
			$rowDateTime = new DateTime($row["datetime"]);
			$endWeek = new DateTime($aWeek->format('Y-m-d'));
			$endWeek->add($i);
			if (($aWeek <= $rowDateTime) && ($rowDateTime < $endWeek)) {
				$weeklyTotals[$j]["rejectedWeekTotal"] = 1 + $weeklyTotals[$j]["rejectedWeekTotal"];
			}
			$j++;
		}
		$j = 0;
		foreach ($periodDays as $aDay) {
			$rowDateTime = new DateTime($row["datetime"]);
			$endDay = new DateTime($aDay->format('Y-m-d'));
			$endDay->add($k);
			if (($aDay<= $rowDateTime) && ($rowDateTime < $endDay)) {
				$dailyTotals[$j]["rejectedDayTotal"] = 1 + $dailyTotals[$j]["rejectedDayTotal"];
			}
			$j++;
		}
	}
	
	$allCmdTotal = countAndArray("allcmds", $periodWeeks, $weeklyTotals,"allCmdWeekTotal", $periodDays, $dailyTotals, "allCmdDayTotal");
	$allCountTotal = $allCmdTotal["allCountTotal"];
	//$allCmdArray = $allCmdTotal["allArray"];
	
	$percentCmds = $rejectedCountTotal/$allCountTotal;
	$percentFriendlyCmds = number_format( $percentCmds * 100, 2 ) . '%';
	
	$newUserTotal = countAndArray("toolusrs", $periodWeeks, $weeklyTotals,"newUsersWeekTotal", $periodDays, $dailyTotals, "newUsersDayTotal", true);
	$userCountTotal = $newUserTotal["allCountTotal"];
	//$usersArray = $newUserTotal["allArray"];
	
	// 				for ($z=count($weeklyTotals)-2; $z >= 0; $z--) {
	// 					$weeklyTotals[$z]["newUsersWeekTotal"] = $weeklyTotals[$z]["newUsersWeekTotal"] + $weeklyTotals[$z+1]["newUsersWeekTotal"];
	// 				}
	
	$allUsersTotal = countAndArray("allusers", $periodWeeks, $weeklyTotals,"allUsersWeekTotal", $periodDays, $dailyTotals, "allUsersDayTotal", true);
	$allUsersCountTotal= $allUsersTotal["allCountTotal"];
	//$allUsersArray = $allUsersTotal["allArray"];
	
	$allDeviceTotal = countAndArray("alldvcs", $periodWeeks, $weeklyTotals,"allDevicesWeekTotal", $periodDays, $dailyTotals, "allDevicesDayTotal", true);
	$allDevicesCountTotal = $allDeviceTotal["allCountTotal"];
	//$allDevicesArray = $allDeviceTotal["allArray"];
	
	$allFunctionTotal = countAndArray("allfrpgs", $periodWeeks, $weeklyTotals,"allFunctionWeekTotal", $periodDays, $dailyTotals, "allFunctionDayTotal", true);
	$allFunctionCountTotal = $allFunctionTotal["allCountTotal"];
	//$allFunctionArray = $allFunctionTotal["allArray"];
	
	$allRocCmdTotal = countAndArray("roccmds", $periodWeeks, $weeklyTotals,"rocCmdsWeekTotal", $periodDays, $dailyTotals, "rocCmdsDayTotal");
	$rocCountTotal = $allRocCmdTotal["allCountTotal"];
	//$rocArray = $allRocCmdTotal["allArray"];
	
	$rocUsersTotal = countAndArray("rocusers", $periodWeeks, $weeklyTotals,"rocUsersWeekTotal", $periodDays, $dailyTotals, "rocUsersDayTotal", true);
	$rocUsersCountTotal = $rocUsersTotal["allCountTotal"];
	//$rocUsersArray = $rocUsersTotal["allArray"];
	
	$percentUsers = $userCountTotal/$allUsersCountTotal;
	$percentFriendlyUsers = number_format( $percentUsers* 100, 2 ) . '%';
	
	$allTotals = array(
			"rejectedCountTotal" => $rejectedCountTotal,
			"allCountTotal" => $allCountTotal,
			"userCountTotal" => $userCountTotal,
			"allUsersCountTotal" => $allUsersCountTotal,
			"allDevicesCountTotal" => $allDevicesCountTotal,
			"percentFriendlyCmds" => $percentFriendlyCmds,
			"percentFriendlyUsers" => $percentFriendlyUsers,
			"allFunctionCountTotal" => $allFunctionCountTotal,
			
	);
	$json = json_encode ( $weeklyTotals );
	echo '<script>var weeklyTotals = JSON.parse(JSON.stringify(' . $json . '));</script>';
	
	$json = json_encode ( $periodWeeks );
	echo '<script>var periodWeeks = JSON.parse(JSON.stringify(' . $json . '));</script>';
	
	$json = json_encode ( $periodDays );
	echo '<script>var periodDays = JSON.parse(JSON.stringify(' . $json . '));</script>';
	
	$json = json_encode ( $dailyTotals );
	echo '<script>var dailyTotals = JSON.parse(JSON.stringify(' . $json . '));</script>';
	
	//echo '<script>var loggingFilteredData = JSON.parse(JSON.stringify(' . $json . '));</script>';
	renderTabWithContentFile ( "stats.php", $allTotals, $weeklyTotals);
	echo '</div>';
	
	//Top ten
	
	if ($tab == "toptenpage") {
		echo '<div role="tabpanel" class="tab-pane active" id="toptenpage">';
	} else {
		echo '<div role="tabpanel" class="tab-pane" id="toptenpage">';
	}
	
	// Must pass in variables (as an array) to use in template
	$tenCommandResults = $dbf->fetchTopTenRejectedTable( "command" );
	$tenCommands = $tenCommandResults->fetchAll ();
	$jsonTenCommands = json_encode ( $tenCommands);
	echo '<script>var tenCommands = JSON.parse(JSON.stringify(' . $jsonTenCommands . '));</script>';
	
	$tenDeviceResults = $dbf->fetchTopTenRejectedTable( "device" );
	$tenDevices = $tenDeviceResults->fetchAll ();
	$jsonTenDevices = json_encode ( $tenDevices );
	echo '<script>var tenDevices = JSON.parse(JSON.stringify(' . $jsonTenDevices. '));</script>';
	
	$tenVendorResults = $dbf->fetchTopTenRejectedTable( "vendor" );
	$tenVendors = $tenVendorResults->fetchAll ();
	$jsonTenVendors = json_encode ( $tenVendors);
	echo '<script>var tenVendors = JSON.parse(JSON.stringify(' . $jsonTenVendors . '));</script>';
	
	$allTen = array(
			"commands" => $tenCommands,
			"devices" => $tenDevices,
			"vendors" => $tenVendors
	);
	
	renderTabWithContentFile ( "topten.php", $allTen );
	echo '</div>';
	
	//Legacy
	
// 	if ($tab == "legacypage") {
// 		echo '<div role="tabpanel" class="tab-pane active" id="legacypage">';
// 	} else {
// 		echo '<div role="tabpanel" class="tab-pane" id="legacypage">';
// 	}
	
// 	$allRoc = array(
// 			"rocUsersCountTotal" => $rocUsersCountTotal,
// 			"rocCountTotal" => $rocCountTotal
// 	);
	
// 	renderTabWithContentFile ( "legacy.php", $allRoc, $weeklyTotals);
// 	echo '</div>';
	
	// GROUPS TAB
	/*
	 * if ($tab == "groups") {
	 * echo '<div role="tabpanel" class="tab-pane active" id="groups">';
	 * }
	 * else {
	 * echo '<div role="tabpanel" class="tab-pane" id="groups">';
	 * }
	 * // Must pass in variables (as an array) to use in template
	 * $groupResults = $dbf->fetchTable ( "commandgroup" );
	 * $groups = $groupResults->fetchAll ();
	 * $json = json_encode ( $groups );
	 *
	 * echo '<script>var groupsData = JSON.parse(JSON.stringify(' . $json . '));</script>';
	 *
	 * renderTabWithContentFile ( "groups.php", $groups );
	 * echo '</div>';
	 */
	
	// ADMINS TAB
	if ($tab == "users") {
		echo '<div role="tabpanel" class="tab-pane active" id="users">';
	} else {
		echo '<div role="tabpanel" class="tab-pane" id="users">';
	}
	// Must pass in variables (as an array) to use in template
	$userResults = $dbf->fetchTable ( "userlist" );
	$users = $userResults->fetchAll ();
	$jsonUsers = json_encode ( $users );
	echo '<script>var usersData = JSON.parse(JSON.stringify(' . $jsonUsers . '));</script>';
	
	$userResults = $dbf->fetchUserAddTable ();
	$usersAdd = $userResults->fetchAll ();
	$jsonAddUsers = json_encode ( $usersAdd );
	echo '<script>var usersAddData = JSON.parse(JSON.stringify(' . $jsonAddUsers . '));</script>';
	
	$adminState = array (
			array (
					"id" => "0",
					0 => "0",
					"text" => "No",
					1 => "No" 
			),
			array (
					"id" => "1",
					0 => "1",
					"text" => "Yes",
					1 => "Yes" 
			) 
	);
	$jsonAdminState = json_encode ( $adminState );
	echo '<script>var adminStateData = JSON.parse(JSON.stringify(' . $jsonAdminState . '));</script>';
	renderTabWithContentFile ( "users.php", $users, $adminState, $usersAdd );
	echo '</div>';
	
	// JUMPHOST TAB
	if ($tab == "server") {
		echo '<div role="tabpanel" class="tab-pane active" id="server">';
	} else {
		echo '<div role="tabpanel" class="tab-pane" id="server">';
	}
	// Must pass in variables (as an array) to use in template
	$serverResults = $dbf->fetchTable ( "validserverip" );
	$servers = $serverResults->fetchAll ();
	$json = json_encode ( $servers );
	
	echo '<script>var serversData = JSON.parse(JSON.stringify(' . $json . '));</script>';
	
	renderTabWithContentFile ( "server.php", $servers );
	echo '</div>';
	
	// VENDORS TAB
	if ($tab == "vendors") {
		echo '<div role="tabpanel" class="tab-pane active" id="venders">';
	} else {
		echo '<div role="tabpanel" class="tab-pane" id="venders">';
	}
	// Must pass in variables (as an array) to use in template
	$vendorsResults = $dbf->fetchTable ( "vendors" );
	$vendors = $vendorsResults->fetchAll ();
	$json = json_encode ( $vendors );
	
	echo '<script>var vendorsData = JSON.parse(JSON.stringify(' . $json . '));</script>';
	
	$vendorsDeleteResults = $dbf->fetchVendorsToDeleteTable ();
	$vendorsDelete = $vendorsDeleteResults->fetchAll ();
	$json = json_encode ( $vendorsDelete );
	
	echo '<script>var vendorsDeleteData = JSON.parse(JSON.stringify(' . $json . '));</script>';
	
	renderTabWithContentFile ( "vendors.php", $vendors, $vendorsDelete );
	echo '</div>';
	
	// LOGGING TAB
	if ($tab == "logging") {
		echo '<div role="tabpanel" class="tab-pane active" id="logging">';
	} else {
		echo '<div role="tabpanel" class="tab-pane" id="logging">';
	}
	// Must pass in variables (as an array) to use in template
	$loggingResults = $dbf->fetchLoggingTable ();
	$logging = $loggingResults->fetchAll ();
	$json = json_encode ( $logging );
	
	echo '<script>var loggingData = JSON.parse(JSON.stringify(' . $json . '));</script>';
	if (isset ( $_SESSION ["lSearchResultsSession"] )) {
		echo '<script>var loggingFilteredData = JSON.parse(JSON.stringify(' . $searchResults . '));</script>';
		renderTabWithContentFile ( "logging.php", $searchResults );
	} else {
		echo '<script>var loggingFilteredData = JSON.parse(JSON.stringify(' . $json . '));</script>';
		renderTabWithContentFile ( "logging.php", $logging );
	}
	echo '</div>';
	
	//User/Device TAb
	if ($tab == "memberdevice") {
		echo '<div role="tabpanel" class="tab-pane active" id="memberdevice">';
	} else {
		echo '<div role="tabpanel" class="tab-pane" id="memberdevice">';
	}
	$uOrD = array (
			array (
					"id" => "u",
					0 => "u",
					"text" => "Username",
					1 => "Username"
			),
			array (
					"id" => "d",
					0 => "d",
					"text" => "DNS name or IP Address",
					1 => "DNS name or IP Address"
			)
	);
	$jsonUOrD= json_encode ( $uOrD);
	echo '<script>var uOrDData = JSON.parse(JSON.stringify(' . $jsonUOrD . '));</script>';
	renderTabWithContentFile ( "memberdevice.php", $uOrD, $searchResults);

	echo '</div>';
	
	
	
	//WHOS LOGGED IN
	if ($tab == "whoLoggedIn") {
		echo '<div role="tabpanel" class="tab-pane active" id="whoLoggedIn">';
	} else {
		echo '<div role="tabpanel" class="tab-pane" id="whoLoggedIn">';
	}
	renderTabWithContentFile ( "whoLoggedIn.php");
	echo '</div>';
echo '</div>';
?>
