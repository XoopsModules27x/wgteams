<?php

namespace XoopsModules\Wgteams;

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package      wgteams
 * @author       Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 */

//\defined('XOOPS_ROOT_PATH') || die('Restricted access';

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * class Constants
 */
class Constants
{
    /**#@+
     * Constant definition
     */

    // common constants
    // constants for image class
    const int IMAGECLASS_MEMBER = 1;
    const int IMAGECLASS_TEAM   = 2;

    // constants for details
    const int USEDETAILS_NONE  = 0;
    const int USEDETAILS_TAB   = 1;
    const int USEDETAILS_MODAL = 2;
    const int CLASS_DEFAULT    = 0;
    const int CLASS_INDEX      = 1;
    const int CLASS_TEAM       = 2;
    const int CLASS_DETAILS    = 3;

}
