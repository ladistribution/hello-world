<?php

class Ld_Installer_HelloWorld extends Ld_Installer
{

	/* Install */

	public function postInstall($preferences = array())
	{
		// if (isset($preferences['administrator'])) {
		// 	$username = $preferences['administrator']['username'];
		// 	$this->setUserRoles(array($username => 'administrator'));
		// }

		$this->handleRewrite();
	}

	public function postMove()
	{
		$this->handleRewrite();
	}

	/* Update */

	public function postUpdate()
	{
		$this->handleRewrite();

		Ld_Files::denyAccess($this->getAbsolutePath() . '/views', true);
	}

	/* Uninstall */

	public function postUninstall()
	{
		if (defined('LD_NGINX') && constant('LD_NGINX')) {
			$nginxDir = $this->getSite()->getDirectory('dist') . '/nginx';
			Ld_Files::rm($nginxDir . "/" . $this->getInstance()->getId() . ".conf");
		}
	}

	/* Roles */

	// public $roles = array('administrator', 'visitor');

	// public $defaultRole = 'visitor';

	/* App Management */

	public function setConfiguration($configuration)
	{
		$configuration = array_merge($this->getConfiguration(), $configuration);
		return parent::setConfiguration($configuration);
	}

	/* Install Utilities */

	public function handleRewrite()
	{
	    $path = $this->getSite()->getPath() . '/' . $this->getPath() . '/';
		if (defined('LD_REWRITE') && constant('LD_REWRITE')) {
			$htaccess  = "RewriteEngine on\n";
			$htaccess .= "RewriteBase $path\n";
			$htaccess .= "RewriteCond %{REQUEST_FILENAME} !-f\n";
			$htaccess .= "RewriteCond %{REQUEST_FILENAME} !-d\n";
			$htaccess .= "RewriteRule ^(.*)$ index.php?/$1 [QSA,L]\n";
			Ld_Files::put($this->getAbsolutePath() . "/.htaccess", $htaccess);
		}
		if (defined('LD_NGINX') && constant('LD_NGINX')) {
			$nginxConf  = 'location {PATH} {' . "\n";
			$nginxConf .= '  if (!-e $request_filename) {' . "\n";
			$nginxConf .= '   rewrite ^{PATH}(.*)$  {PATH}index.php?uri=$1 last;' . "\n";
			$nginxConf .= '  }' . "\n";
			$nginxConf .= '}' . "\n";
			$nginxConf = str_replace('{PATH}', $path, $nginxConf);
			$nginxDir = $this->getSite()->getDirectory('dist') . '/nginx';
			Ld_Files::ensureDirExists($nginxDir);
			Ld_Files::put($nginxDir . "/" . $this->getInstance()->getId() . ".conf", $nginxConf);
		}
	}

}
