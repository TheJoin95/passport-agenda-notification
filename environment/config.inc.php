<?php

const BASE_URL = "https://www.passaportonline.poliziadistato.it";
const ENDPOINT = [
	"login" => "/LogInAction.do?codop=logCittadino",
	"dashboard" => "/indexCittadino.jsp",
	"office_list" => "/CittadinoAction.do?codop=resultRicercaRegistiProvincia",
	"availability_list" => "/GestioneDisponibilitaAction.do?codop=getDisponibilitaCittadino",
	"calendar_list" => "/GestioneCalendarioCittadinoAction.do?codop=mostraCalendario&amp;idRegista=358&amp;data=05-04-2019"
];

?>