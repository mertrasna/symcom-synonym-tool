<?php
	ob_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('max_execution_time', 0);
	ini_set('memory_limit', -1);
	ini_set('max_input_vars', 10000);
	//session_start();
	// Central European timezone
	date_default_timezone_set('Europe/Vienna');
	include 'config.php';
	$date = date("Y-m-d H:i:s"); 
	include 'functions.php';
	//include 'functions-extended.php';

	/* 
	* Defining Time data's ending words array for extracting the time data 
	*/
	$timeStringEndTagArray = array(
		' St)',
		' St).',
		' St.)',
		' St. )',
		' St.).',
		'Tagen.)',
		'Tagen.).',
		'Tagen)',
		'Tagen).',
		'Nacht)',
		'Tag)',
		'Tag).',
		'Tag.)',
		'Tag.).',
		' T)',
		' T).',
		' T.)',
		' T.).',
		'Uhr.).',
		'Uhr).',
		'Uhr)',
		'Uhr.)',
		'Uhr),',
		'Uhr.),',
		'hour.).',
		'hour).',
		'hour)',
		'hour.)',
		'hour),',
		'hour.),',
		'hours)',
		'hours).',
		'hours.)',
		'hours.).',
		'hours),',
		'hours.),',
		'Hour.).',
		'Hour).',
		'Hour)',
		'Hour.)',
		'Hour),',
		'Hour.),',
		'Hours)',
		'Hours).',
		'Hours.)',
		'Hours.).',
		'Hours),',
		'Hours.),',
		'minute.).',
		'minute).',
		'minute.)',
		'minute)',
		'minute),',
		'minute.),',
		'minutes)',
		'minutes).',
		'minutes.)',
		'minutes.).',
		'minutes),',
		'minutes.),',
		'Minute.).',
		'Minute).',
		'Minute.)',
		'Minute)',
		'Minute),',
		'Minute.),',
		'Minutes)',
		'Minutes).',
		'Minutes.)',
		'Minutes.).',
		'Minutes),',
		'Minutes.),',
		'Noon)',
		'Noon).',
		'Noon.)',
		'Noon.).',
		'Noon),',
		'Noon.),',
		'noon)',
		'noon).',
		'noon.)',
		'noon.).',
		'noon),',
		'noon.),',
		'Afternoon)',
		'Afternoon).',
		'Afternoon.)',
		'Afternoon.).',
		'Afternoon),',
		'Afternoon.),',
		'afternoon)',
		'afternoon).',
		'afternoon.)',
		'afternoon.).',
		'afternoon),',
		'afternoon.),',
		'days)',
		'days).',
		'days.)',
		'days. )',
		'days.).',
		'days),',
		'days.),',
		'day)',
		'day).',
		'day.)',
		'day. )',
		'day.).',
		'day),',
		'day.),',
		'Wochen)',
		'Wochen).',
		'Wochen.)',
		'Wochen. )',
		'Wochen.).',
		'Wochen),',
		'Wochen.),',
		'wochen)',
		'wochen).',
		'wochen.)',
		'wochen. )',
		'wochen.).',
		'wochen),',
		'wochen.),',
		'Woche)',
		'Woche).',
		'Woche.)',
		'Woche. )',
		'Woche.).',
		'Woche),',
		'Woche.),',
		'woche)',
		'woche).',
		'woche.)',
		'woche. )',
		'woche.).',
		'woche),',
		'woche.),',
		'Woch)',
		'Woch).',
		'Woch.)',
		'Woch. )',
		'Woch.).',
		'Woch),',
		'Woch.),',
		'woch)',
		'woch).',
		'woch.)',
		'woch. )',
		'woch.).',
		'woch),',
		'woch.),',
		'Abends)',
		'Abends).',
		'Abends.)',
		'Abends. )',
		'Abends.).',
		'Abends),',
		'Abends.),',
		'abends)',
		'abends).',
		'abends.)',
		'abends. )',
		'abends.).',
		'abends),',
		'abends.),',
		'Tage)',
		'Tage).',
		'Tage.)',
		'Tage. )',
		'Tage.).',
		'Tage),',
		'Tage.),',
		'tage)',
		'tage).',
		'tage.)',
		'tage. )',
		'tage.).',
		'tage),',
		'tage.),',
		'Min)',
		'Min).',
		'Min.)',
		'Min. )',
		'Min.).',
		'Min),',
		'Min.),',
		'min)',
		'min).',
		'min.)',
		'min. )',
		'min.).',
		'min),',
		'min.),',
		'Sogleich)',
		'Sogleich).',
		'Sogleich.)',
		'Sogleich. )',
		'Sogleich.).',
		'Sogleich),',
		'Sogleich.),',
		'sogleich)',
		'sogleich).',
		'sogleich.)',
		'sogleich. )',
		'sogleich.).',
		'sogleich),',
		'sogleich.),',
		'Stunden)',
		'Stunden).',
		'Stunden.)',
		'Stunden. )',
		'Stunden.).',
		'Stunden),',
		'Stunden.),',
		'stunden)',
		'stunden).',
		'stunden.)',
		'stunden. )',
		'stunden.).',
		'stunden),',
		'stunden.),',
		'Stunde lang)',
		'Stunde lang).',
		'Stunde lang.)',
		'Stunde lang. )',
		'Stunde lang.).',
		'Stunde lang),',
		'Stunde lang.),',
		'Stunde Lang)',
		'Stunde Lang).',
		'Stunde Lang.)',
		'Stunde Lang. )',
		'Stunde Lang.).',
		'Stunde Lang),',
		'Stunde Lang.),',
		'stunde Lang)',
		'stunde Lang).',
		'stunde Lang.)',
		'stunde Lang. )',
		'stunde Lang.).',
		'stunde Lang),',
		'stunde Lang.),',
		'stunde lang)',
		'stunde lang).',
		'stunde lang.)',
		'stunde lang. )',
		'stunde lang.).',
		'stunde lang),',
		'stunde lang.),',
		'Einn)',
		'Einn).',
		'Einn.)',
		'Einn. )',
		'Einn.).',
		'Einn),',
		'Einn.),',
		'einn)',
		'einn).',
		'einn.)',
		'einn. )',
		'einn.).',
		'einn),',
		'einn.),'
	);

	for ($i=0; $i < 10; $i++) { 
		$am = $i." am)";
		$amWdot = $i." am).";
		$amEndingDot = $i." am.)";
		$amEndingDotWdot = $i." am.).";
		$amBothDot = $i." a.m.)";
		$amBothDotWdot = $i." a.m.).";
		$amNoSpace = $i."am)";
		$amNoSpaceWdot = $i."am).";
		$amNoSpaceEndingDot = $i."am.)";
		$amNoSpaceEndingDotWdot = $i."am.).";
		$amNoSpaceBothDot = $i."a.m.)";
		$amNoSpaceBothDotWdot = $i."a.m.).";

		$AM = $i." AM)";
		$AMWdot = $i." AM).";
		$AMEndingDot = $i." AM.)";
		$AMEndingDotWdot = $i." AM.).";
		$AMBothDot = $i." A.M.)";
		$AMBothDotWdot = $i." A.M.).";
		$AMNoSpace = $i."AM)";
		$AMNoSpaceWdot = $i."AM).";
		$AMNoSpaceEndingDot = $i."AM.)";
		$AMNoSpaceEndingDotWdot = $i."AM.).";
		$AMNoSpaceBothDot = $i."A.M.)";
		$AMNoSpaceBothDotWdot = $i."A.M.).";

		$pm = $i." pm)";
		$pmWdot = $i." pm).";
		$pmEndingDot = $i." pm.)";
		$pmEndingDotWdot = $i." pm.).";
		$pmBothDot = $i." p.m.)";
		$pmBothDotWdot = $i." p.m.).";
		$pmNoSpace = $i."pm)";
		$pmNoSpaceWdot = $i."pm).";
		$pmNoSpaceEndingDot = $i."pm.)";
		$pmNoSpaceEndingDotWdot = $i."pm.).";
		$pmNoSpaceBothDot = $i."p.m.)";
		$pmNoSpaceBothDotWdot = $i."p.m.).";

		$PM = $i." PM)";
		$PMWdot = $i." PM).";
		$PMEndingDot = $i." PM.)";
		$PMEndingDotWdot = $i." PM.).";
		$PMBothDot = $i." P.M.)";
		$PMBothDotWdot = $i." P.M.).";
		$PMNoSpace = $i."PM)";
		$PMNoSpaceWdot = $i."PM).";
		$PMNoSpaceEndingDot = $i."PM.)";
		$PMNoSpaceEndingDotWdot = $i."PM.).";
		$PMNoSpaceBothDot = $i."P.M.)";
		$PMNoSpaceBothDotWdot = $i."P.M.).";


		array_push($timeStringEndTagArray, $am, $amWdot, $amEndingDot, $amEndingDotWdot, $amBothDot, $amBothDotWdot, $amNoSpace, $amNoSpaceWdot, $amNoSpaceEndingDot, $amNoSpaceEndingDotWdot, $amNoSpaceBothDot, $amNoSpaceBothDotWdot, $AM, $AMWdot, $AMEndingDot, $AMEndingDotWdot, $AMBothDot, $AMBothDotWdot, $AMNoSpace, $AMNoSpaceWdot, $AMNoSpaceEndingDot, $AMNoSpaceEndingDotWdot, $AMNoSpaceBothDot, $AMNoSpaceBothDotWdot, $pm, $pmWdot, $pmEndingDot, $pmEndingDotWdot, $pmBothDot, $pmBothDotWdot, $pmNoSpace, $pmNoSpaceWdot, $pmNoSpaceEndingDot, $pmNoSpaceEndingDotWdot, $pmNoSpaceBothDot, $pmNoSpaceBothDotWdot, $PM, $PMWdot, $PMEndingDot, $PMEndingDotWdot, $PMBothDot, $PMBothDotWdot, $PMNoSpace, $PMNoSpaceWdot, $PMNoSpaceEndingDot, $PMNoSpaceEndingDotWdot, $PMNoSpaceBothDot, $PMNoSpaceBothDotWdot);
	}
?>
