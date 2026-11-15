<?php
/**
 * @copyright   XOOPS Project (https://xoops.org)
 * @license     GPL-2.0-or-later (https://www.gnu.org/licenses/gpl-2.0.html)
 */

namespace XoopsModules\Wgteams;

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Class Utility
 */
class Utility
{
    use Common\VersionChecks; //checkVerXoops, checkVerPhp Traits

    use Common\ServerStats; // getServerStats Trait

    use Common\FilesManagement; // Files Management Trait

    //--------------- Custom module methods -----------------------------
}
