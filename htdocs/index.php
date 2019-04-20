<?php

// Path
define('AOUF_BASE','./');
if (!file_exists( AOUF_BASE . '../conf/connect.php'))
{
    exit('<p style="text-align: center; margin-top: 15%; ">La configuration de connexion semble incorrecte.</p>');
}
require_once AOUF_BASE . '../conf/connect.php';
//require_once AOUF_BASE . '../conf/global.php';

// Session
session_name('AOUF_SESS');
session_start();

// Get URI request
$uri = $_SERVER['REQUEST_URI'];

if ((!preg_match('#^/$#', $uri))&&(!preg_match('#^/register#', $uri))&&(!preg_match('#^/auth#', $uri))) {
    if (!isset($_SESSION['user_id']))
    header("Location: /");
}

if (preg_match('#^/$#', $uri)) {
    include( AOUF_BASE . '../tpl/index.php');
} elseif (preg_match('#^/auth#', $uri)) {
    include( AOUF_BASE . '../tpl/auth.php');
} elseif (preg_match('#^/accueil#', $uri)) {
    include( AOUF_BASE . '../tpl/accueil.php');
} elseif (preg_match('#^/offer/new#', $uri)) {
    include( AOUF_BASE . '../tpl/offer_new.php');
} elseif (preg_match('#^/offer/list#', $uri)) {
    include( AOUF_BASE . '../tpl/offer_list.php');
} elseif (preg_match('#^/offer/mylist#', $uri)) {
    include( AOUF_BASE . '../tpl/offer_mylist.php');
} elseif (preg_match('#^/register#', $uri)) {
    include( AOUF_BASE . '../tpl/register.php');
} elseif (preg_match('#^/message/list#', $uri)) {
    include( AOUF_BASE . '../tpl/message_list.php');
} elseif (preg_match('#^/message/write#', $uri)) {
    include( AOUF_BASE . '../tpl/message_write.php');
} elseif (preg_match('#^/parametres#', $uri)) {
    include( AOUF_BASE . '../tpl/parametres.php');
} elseif (preg_match('#^/admin/register#', $uri)) {
    include( AOUF_BASE . '../tpl/admin_register.php');
} elseif (preg_match('#^/admin/moderation#', $uri)) {
    include( AOUF_BASE . '../tpl/admin_moderation.php');
} else {
    echo '404: NOT FOUND';
}

?>
