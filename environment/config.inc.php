<?php

const BASE_URL = "https://www.passaportonline.poliziadistato.it";
const ENDPOINT = [
	"login" => "/LogInAction.do?codop=logCittadino",
	"dashboard" => "/indexCittadino.jsp",
	"province_search" => "/CittadinoAction.do?codop=resultRicercaRegistiProvincia",
	"availability_list" => "/GestioneDisponibilitaAction.do?codop=getDisponibilitaCittadino"
];

?>