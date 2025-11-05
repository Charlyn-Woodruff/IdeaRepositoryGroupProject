<?php

function connectToDatabase(): mysqli {
    // Database connection code created by Sean on 10-21-24
    // Simplified on 11-2-24 SL
    $serverName = "maria";
    $username = "splauritzen";
    $password = "ream-heat-dunning";
    $dbName = "idea_repository";
    
    return new mysqli($serverName, $username, $password, $dbName);
}