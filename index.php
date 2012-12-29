<?php
    error_reporting(2047);
    require_once("libraries/espn/espn.nfl.php");
    $espn = new ESPNNFL('tswvuu67e3rzkaynrut82mvf');
    $players = $espn->getPlayers();
?>