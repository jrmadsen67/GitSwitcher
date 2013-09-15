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

<h3>Extending</h3>

The function main() is included as a basic, most likely use case function. You can, of course, extend the class or just copy the functions into your controller. All functions are exposed; exec_command() is used if you need to send more commands to, for example, run a shell script

I thought briefly about adding hooks, but figured that was overkill fo rsuch a simple class. Open to feedback on that, however.

It will quickly become obvious that I'm not any sort of Linux sysadmin - feedback on how I should structure commands or capture stdErr is also welcome.

Obviously, this is meant for very small teams. We are working on an "Admin" version that may handle the issues around a using it for a larger group.