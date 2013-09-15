<?php

// call from browser as:  http://whereever.com/gitswitch.php?branch=test1&redirect=http://dev.mysite.com 


include_once('GitSwitcher.php');


$new_branch = $_GET['branch'];
$redirect	= $_GET['redirect'];

// set your absolute path to repo
$config['git_path'] = '/var/www/dev'; 	

//you can set the site url here & not have to include it in the one you send to client
$config['redirect'] = (empty($redirect))? '' : $redirect; 	


$gitswitcher = new GitSwitcher($config);

$gitswitcher->main($new_branch);
