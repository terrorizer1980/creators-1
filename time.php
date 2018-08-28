<?php
$datetime1 = new DateTime('8/1/2018 7:23');
$datetime2 = new DateTime('8/3/2018 6:02');
$interval = $datetime1->diff($datetime2);
echo $interval->format('%d')*(24)+$interval->format('%h')." Hours ".$interval->format('%i')." Minutes";