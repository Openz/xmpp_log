<?php

if (! isset( $_SESSION['conf'] ) ) {
	include_once("./bin/init.php");
}

// Reception des numéros de pages demandées
if (isset($_GET['p']) ) {

  $z=explode("_",$_GET['p']);

	if ( array_key_exists($z['0'], $_SESSION['ref']) AND array_key_exists($z['1'], $_SESSION['ref'][$z['0']] ) ){
		$_SESSION['files']['year']=$z[0];
		$_SESSION['files']['mount']=$z[1] ;
	}
	else {
		include("./bin/attaque.php");
		$pid="0"; 
	}
}
else { 
$pid="0"; 
}

function click_url($html){
//print $html;
    $result=preg_replace('%\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))%s','<a href="$1">$1</a>',$html);
return $result;
}
function print_files() {

	$ref=$_SESSION['ref_dir'].'/'.$_SESSION['files']['year'].'/'. $_SESSION['files']['mount'];

	foreach ( scandir($ref) as $u => $value) {



			$zzz=explode(".",$value);
			$day=$zzz['0'];

			$mem_line="";

			if (preg_match("#^[0-9]{1,2}#", $day)) {

				// Loop through our array, show HTML source as HTML source; and line numbers too.
				foreach (file($ref .'/'. $day .'.txt') as $line_num => $line) {

					$zz=explode(" ",$line);

					if( isset($zz[1])){
						$zx=explode("T",$zz[1]);
						if( isset($zx[1])){
							$zxx=explode("Z",$zx[1]);
							$date=$zxx[0];
						}
					}


					if ($zz[0] == "MR"  ){

						//if (preg_match("/^\<.*\>$/", $zz[3].' '.$zz[4])) {
						$n_col_pseudo=4;
						$pseudo_color="#0000AA";
						if (preg_match("/^\<.*\>$/", $zz[3])) {

							$pseudo=$zz[3];

						}

						$za=$zz[3].' '.$zz[4];
						if (preg_match("/^\<.*\>$/", $za)) {
							$n_col_pseudo=5;
							$pseudo=$zz[3].' '.$zz[4];
						}

						$pseudo_color=ord(substr($pseudo,3,1)) .','. ord(substr($pseudo,1,1)) .','. ord(substr($pseudo,2,1));
						$trans = array("<" => "&#60;", ">" => "&#62;");

						$pseudo = strtr($pseudo, $trans);


						$text=click_url(implode(" ",array_slice($zz,$n_col_pseudo)));


		//preg_match_all('#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si', $text, $text2);
		//print_r($text2);








click_url($text);

//						$mem_line .=  '<font class="ts">'. $date .'</font> <font class="mn">'. $pseudo .'</font> '. $text .'<br />';
						$mem_line .=  '<p><font class="ts">'. $date .'</font> <font color=rgb('. $pseudo_color .')>'. $pseudo .'</font> '. $text .'</p>';

					}

				}
	
			}

			if ($mem_line){
				print '<h2>The '.$day.'</h2>';
				print $mem_line;
			}
		}	
}


// Page xhtml
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<title>'. $_SESSION['text']['name'] .' '. $_SESSION['files']['year'] .'-'. $_SESSION['files']['mount'] .'</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="description" content="'. $_SESSION['text']['slogan'] . $_SESSION['files']['year'] .'-'. $_SESSION['files']['mount'] .'" />
';


include("./bin/style.php");
//<link rel="stylesheet" media="screen" type="text/css" title="format" href="./src/style.css" />
echo '

<link rel="icon" type="image/x-icon" href="./src/doc.ico" />
</head>
<body>
';


echo '
<div id="header">
<div id="title">'. $_SESSION['text']['name'] .'</div>
<div id="slogan">'. $_SESSION['text']['slogan'] .'</div>
</div> <!-- end header -->

<div id="sidecontent">
';

//echo '<h2>Users connexion log</h2>';
//echo '<ul id="nav"><li><a href="index.php?hide=1">Show/hide users conexions</a></li></ul>';

/*
echo'<h2>Recherche</h2>';

if ( isset($_GET['reset_search'])  ) {
	unset ($_SESSION['search']);
}
if ( isset($_POST['search_lock']) || $_SESSION['search'] ) {
	include_once("./bin/query_search.php");
}

echo '<p>';
echo '<form  method="post" action="index.php" >';
echo '<input style="width: 194px;" name="cherche" value="'. $grt .'"/> ';
echo '<a href="index.php?pid='. $pid .'&reset_search=1">Reset</a>  ';
echo '<input type="hidden" name="search_lock" value="1" />';
echo '</form>';

echo '</p>';

*/

echo'<h2>Year</h2>';
echo $_SESSION['menu'];
echo '
</div> <!-- end sidecontent -->
<div id="maincontent">
';


if( isset($_SESSION['files']['year']) && ! empty($_SESSION['files']['year']) ){

	print '<div class=year> '.$_SESSION['files']['year'] .'</div>';

	echo "<p>\n";

	print '<div class="pagination"><ul>';
	foreach ( $_SESSION['ref'][$_SESSION['files']['year']] as $mount => $value) {
		#li.active
		if ($mount == $_SESSION['files']['mount']) {$active='class="s"';}else{$active="";}
		print '<li><a '. $active .' href="index.php?p='. $_SESSION['files']['year'] . "_" . $mount .'">'. $mount .'</a></li>';
		$active="";
		
	}
	print '</div></ul>';
	echo "</p>\n";
}



// Inclusion des pages
//include ('./bin/'. $_SESSION['page'][$pid]['script']);
if( isset($_SESSION['files']) && ! empty($_SESSION['files']) ){
	print_files($_SESSION['files']);
}


// Fermeture
echo $_SESSION['html_close'];


?>
