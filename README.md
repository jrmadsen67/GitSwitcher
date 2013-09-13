GitSwitcher Light
=================

Working remotely, with designer in one timezone and client in another?

GitSwitcher "Light" is a simple library designed to allow users to switch git branches via url for feedback &amp; testing. It is perfect for developers working remotely on multiple branches to create links "to a branch" for their non-technical clients or manager to review work while they are not available. Setup is simply & requires very little configuration.

<h3>Configuration:</h3>


Set your absolute path to the repo:

$config['git_path'] = '/var/www/dev'; 

You can set the site url here & not have to include it in the one you send to client
Just put the url in the first slot 

$config['redirect'] = (empty($redirect))? 'http://dev.mysite.com' : $redirect; 	

That's it! Now, when you do some work on on a branch, send them the link:

http://myserver/gitswitch.php?branch=<branch_name><&redirect=http://dev.mysite.com> 

When the user clicks on the link, the correct branch will be checked out and then they will be sent to the site


Obviously, this is meant for very small teams. We are working on an "Admin" version that may handle the issues around a using it for a larger group.