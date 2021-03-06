<?php

/**
 * @file AdminHandler.inc.php
 *
 * Copyright (c) 2000-2012 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class AdminHandler
 * @ingroup pages_admin
 * @see AdminLanguagesHandler, AdminSettingsHandler
 *
 * @brief Handle requests for site administration functions. 
 */



import('classes.handler.Handler');

class AdminHandler extends Handler {
	/**
	 * Constructor
	 **/
	function AdminHandler() {
		parent::Handler();

		$this->addCheck(new HandlerValidatorRoles($this, true, null, null, array(ROLE_ID_SITE_ADMIN)));
		$this->addCheck(new HandlerValidatorCustom($this, true, null, null, create_function(null, 'return Request::getRequestedConferencePath() == \'index\';')));
	}

	/**
	 * Display site admin index page.
	 */
	function index($args, &$request) {
		$this->validate();
		$this->setupTemplate($request);

		$templateMgr =& TemplateManager::getManager();

		// Display a warning message if there is a new version of OJS available
		$newVersionAvailable = false;
		if (Config::getVar('general', 'show_upgrade_warning')) {
			import('lib.pkp.classes.site.VersionCheck');
			if($latestVersion = VersionCheck::checkIfNewVersionExists()) {
				$newVersionAvailable = true;
				$templateMgr->assign('latestVersion', $latestVersion);
				$currentVersion =& VersionCheck::getCurrentDBVersion();
				$templateMgr->assign('currentVersion', $currentVersion->getVersionString());
			}
		}

		$templateMgr->assign('newVersionAvailable', $newVersionAvailable);
		$templateMgr->assign('helpTopicId', 'site.index');
		$templateMgr->display('admin/index.tpl');
	}

	/**
	 * Setup common template variables.
	 * @param $request PKPRequest
	 * @param $subclass boolean set to true if caller is below this handler in the hierarchy
	 */
	function setupTemplate($request, $subclass = false) {
		parent::setupTemplate($request);
		AppLocale::requireComponents(LOCALE_COMPONENT_PKP_ADMIN, LOCALE_COMPONENT_APP_ADMIN, LOCALE_COMPONENT_APP_MANAGER);
		$templateMgr =& TemplateManager::getManager();
		$templateMgr->assign('pageHierarchy',
			$subclass ? array(array($request->url(null, null, 'user'), 'navigation.user'), array($request->url(null, null, ROLE_PATH_SITE_ADMIN), 'admin.siteAdmin'))
				: array(array($request->url(null, null, 'user'), 'navigation.user'))
		);
	}
}

?>
