<?php

declare(strict_types=1);
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * wgTeams module for xoops
 *
 * @copyright       The XOOPS Project (https://xoops.org)
 * @license         GPL 2.0 or later
 * @package         wgteams
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 */

use Xmf\Yaml;
use XoopsModules\Wgteams\{
    Helper,
    TeamsHandler,
    MembersHandler,
    RelationsHandler,
    InfofieldsHandler
};

require __DIR__ . '/header.php';

$moduleDirName      = \basename(\dirname(__DIR__));
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

// Count elements
$countTeams      = $teamsHandler->getCountTeams();
$countMembers    = $membersHandler->getCountMembers();
$countInfofields = $infofieldsHandler->getCountInfofields();
$countRelations  = $relationsHandler->getCountRelations();
// Template Index
$templateMain = 'wgteams_admin_index.tpl';
// InfoBox Statistics
$adminObject->addInfoBox(_AM_WGTEAMS_STATISTICS);
// Info elements
$adminObject->addInfoBoxLine(\sprintf('<label>' . _AM_WGTEAMS_THEREARE_TEAMS . '</label>', $countTeams), '');
$adminObject->addInfoBoxLine(\sprintf('<label>' . _AM_WGTEAMS_THEREARE_MEMBERS . '</label>', $countMembers), '');
$adminObject->addInfoBoxLine(\sprintf('<label>' . _AM_WGTEAMS_THEREARE_INFOFIELDS . '</label>', $countInfofields), '');
$adminObject->addInfoBoxLine(\sprintf('<label>' . _AM_WGTEAMS_THEREARE_RELATIONS . '</label>', $countRelations), '');
// Upload Folders
$folder = [
    \WGTEAMS_UPLOAD_PATH . '/teams/',
    \WGTEAMS_UPLOAD_PATH . '/teams/images/',
    \WGTEAMS_UPLOAD_PATH . '/members/',
    \WGTEAMS_UPLOAD_PATH . '/members/images/',
    \WGTEAMS_UPLOAD_PATH . '/temp/',
];
// Uploads Folders Created
foreach (\array_keys($folder) as $i) {
    $adminObject->addConfigBoxLine($folder[$i], 'folder');
    $adminObject->addConfigBoxLine([$folder[$i], '777'], 'chmod');
}
// Render Navigation
$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->renderNavigation('index.php'));
//------------- Test Data ----------------------------

if ($helper->getConfig('displaySampleButton')) {
    $yamlFile            = \dirname(__DIR__) . '/config/admin.yml';
    $config              = loadAdminConfig($yamlFile);
    $displaySampleButton = $config['displaySampleButton'];

    if (1 == $displaySampleButton) {
        \xoops_loadLanguage('admin/modulesadmin', 'system');
        require \dirname(__DIR__) . '/testdata/index.php';
        $adminObject->addItemButton(\_CO_WGTIMELINES_LOAD_SAMPLEDATA, '__DIR__ . /../../testdata/index.php?op=load');
        $adminObject->addItemButton(\_CO_WGTIMELINES_SAVE_SAMPLEDATA, '__DIR__ . /../../testdata/index.php?op=save');
        //    $adminObject->addItemButton(\_CO_WGTIMELINES_EXPORT_SCHEMA, '__DIR__ . /../../testdata/index.php?op=exportschema', 'add');
        $adminObject->addItemButton(\_CO_WGTEAMS_HIDE_SAMPLEDATA_BUTTONS, '?op=hide_buttons', 'delete');
    }
    $adminObject->renderButton('left', '');
}
//------------- End Test Data ----------------------------

// Render index
$GLOBALS['xoopsTpl']->assign('index', $adminObject->renderIndex());

require __DIR__ . '/footer.php';
