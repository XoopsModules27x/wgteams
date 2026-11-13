<?php
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
 * @copyright module for xoops
 * @license   GPL 2.0 or later
 * @package         wgteams
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 */
 
$moduleDirName = \basename(\dirname(__DIR__, 2));
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

// General
\define('_CO_WGTEAMS_CONFIRM', 'Confirm');
//Sample Data
\define('_CO_WGTEAMS_ADD_SAMPLEDATA', 'Import Sample Data (will delete ALL current data)');
\define('_CO_WGTEAMS_SAMPLEDATA_SUCCESS', 'Sample Date uploaded successfully');
\define('_CO_WGTEAMS_SAVE_SAMPLEDATA', 'Export Tables to YAML');
\define('_CO_WGTEAMS_SAVE_SAMPLEDATA_SUCCESS', 'Export Tables to YAML successfully');
\define('_CO_WGTEAMS_SHOW_SAMPLE_BUTTON', 'Show Sample Button?');
\define('_CO_WGTEAMS_SHOW_SAMPLE_BUTTON_DESC', 'If yes, the "Add Sample Data" button will be visible to the Admin. It is Yes as a default for first installation.');
\define('_CO_WGTEAMS_EXPORT_SCHEMA', 'Export DB Schema to YAML');
\define('_CO_WGTEAMS_EXPORT_SCHEMA_SUCCESS', 'Export DB Schema to YAML was a success');
\define('_CO_WGTEAMS_EXPORT_SCHEMA_ERROR', 'ERROR: Export of DB Schema to YAML failed');
\define('_CO_WGTEAMS_ADD_SAMPLEDATA_OK', 'Are you sure to Import Sample Data? (It will delete ALL current data)');
\define('_CO_WGTEAMS_HIDE_SAMPLEDATA_BUTTONS', 'Hide the Import buttons)');
\define('_CO_WGTEAMS_SHOW_SAMPLEDATA_BUTTONS', 'Show the Import buttons)');

//Menu
\define('_CO_WGTEAMS_ADMENU_MIGRATE', 'Migrate');
\define('_CO_WGTEAMS_FOLDER_YES', 'Folder "%s" exist');
\define('_CO_WGTEAMS_FOLDER_NO', 'Folder "%s" does not exist. Create the specified folder with CHMOD 777.');
\define('_CO_WGTEAMS_SHOW_DEV_TOOLS', 'Show Development Tools Button?');
\define('_CO_WGTEAMS_SHOW_DEV_TOOLS_DESC', 'If yes, the "Migrate" Tab and other Development tools will be visible to the Admin.');

//Latest Version Check
\define('_CO_WGTEAMS_NEW_VERSION', 'New Version: ');
\define('_CO_WGTEAMS_ERROR_BAD_XOOPS', 'Minimum XOOPS required: %s (your version is %s)');

// Admin link
\define('_CO_WGTEAMS_ADMIN', 'Admin');
