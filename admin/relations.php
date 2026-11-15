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

use Xmf\Request;
use XoopsModules\Wgteams\Common;

require_once __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op     = Request::getString('op', 'list');
$relId  = Request::getInt('rel_id');
$teamId = Request::getInt('team_id');
$sortby = Request::getString('sortby', 'rel_weight');
$order  = Request::getString('order', 'asc');
$start  = Request::getInt('start');
$limit  = Request::getInt('limit', $helper->getConfig('adminpager'));

$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);

// Switch options
switch ($op) {
    case 'list':
    default:
        $GLOBALS['xoopsTpl']->assign('wgteams_form_token', $GLOBALS['xoopsSecurity']->getTokenHTML());
        $GLOBALS['xoopsTpl']->assign('wgteams_btn_token', $GLOBALS['xoopsSecurity']->createToken());

        $templateMain = 'wgteams_admin_relations.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->renderNavigation('relations.php'));
        $adminObject->addItemButton(_AM_WGTEAMS_RELATION_ADD, 'relations.php?op=new&team_id=' . $teamId);
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton('left', ''));
        if (0 === $teamId) {
            $teamsCount = $teamsHandler->getCountTeams();
            if (1 === $teamsCount) {
                // if only one team is available, then immediately preselect this team
                $teamsAll = $teamsHandler->getAllTeams();
                foreach (\array_keys($teamsAll) as $i) {
                    $teamId = $teamsAll[$i]->getVar('team_id');
                }
            }
        }
        $form = getFormFilterTeam($teamId, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        $crRelations = new \CriteriaCompo();
        $relationsCountTotal = $relationsHandler->getCount($crRelations);
        $crRelations->add(new \Criteria('rel_team_id', $teamId));  
        $relationsCount = $relationsHandler->getCount($crRelations);
        $crRelations->setSort($sortby);
        $crRelations->setOrder($order);
        $crRelations->setStart($start);
        $crRelations->setLimit($limit);
        $relationsAll   = $relationsHandler->getAll($crRelations);
        $GLOBALS['xoopsTpl']->assign('relations_count', $relationsCount);
        $GLOBALS['xoopsTpl']->assign('wgteams_url', \WGTEAMS_URL);
        $GLOBALS['xoopsTpl']->assign('wgteams_upload_url', \WGTEAMS_UPLOAD_URL);
        $GLOBALS['xoopsTpl']->assign('wgteams_icons_url', \WGTEAMS_ICONS_URL);

        // Table view
        if ($relationsCount > 0) {
            $team_id_prev = 0;
            $nb_rels_team = 0;
            foreach (\array_keys($relationsAll) as $i) {
                $relation = $relationsAll[$i]->getValuesRelations();
                if ($team_id_prev == $relation['team_id']) {
                    $relation['new_team']     = 0;
                    $relation['nb_rels_team'] = $nb_rels_team;
                } else {
                    $relation['new_team']     = 1;
                    $nb_rels_team             = $relationsHandler->getCountRelationsTeam($relation['team_id']);
                    $relation['nb_rels_team'] = $nb_rels_team;
                    $team_id_prev             = $relation['team_id'];
                }
                $GLOBALS['xoopsTpl']->append('relations_list', $relation);
                unset($relation);
            }
            if ($relationsCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($relationsCount, $limit, $start, 'start', 'op=list&limit=' . $limit . '&team_id=' . $teamId);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        }
        break;
    case 'new':
        $templateMain = 'wgteams_admin_relations.tpl';
        $adminObject->addItemButton(_AM_WGTEAMS_RELATIONS_LIST, 'relations.php', 'list');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->renderNavigation('relations.php'));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton('left', ''));
        // Get Form
        $relationsObj = $relationsHandler->create();
        $relationsObj->setVar('rel_team_id', $teamId);
        $form         = $relationsObj->getFormRelations();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('relations.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($relId)) {
            $relationsObj = $relationsHandler->get($relId);
            if (!\is_object($relationsObj)) {
                \redirect_header('relations.php', 3, \_AM_WGTEAMS_INVALID_PARAM);
            }
        } else {
            $relationsObj = $relationsHandler->create();
        }
        // Set Vars
        $relTeamId = Request::getInt('rel_team_id');
        $relationsObj->setVar('rel_team_id', $relTeamId);
        $relationsObj->setVar('rel_member_id', Request::getInt('rel_member_id'));
        $relationsObj->setVar('rel_info_1_field', Request::getInt('rel_info_1_field'));
        $relationsObj->setVar('rel_info_1_class', Request::getInt('rel_info_1_class'));
        $relationsObj->setVar('rel_info_1', Request::getString('rel_info_1'));
        $relationsObj->setVar('rel_info_2_field', Request::getInt('rel_info_2_field'));
        $relationsObj->setVar('rel_info_2_class', Request::getInt('rel_info_2_class'));
        $relationsObj->setVar('rel_info_2', Request::getString('rel_info_2'));
        $relationsObj->setVar('rel_info_3_field', Request::getInt('rel_info_3_field'));
        $relationsObj->setVar('rel_info_3_class', Request::getInt('rel_info_3_class'));
        $relationsObj->setVar('rel_info_3', Request::getString('rel_info_3'));
        $relationsObj->setVar('rel_info_4_field', Request::getInt('rel_info_4_field'));
        $relationsObj->setVar('rel_info_4_class', Request::getInt('rel_info_4_class'));
        $relationsObj->setVar('rel_info_4', Request::getString('rel_info_4'));
        $relationsObj->setVar('rel_info_5_field', Request::getInt('rel_info_5_field'));
        $relationsObj->setVar('rel_info_5_class', Request::getInt('rel_info_5_class'));
        $relationsObj->setVar('rel_info_5', Request::getString('rel_info_5'));
        $relWeight = Request::getInt('rel_weight');
        if (0 === $relWeight) {
            $crRelations = new \CriteriaCompo();
            $crRelations->add(new \Criteria('rel_team_id', $relTeamId));
            $relCount = $relationsHandler->getCount($crRelations);
            if ($relCount > 0) {
                $relWeight =  $relCount + 1;
            } else  {
                $relWeight = 1;
            }
        }
        $relationsObj->setVar('rel_weight', $relWeight);
        $relationsObj->setVar('rel_submitter', Request::getInt('rel_submitter'));
        $relationsObj->setVar('rel_date_create', \time());
        // Insert Data
        if ($relationsHandler->insert($relationsObj)) {
            \redirect_header('relations.php?op=list&team_id=' . $relTeamId, 2, _AM_WGTEAMS_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $relationsObj->getHtmlErrors());
        $form = $relationsObj->getFormRelations();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgteams_admin_relations.tpl';
        $adminObject->addItemButton(_AM_WGTEAMS_RELATION_ADD, 'relations.php?op=new');
        $adminObject->addItemButton(_AM_WGTEAMS_RELATIONS_LIST, 'relations.php', 'list');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->renderNavigation('relations.php'));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton('left', ''));
        // Get Form
        $relationsObj = $relationsHandler->get($relId);
        if (!\is_object($relationsObj)) {
            \redirect_header('relations.php', 3, \_AM_WGTEAMS_INVALID_PARAM);
        }
        $form         = $relationsObj->getFormRelations();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $relationsObj = $relationsHandler->get($relId);
        $teamId = $relationsObj->getVar('rel_team_id');
        $teamObj = $teamsHandler->get($teamId);
        $memberObj = $membersHandler->get($relationsObj->getVar('rel_member_id'));
        if (!\is_object($relationsObj) || !\is_object($teamObj) || !\is_object($memberObj)) {
            \redirect_header('relations.php', 3, \_AM_WGTEAMS_INVALID_PARAM);
        }
        $templateMain = 'wgteams_admin_relations.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->renderNavigation('relations.php'));
        if (1 == Request::getInt('ok')) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('relations.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($relationsHandler->delete($relationsObj)) {
                \redirect_header("relations.php?op=list&team_id=$teamId&start=$start&limit=$limit", 3, _AM_WGTEAMS_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $relationsObj->getHtmlErrors());
            }
        } else {
            $confirmText = \str_replace('%n', $memberObj->getVar('member_firstname') . ' ' . $memberObj->getVar('member_lastname'), _AM_WGTEAMS_RELATION_DELETE);
            $confirmText = \str_replace('%t', $teamObj->getVar('team_name'), $confirmText);
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'rel_id' => $relId, 'team_id' => $teamId, 'start' => $start, 'limit' => $limit, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'], $confirmText);
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
    case 'order':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('relations.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $rorder = Request::getArray('rorder');
        for ($i = 0, $iMax = \count($rorder); $i < $iMax; $i++) {
            $relationsObj = $relationsHandler->get($rorder[$i]);
            if (!\is_object($relationsObj)) {
                \redirect_header('relations.php', 3, \_AM_WGTEAMS_INVALID_PARAM);
            }
            $relationsObj->setVar('rel_weight', $start + $i + 1);
            $relationsHandler->insert($relationsObj);
        }
        $GLOBALS['xoopsTpl']->assign('wgteams_form_token', $GLOBALS['xoopsSecurity']->getTokenHTML());
        $GLOBALS['xoopsTpl']->assign('wgteams_btn_token', $GLOBALS['xoopsSecurity']->createToken());
        break;
}

require_once __DIR__ . '/footer.php';

/**
 * @function getFormFilterTeam:
 * provide form with a dropdown select containing all existing teams
 * @param int $teamId
 * @param int $start
 * @param int $limit
 * @param bool $action
 * @return \XoopsThemeForm
 * @throws Exception
 */
function getFormFilterTeam(int $teamId, int $start, int $limit, bool $action = false): XoopsThemeForm
{
    $helper = \XoopsModules\Wgteams\Helper::getInstance();
    if (!$action) {
        $action = $_SERVER['REQUEST_URI'];
    }
    // Get Theme Form
    \xoops_load('XoopsFormLoader');
    $form = new \XoopsThemeForm(_AM_WGTEAMS_FORM_SELTEAM, 'formselteam', $action, 'post', true);
    $form->setExtra('enctype="multipart/form-data"');
    $teamsHandler = $helper->getHandler('Teams');
    $teamIdSelect = new \XoopsFormSelect(_AM_WGTEAMS_TEAMS_LIST, 'team_id', $teamId);
    $teamIdSelect->setExtra('onchange="submit()"');
    $teamIdSelect->addOption(0, '&nbsp;');
    $teamsAll = $teamsHandler->getAll();

    foreach (\array_keys($teamsAll) as $i) {
        $teamIdSelect->addOption($teamsAll[$i]->getVar('team_id'), $teamsAll[$i]->getVar('team_name'));
    }
    $form->addElement($teamIdSelect);
    $form->addElement(new \XoopsFormHidden('op', 'list'));
    $form->addElement(new \XoopsFormHidden('start', $start));
    $form->addElement(new \XoopsFormHidden('limit', $limit));

    return $form;
}
