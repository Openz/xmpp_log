<?php
//
$_SESSION['conf']="1";

// Configuration globale du site, slogan...
include_once("./bin/conf.php");

// Get nav index by scandir, slowest but strongest
function get_index() {
	$files = scandir($_SESSION['ref_dir']);
	$_SESSION['ref']=array();

	foreach ($files as $xkey => $year){
		if (preg_match("#^[0-9]{1,4}#", $year)) {
			$_SESSION['ref'][$year]="";

			foreach ( scandir($_SESSION['ref_dir'].'/'.$year) as $xkey => $month){
				if (preg_match("#^[0-9]{1,2}#", $month)) {
					$_SESSION['ref'][$year][$month]="";
				}				
			}

		}
	}
}

get_index();

// Création du menu de catégorie
$_SESSION['menu'] = '<ul id="nav">';

foreach ( $_SESSION['ref'] as $year => $value) {
	if ($year){
		$zz=array_keys($_SESSION['ref'][$year]);
		$last_month= end($zz);
		$_SESSION['menu'] .= '<li><a href="index.php?p='. $year . "_" . $last_month .'">'. $year .'</a></li>';
	}
}

$_SESSION['menu'] .= "   </ul>";

if (! isset($_SESSION['files'])){
	$_SESSION['files']=array();
	$_SESSION['files']['year']=$year;
	$_SESSION['files']['mount']=$last_month ;
}

?>
