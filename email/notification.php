<?php

/**
* Email template
*/

ob_start();

?>
<p>E' possibile prenotare un appuntamento sei seguenti uffici, nelle corrispettive date:</p>
<ul>
	
<?php
foreach ($availabilities as $index => $availability) {
?>
	<li><?=$availability['office']['name']?> (<?=$availability['office']['address']?>) - <?=$availability['date']?> (<?=$availability['availability']?> disponibilità)</li>	
</ul>

<p>Effettua subito il login <a href="<?=BASE_URL?>">cliccando qui</a></p>

<?php
}

$output = ob_get_contents();

ob_end_clean();

return $output;
?>