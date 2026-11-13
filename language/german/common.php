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
\define('_CO_WGTEAMS_CONFIRM', 'Bestätigen');
//Sample Data
\define('_CO_WGTEAMS_ADD_SAMPLEDATA', 'Importe Beispieldaten (ALLE vorhandenen Daten werden gelöscht)');
\define('_CO_WGTEAMS_SAMPLEDATA_SUCCESS', 'Beispieldaten erfolgreich geladen');
\define('_CO_WGTEAMS_SAVE_SAMPLEDATA', 'Exportiere Tabellen nach YAML');
\define('_CO_WGTEAMS_SAVE_SAMPLEDATA_SUCCESS', 'Tabellen-Export nach YAML erfolgreich');
\define('_CO_WGTEAMS_SHOW_SAMPLE_BUTTON', 'Schaltfläche Import Beispieldaten anzeigen?');
\define('_CO_WGTEAMS_SHOW_SAMPLE_BUTTON_DESC', 'Falls Ja, dann wird die Schaltfläche "Importe Beispieldaten" im Adminbereich sichtbar. Diese Option ist nach der Installation standardmäßig aktiviert.');
\define('_CO_WGTEAMS_EXPORT_SCHEMA', 'Exportiere DB Schema nach YAML');
\define('_CO_WGTEAMS_EXPORT_SCHEMA_SUCCESS', 'Export DB Schema nach YAML erfolgreich abgeschlossen');
\define('_CO_WGTEAMS_EXPORT_SCHEMA_ERROR', 'Fehler: Export DB Schema nach YAML fehlgeschlagen');
\define('_CO_WGTEAMS_ADD_SAMPLEDATA_OK', 'Sind Sie sicher, Beispieldaten zu importieren? (ALLE vorhandenen Daten werden gelöscht)');
\define('_CO_WGTEAMS_HIDE_SAMPLEDATA_BUTTONS', 'Hide the Import buttons)');
\define('_CO_WGTEAMS_SHOW_SAMPLEDATA_BUTTONS', 'Show the Import buttons)');

//Menu
\define('_CO_WGTEAMS_ADMENU_MIGRATE', 'Migrate');
\define('_CO_WGTEAMS_FOLDER_YES', 'Folder "%s" exist');
\define('_CO_WGTEAMS_FOLDER_NO', 'Folder "%s" does not exist. Create the specified folder with CHMOD 777.');
\define('_CO_WGTEAMS_SHOW_DEV_TOOLS', 'Show Development Tools Button?');
\define('_CO_WGTEAMS_SHOW_DEV_TOOLS_DESC', 'If yes, the "Migrate" Tab and other Development tools will be visible to the Admin.');

//Latest Version Check
\define('_CO_WGTEAMS_NEW_VERSION', 'Neue Version: ');
\define('_CO_WGTEAMS_ERROR_BAD_XOOPS', 'Sie benötigen mindestens Version %s (Ihre derzeitige Version ist %s)');

// Admin link
\define('_CO_WGTEAMS_ADMIN', 'Admininistration');
