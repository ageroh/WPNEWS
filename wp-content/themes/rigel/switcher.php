<?php
if(session_id() == '') 
{
	session_start();
}

$redirect_url = $_SERVER['HTTP_REFERER'];

if(isset($_GET['pp_layout']))
{
	$redirect_url.= '&rigellayout='.$_GET['pp_layout'];
}

if(isset($_GET['pp_skin']))
{
	$redirect_url.= '&rigelskin='.$_GET['pp_skin'];
}

header( 'Location: '.$redirect_url ) ;
?>