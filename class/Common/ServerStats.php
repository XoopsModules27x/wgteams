<?php declare(strict_types=1);

namespace XoopsModules\Wgteams\Common;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * @copyright   XOOPS Project (https://xoops.org)
 * @license     https://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      mamba <mambax7@gmail.com>
 */
trait ServerStats
{
    /**
     * serverStats()
     *
     * @return string
     */
    public static function getServerStats(): string
    {
        $moduleDirName      = \basename(\dirname(__DIR__, 2));
        \xoops_loadLanguage('common', $moduleDirName);
        $html = '';
        //        $sql   = 'SELECT metavalue';
        //        $sql   .= ' FROM ' . $GLOBALS['xoopsDB']->prefix('wfdownloads_meta');
        //        $sql   .= " WHERE metakey='version' LIMIT 1";
        //        $query = $GLOBALS['xoopsDB']->query($sql);
        //        list($meta) = $GLOBALS['xoopsDB']->fetchRow($query);
        $html .= '<fieldset>';
        $html .= "<legend style='font-weight: bold; color: #900;'>" . \_CO_WGTEAMS_IMAGEINFO . '</legend>';
        $html .= "<div style='padding: 8px;'>";
        //        $html .= '<div>' . \_CO_WGTEAMS_METAVERSION . $meta . "</div>";
        //        $html .= "<br>";
        //        $html .= "<br>";
        $html .= '<div>' . \_CO_WGTEAMS_SPHPINI . '</div>';
        $html .= '<ul>';

        $gdlib = \function_exists('gd_info') ? '<span style="color: #008000;">' . \_CO_WGTEAMS_GDON . '</span>' : '<span style="color: #ff0000;">' . \_CO_WGTEAMS_GDOFF . '</span>';
        $html  .= '<li>' . \_CO_WGTEAMS_GDLIBSTATUS . $gdlib;
        if (\function_exists('gd_info')) {
            if (true === ($gdlib = gd_info())) {
                $html .= '<li>' . \_CO_WGTEAMS_GDLIBVERSION . '<b>' . $gdlib['GD Version'] . '</b>';
            }
        }

        //    $safemode = \ini_get('safe_mode') ? \_CO_WGTEAMS_ON . \_CO_WGTEAMS_SAFEMODEPROBLEMS : \_CO_WGTEAMS_OFF;
        //    $html .= '<li>' . \_CO_WGTEAMS_SAFEMODESTATUS . $safemode;

        //    $registerglobals = (!\ini_get('register_globals')) ? "<span style=\"color: #008000;\">" . \_CO_WGTEAMS_OFF . '</span>' : "<span style=\"color: #ff0000;\">" . \_CO_WGTEAMS_ON') . '</span>';
        //    $html .= '<li>' . \_CO_WGTEAMS_REGISTERGLOBALS . $registerglobals;

        $downloads = \ini_get('file_uploads') ? '<span style="color: #008000;">' . \_CO_WGTEAMS_ON . '</span>' : '<span style="color: #ff0000;">' . \_CO_WGTEAMS_OFF . '</span>';
        $html      .= '<li>' . \_CO_WGTEAMS_SERVERUPLOADSTATUS . $downloads;

        $html .= '<li>' . \_CO_WGTEAMS_MAXUPLOADSIZE . ' <b><span style="color: #0000ff;">' . \ini_get('upload_max_filesize') . '</span></b>';
        $html .= '<li>' . \_CO_WGTEAMS_MAXPOSTSIZE . ' <b><span style="color: #0000ff;">' . \ini_get('post_max_size') . '</span></b>';
        $html .= '<li>' . \_CO_WGTEAMS_MEMORYLIMIT . ' <b><span style="color: #0000ff;">' . \ini_get('memory_limit') . '</span></b>';
        $html .= '</ul>';
        $html .= '<ul>';
        $html .= '<li>' . \_CO_WGTEAMS_SERVERPATH . ' <b>' . \XOOPS_ROOT_PATH . '</b>';
        $html .= '</ul>';
        $html .= '<br>';
        $html .= \_CO_WGTEAMS_UPLOADPATHDSC . '';
        $html .= '</div>';
        $html .= '</fieldset><br>';

        return $html;
    }
}
