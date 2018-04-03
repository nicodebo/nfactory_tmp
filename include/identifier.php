<?php

// Permet de savoir si on est sur Mac ou sur Windows. Seulement utile pour notre
// travail de group. A ne pas utiliser sinon.
$user_agent = getenv("HTTP_USER_AGENT");

if(strpos($user_agent, "Win") !== FALSE) {
    $os = "Windows";
} elseif(strpos($user_agent, "Mac") !== FALSE) {
    $os = "Mac";
}
