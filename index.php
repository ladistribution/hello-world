<?php

require_once dirname(__FILE__) . '/dist/prepend.php';

require_once 'limonade.php';

function configure()
{
    global $site, $application;
    option('base_uri',      $site->getPath() . '/' . $application->getPath() );
    option('views_dir',     $application->getAbsolutePath() . '/views' );
    option('session',       false);
}

function before()
{
    global $site, $application, $configuration;
    set('site', $site);
    set('application', $application);
    set('configuration', $configuration);
    if (defined('LD_BOOTSTRAP_CSS') && constant('LD_BOOTSTRAP_CSS')) {
        layout('layout-bootstrap.html.php');
    } else {
        layout('layout.html.php');
    }
}

function isAdmin()
{
    // global $application;
    // return Ld_Auth::isAuthenticated() && $application->getUserRole() == 'administrator';
    global $site;
    $role = $site->getAdmin()->getUserRole();
    return $role == 'admin';
}

function out($text)
{
    echo htmlspecialchars($text);
}

function sendError($error)
{
    set('error', $error);
    return html("error.html.php");
}

dispatch('/', 'index');

function index()
{
    return html('index.html.php');
}

run();
