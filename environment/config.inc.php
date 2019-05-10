<?php

// Configuration
const BASE_URL = "https://www.passaportonline.poliziadistato.it";
const ENDPOINT = [
	"login" => "/LogInAction.do?codop=logCittadino",
	"dashboard" => "/indexCittadino.jsp",
	"office_list" => "/CittadinoAction.do?codop=resultRicercaRegistiProvincia", // Recupera le sedi
	"availability_list" => "/GestioneDisponibilitaAction.do?codop=getDisponibilitaCittadino",
	"calendar_list" => "/GestioneCalendarioCittadinoAction.do?codop=mostraCalendario&amp;idRegista=358&amp;data=05-04-2019",
	"calendar_slots" => "/dwr/call/plainpoll/ReverseAjax.dwr"
];

// Replace here your credential and email
define('SPARKPOST_KEY', 'xxxxx');
define('NOTIFY_ADDRESS', 'yyyy@xxxx.xyz');

define('CREDENTIAL_FILE', dirname(__FILE__).'/credential.json');

?>