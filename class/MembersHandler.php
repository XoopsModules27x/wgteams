<?php

namespace XoopsModules\Wgteams;

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

use XoopsModules\Wgteams;

\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class MembersHandler
 */
class MembersHandler extends \XoopsPersistableObjectHandler
{
    /**
     * @var mixed
     */
    private $helper = null;

    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgteams_members', Members::class, 'member_id', 'member_firstname');
        /** @var \XoopsModules\Wgteams\Helper $this ->helper */
        $this->helper = \XoopsModules\Wgteams\Helper::getInstance();
    }

    /**
     * @param bool $isNew
     *
     * @return \XoopsObject
     */
    public function create($isNew = true): \XoopsObject
    {
        return parent::create($isNew);
    }

    /**
     * retrieve a field
     *
     * @param  int $id field id
     * @param  $fields
     * @return \XoopsObject
     */
    public function get($id = null, $fields = null): \XoopsObject
    {
        return parent::get($id, $fields);
    }

    /**
     * get inserted id
     *
     *
     * @return int reference to the {@link TDMCreateFields} object
     */
    public function getInsertId(): int
    {
        return $this->db->getInsertId();
    }

    /**
     * get IDs of objects matching a condition
     *
     * @param \CriteriaElement|null $criteria {@link CriteriaElement}
     *                                   to match
     * @return array  of object IDs
     */
    public function &getIds(?\CriteriaElement $criteria = null): array
    {
        $temp = &parent::getIds($criteria);

        return $temp;
    }

    /**
     * insert a new field in the database
     *
     * @param \XoopsObject $object reference to the {@link TDMCreateFields}
     *                            object
     * @param bool         $force
     *
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(\XoopsObject $object, $force = false): bool
    {
        if (!parent::insert($object, $force)) {
            return false;
        }

        return true;
    }

    /**
     * Get Count members
     * @param int $start
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountMembers(int $start = 0, int $limit = 0, string $sort = 'member_id ASC, member_firstname', string $order = 'ASC'): int
    {
        $criteria = new \CriteriaCompo();
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        return $this->getCount($criteria);
    }

    /**
     * Get All members
     * @param int $start
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllMembers(int $start = 0, int $limit = 0, string $sort = 'member_id ASC, member_firstname', string $order = 'ASC'): array
    {
        $criteria = new \CriteriaCompo();
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        return $this->getAll($criteria);
    }
}
