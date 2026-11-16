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
 * @copyright      module for xoops
 * @license        GPL 2.0 or later
 * @package         wgteams
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 */

use Xmf\Request;
use XoopsModules\Wgteams;
use XoopsModules\Wgteams\Constants;

include_once __DIR__ . '/header.php';
$templateMain = 'wgteams_admin_image_editor.tpl';

$utility = new \XoopsModules\Wgteams\Utility();

$op         = Request::getString('op', 'list');
$memberId   = Request::getInt('member_id');
$origin     = Request::getString('imageOrigin');
$teamId     = Request::getInt('team_id');
$start      = Request::getInt('start');
$limit      = Request::getInt('limit', $helper->getConfig('adminpager'));

// get all objects/classes/vars needed for image editor
$imageClass = 0;
$imgCurrent = [];
if ('member_id' === $origin) {
    $memberId = Request::getInt('imageIdCrop');
}
if ('team_id' === $origin) {
    $teamId = Request::getInt('imageIdCrop');
}
if ( 0 < $memberId ) {
    $imageClass = Constants::IMAGECLASS_MEMBER;
} else {
    if ($teamId > 0) {
        $imageClass = Constants::IMAGECLASS_TEAM;
    } else {
        \redirect_header('index.php', 3, \_AM_WGTEAMS_FORM_ERROR_INVALID_ID);
    }
}

if ($imageClass === Constants::IMAGECLASS_MEMBER) {
    $imageId      = $memberId;
    $imageHandler = $membersHandler;
    $imageObj     = $membersHandler->get($imageId);
    if (!\is_object($imageObj)) {
        \redirect_header('members.php', 3, \_AM_WGTEAMS_INVALID_PARAM);
    }
    $imageOrigin  = 'member_id';
    $imgName      = mb_substr(\str_replace(' ', '', $imageObj->getVar('member_lastname') . $imageObj->getVar('member_firstname')), 0, 20) . '.jpg';
    $imageDir     = '/uploads/wgteams/members/images/';
    $imgPath      = \XOOPS_ROOT_PATH . $imageDir;
    $imgUrl       = \XOOPS_URL . $imageDir;
    $imgFinal     = $imgPath . $imgName;
    $imgTemp      = \WGTEAMS_UPLOAD_PATH . '/temp/' . $imgName;
    $redir        = 'members.php?op=list&start=' . $start . '&limit=' . $limit;
    $nameObj      = 'member_firstname';
    $fieldObj     = 'member_image';
    $submObj      = 'member_submitter';
    $imageInfo    = \sprintf(\_AM_WGTEAMS_IMG_EDITOR_MEMBER, $imageObj->getVar('member_firstname') . ' ' . $imageObj->getVar('member_lastname'));
} else {
    $imageId      = $teamId;
    $imageObj     = $teamsHandler->get($imageId);
    if (!\is_object($imageObj)) {
        \redirect_header('teams.php', 3, \_AM_WGTEAMS_INVALID_PARAM);
    }
    $imageHandler = $teamsHandler;
    $imageOrigin  = 'team_id';
    $imgName      = mb_substr(\str_replace(' ', '', $imageObj->getVar('team_name')), 0, 20) . '.jpg';
    $imageDir     = '/uploads/wgteams/teams/images/';
    $imgPath      = \XOOPS_ROOT_PATH . $imageDir;
    $imgUrl       = \XOOPS_URL . $imageDir;
    $imgFinal     = $imgPath . $imgName;
    $imgTemp      = \WGTEAMS_UPLOAD_PATH . '/temp/' . $imgName;
    $redir        = 'teams.php?op=list&start=' . $start . '&limit=' . $limit;
    $nameObj      = 'team_name';
    $fieldObj     = 'team_image';
    $submObj      = 'team_submitter';
    $imageInfo    = \sprintf(\_AM_WGTEAMS_IMG_EDITOR_TEAM, $imageObj->getVar('team_name'));
}

$imgCurrent['img_name'] = $imageObj->getVar($fieldObj);
$imgCurrent['src'] = $imgUrl . $imageObj->getVar($fieldObj);
$imgCurrent['origin'] = $imageClass;
$images = [];

$image_array = \XoopsLists::getImgListAsArray($imgPath);
$i = 0;
foreach ($image_array as $image_img) {
    if ('blank.gif' !== $image_img) {
        $i++;
        $images[$i]['id'] = 'imageSelect'.$i;
        $images[$i]['name'] = $image_img;
        $images[$i]['title'] = $image_img;
        $images[$i]['origin'] = Constants::IMAGECLASS_MEMBER;
        if ($imgCurrent['img_name'] === $image_img) {
            $images[$i]['selected'] = 1;
        }     
        $images[$i]['src'] = $imgUrl . $image_img;
    }
}
// var_dump($images);
$GLOBALS['xoopsTpl']->assign('images', $images);
unset($images);
// end: get all objects/classes/vars needed for image editor
if ('blank.gif' !== $imageObj->getVar($fieldObj)) {
    $GLOBALS['xoopsTpl']->assign('no_blank', true);
}

$uid = $xoopsUser instanceof \XoopsUser ? $xoopsUser->id() : 0;

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet(\WGTEAMS_URL . '/assets/css/style.css');
$GLOBALS['xoTheme']->addStylesheet(\WGTEAMS_URL . '/assets/css/imageeditor.css');

// assign vars
$GLOBALS['xoopsTpl']->assign('wgteams_url', \WGTEAMS_URL);
$GLOBALS['xoopsTpl']->assign('wgteams_icon_url_16', \WGTEAMS_ICONS_URL . '/16');
$GLOBALS['xoopsTpl']->assign('wgteams_icon_url_32', \WGTEAMS_ICONS_URL . '/32');
$GLOBALS['xoopsTpl']->assign('wgteams_upload_url', \WGTEAMS_UPLOAD_URL);
$GLOBALS['xoopsTpl']->assign('wgteams_upload_path', \WGTEAMS_UPLOAD_PATH);
$GLOBALS['xoopsTpl']->assign('wgteams_image_editor', \WGTEAMS_URL . '/admin');
$GLOBALS['xoopsTpl']->assign('wgteams_upload_image_url', $imgUrl);
$GLOBALS['xoopsTpl']->assign('gridtarget', $imgName);
$GLOBALS['xoopsTpl']->assign('imgCurrent', $imgCurrent);
$GLOBALS['xoopsTpl']->assign('imageId', $imageId);
$GLOBALS['xoopsTpl']->assign('imageOrigin', $imageOrigin);
$GLOBALS['xoopsTpl']->assign('image_info', $imageInfo);
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);
// create XOOPS tokens
$GLOBALS['xoopsTpl']->assign('wgteams_form_token', $GLOBALS['xoopsSecurity']->getTokenHTML());
$GLOBALS['xoopsTpl']->assign('wgteams_btn_token', $GLOBALS['xoopsSecurity']->createToken());

// Breadcrumbs
$GLOBALS['xoopsTpl']->assign('show_breadcrumbs', $helper->getConfig('show_breadcrumbs'));
$xoBreadcrumbs[] = ['title' => \_AM_WGTEAMS_IMG_EDITOR];

// get config for images
$imgMaxwidth  = (int)$helper->getConfig('img_maxwidth');
$imgMaxheight = (int)$helper->getConfig('img_maxheight');
$imgMaxsize   = (int)$helper->getConfig('img_maxsize');
if (0 == $imgMaxwidth || 0 == $imgMaxheight || 0 == $imgMaxsize) {
    \redirect_header($redir, 3, \_AM_WGTEAMS_INVALID_PARAM_IMG);
}
$imgMaxwidthIE  = (int)$helper->getConfig('img_maxwidth_ie');
$imgMaxheightIE = (int)$helper->getConfig('img_maxheight_ie');
$imgMimetypes   = $helper->getConfig('img_mimetypes');

switch ($op) {

    case 'creategrid':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('index.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // create an image grid based on given sources
        $type   = Request::getInt('type', 4);
        $src[1] = Request::getString('src1');
        $src[2] = Request::getString('src2');
        $src[3] = Request::getString('src3');
        $src[4] = Request::getString('src4');
        $src[5] = Request::getString('src5');
        $src[6] = Request::getString('src6');
        $target = Request::getString('target');

        $images = [];
        for ($i = 1; $i <= 6; $i++) {
            if ('' !== $src[$i]) {
                $file       = \str_replace(\XOOPS_URL, \XOOPS_ROOT_PATH, $src[$i]);
                $images[$i] = ['file' => $file, 'mimetype' => \mime_content_type($file)];
            }
        }

        // if width/height for images in image editor is defined in preferences
        // then use it, else use max width/height for upload
        $imgMaxwidthUse  = $imgMaxwidthIE > 0 ? $imgMaxwidthIE : $imgMaxwidth;
        $imgMaxheightUse = $imgMaxheightIE > 0 ? $imgMaxheightIE : $imgMaxheight;

        // create basic image
        $tmp   = \imagecreatetruecolor($imgMaxwidthUse, $imgMaxheightUse);
        $imgBg = imagecolorallocate($tmp, 0, 0, 0);
        imagefilledrectangle($tmp, 0, 0, $imgMaxwidthUse, $imgMaxheightUse, $imgBg);

        $final = XOOPS_UPLOAD_PATH . '/wgteams/temp/' . $target;
        if (\is_file($final)) {
            \unlink($final);
        }
        \imagejpeg($tmp, $final);

        $imgTemp = XOOPS_UPLOAD_PATH . '/wgteams/temp/' . $uid . 'imgTemp';

        $imgHandler = new Wgteams\Resizer();
        if (4 === $type) {
            for ($i = 1; $i <= 4; $i++) {
                if (\is_file($imgTemp . $i . '.jpg')) {
                    \unlink($imgTemp . $i . '.jpg');
                }
                $imgHandler->sourceFile    = $images[$i]['file'];
                $imgHandler->endFile       = $imgTemp . $i . '.jpg';
                $imgHandler->imageMimetype = $images[$i]['mimetype'];
                $imgHandler->maxWidth      = (int)\round($imgMaxwidthUse / 2 - 1);
                $imgHandler->maxHeight     = (int)\round($imgMaxheightUse / 2 - 1);
                $imgHandler->jpgQuality    = 90;
                $imgHandler->resizeAndCrop();
            }
            $imgHandler->mergeType = 4;
            $imgHandler->endFile   = $final;
            $imgHandler->maxWidth  = $imgMaxwidthUse;
            $imgHandler->maxHeight = $imgMaxheightUse;
            for ($i = 1; $i <= 4; $i++) {
                $imgHandler->sourceFile = $imgTemp . $i . '.jpg';
                $imgHandler->mergePos   = $i;
                $imgHandler->mergeImage();
                if (\is_file($imgTemp . $i . '.jpg')) {
                    \unlink($imgTemp . $i . '.jpg');
                }
            }
        }
        if (6 === $type) {
            for ($i = 1; $i <= 6; $i++) {
                $imgHandler->sourceFile    = $images[$i]['file'];
                $imgHandler->endFile       = $imgTemp . $i . '.jpg';
                $imgHandler->imageMimetype = $images[$i]['mimetype'];
                $imgHandler->maxWidth      = (int)\round($imgMaxwidthUse / 3 - 1);
                $imgHandler->maxHeight     = (int)\round($imgMaxheightUse / 2 - 1);
                $imgHandler->resizeAndCrop();
            }
            $imgHandler->mergeType = 6;
            $imgHandler->endFile   = $final;
            $imgHandler->maxWidth  = $imgMaxwidthUse;
            $imgHandler->maxHeight = $imgMaxheightUse;
            for ($i = 1; $i <= 6; $i++) {
                $imgHandler->sourceFile = $imgTemp . $i . '.jpg';
                $imgHandler->mergePos   = $i;
                $imgHandler->mergeImage();
                if (\is_file($imgTemp . $i . '.jpg')) {
                    \unlink($imgTemp . $i . '.jpg');
                }
            }
        }
        break; 

    case 'cropimage':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('index.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // save base64_image and resize to img_maxwidth/img_maxheight
        $base64_image_content = Request::getString('croppedImage');
        if (\preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            \file_put_contents($imgTemp, base64_decode(\str_replace($result[1], '', $base64_image_content), true));
        }
        if ($imgMaxwidthIE > 0 && $imgMaxheightIE > 0) {
            $imgHandler                = new Wgteams\Resizer();
            $imgHandler->sourceFile    = $imgTemp;
            $imgHandler->endFile       = $imgTemp;
            $imgHandler->imageMimetype = 'image/jpeg';
            $imgHandler->maxWidth      = $imgMaxwidthIE;
            $imgHandler->maxHeight     = $imgMaxheightIE;
            $ret                       = $imgHandler->resizeImage();
        }

        break;
    case 'saveImageSelected':
        // save image selected from list of available images in upload folder
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('index.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // Set Vars
        $image_id = Request::getString('image_id');
        // remove '_image' from id
        $image_id = \substr($image_id, 0, -6);
        $imageObj->setVar($fieldObj, $image_id);
        $imageObj->setVar($submObj, $uid);
        // Insert Data
        if ($imageHandler->insert($imageObj)) {  
            \redirect_header($redir, 2, \_AM_WGTEAMS_FORM_OK);
        }
        $GLOBALS['xoopsTpl']->assign('error', $imageObj->getHtmlErrors());
        break;
        
    case 'saveGrid':
        // save before created grid image
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('index.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $imgTempGrid = Request::getString('gridImgFinal');
        $ret = \rename($imgTempGrid, $imgFinal);
        // Set Vars
        $imageObj->setVar($fieldObj, $imgName);
        $imageObj->setVar($submObj, $uid);
        // Insert Data
        if ($imageHandler->insert($imageObj)) {
            \redirect_header($redir, 2, \_AM_WGTEAMS_FORM_OK);
        }
        $GLOBALS['xoopsTpl']->assign('error', $imageObj->getHtmlErrors());

        break;
    case 'saveCrop':
        // save before created cropped image
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('index.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (\is_file($imgFinal)) {
            \unlink($imgFinal);
        }
        $ret = \rename($imgTemp, $imgFinal);
        // Set Vars
        $imageObj->setVar($fieldObj, $imgName);
        $imageObj->setVar($submObj, $uid);
        // Insert Data
        if ($imageHandler->insert($imageObj, true)) {
            \redirect_header($redir, 2, \_AM_WGTEAMS_FORM_OK);
        }
        $GLOBALS['xoopsTpl']->assign('error', $imageObj->getHtmlErrors());

        break;
    case 'uploadImage':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header($redir, 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $img_resize = Request::getInt('img_resize');
        // Set Vars
        require_once \XOOPS_ROOT_PATH . '/class/uploader.php';
        $uploadFile0    = Request::getArray('xoops_upload_file')[0];
        $fileName       = $_FILES['attachedfile']['name'];
        $imageMimetype  = $_FILES['attachedfile']['type'];
        $uploaderErrors = '';
        $uploader       = new \XoopsMediaUploader($imgPath, $imgMimetypes, $imgMaxsize, $imgMaxwidth, $imgMaxheight);
        if ($uploader->fetchMedia($uploadFile0)) {
            $extension = \preg_replace('/^.+\.([^.]+)$/sU', '', $fileName);
            $imgName   .= '.' . $extension;
            $uploader->setPrefix($imgName);
            if (!$uploader->upload()) {
                $uploaderErrors = $uploader->getErrors();
            } else {
                $savedFilename = $uploader->getSavedFileName();
                $imageObj->setVar($fieldObj, $savedFilename);
                // resize image
                if (1 == $img_resize  && $imgMaxwidthIE > 0 && $imgMaxheightIE > 0) {
                    $imgHandler                = new Wgteams\Resizer();
                    $imgHandler->sourceFile    = $imgPath . $savedFilename;
                    $imgHandler->endFile       = $imgPath . $savedFilename;
                    $imgHandler->imageMimetype = $imageMimetype;
                    $imgHandler->maxWidth      = $imgMaxwidthIE;
                    $imgHandler->maxHeight     = $imgMaxheightIE;
                    $result                    = $imgHandler->resizeImage();
                }

                $imageObj->setVar($fieldObj, $savedFilename);
                $imageObj->setVar($submObj, $uid);
            }
        } else {
            if ($fileName > '') {
                $uploaderErrors = $uploader->getErrors();
            }
        }
        if ('' !== $uploaderErrors) {
            \redirect_header($redir, 5, $uploaderErrors);
        }
        // Insert Data
        if ($imageHandler->insert($imageObj)) {
            \redirect_header($redir, 2, \_AM_WGTEAMS_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $imageObj->getHtmlErrors());
        $form = getFormUploadImage($imageOrigin, $imageId);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
        
    case 'imghandler':
    default:
        $GLOBALS['xoTheme']->addStylesheet(\WGTEAMS_URL . '/assets/css/cropper.min.css');

        $GLOBALS['xoopsTpl']->assign('nbModals', [1, 2, 3, 4, 5, 6]);
        
        // get form for upload album image
        $currImage   = $imageObj->getVar($fieldObj);
        if ('' == $currImage) {
            $currImage = 'blank.gif';
        }
        $image_path = $imgPath . $currImage;
        $width = 0;
        $height= 0;
        if (\file_exists($image_path) && is_file($image_path)) {
            // get size of current album image
            [$width, $height, $type, $attr] = \getimagesize($image_path);
        }
        $GLOBALS['xoopsTpl']->assign('image_path', $image_path);
        $GLOBALS['xoopsTpl']->assign('image_width', $width);
        $GLOBALS['xoopsTpl']->assign('image_height', $height);
        
        $form = getFormUploadImage($imageOrigin, $imageId);
        $GLOBALS['xoopsTpl']->assign('form_uploadimage', $form->render());

        $GLOBALS['xoopsTpl']->assign('btn_style', 'btn-default');

        break;
}

$GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));

// Description
// $utility::getMetaDescription(_AM_WGTEAMS_ALBUMS);

include_once __DIR__ . '/footer.php';

/**
 * @public function getFormUploadImage:
 * provide form for uploading a new image
 * @param $imageOrigin
 * @param $imageId
 * @return \XoopsThemeForm
 */
function getFormUploadImage($imageOrigin, $imageId): XoopsThemeForm
{
    $helper = \XoopsModules\Wgteams\Helper::getInstance();
    // Get Theme Form
    \xoops_load('XoopsFormLoader');
    $form = new \XoopsThemeForm('', 'formuploadimage', 'image_editor.php', 'post', true);
    $form->setExtra('enctype="multipart/form-data"');
    // upload new image
    $imageTray1      = new \XoopsFormElementTray(_AM_WGTEAMS_FORM_UPLOAD_IMG, '<br>');
    $imageFileSelect = new \XoopsFormFile('', 'attachedfile', $helper->getConfig('img_maxsize'));
    $imageTray1->addElement($imageFileSelect);
    $form->addElement($imageTray1);
    
    $cond = \_AM_WGTEAMS_IMG_MAXSIZE . ': ' . ($helper->getConfig('img_maxsize') / 1048576) . ' ' . \_AM_WGTEAMS_SIZE_MB . '<br>';
    $cond .= \_AM_WGTEAMS_MAXWIDTH . ': ' . $helper->getConfig('img_maxwidth') . ' px<br>';
    $cond .= \_AM_WGTEAMS_MAXHEIGHT . ': ' . $helper->getConfig('img_maxheight') . ' px<br>';
    $cond .= \_AM_WGTEAMS_MIMETYPES . ': ' . \implode(', ', $helper->getConfig('img_mimetypes')) . '<br>';
    $form->addElement(new \XoopsFormLabel(_AM_WGTEAMS_IMG_EDITOR_UPLOAD, $cond));
      
    $imageTray3      = new \XoopsFormElementTray(_AM_WGTEAMS_IMG_EDITOR_RESIZE, '');
    $resizeinfo = \str_replace('%w', (string)$helper->getConfig('img_maxwidth_ie'), \_AM_WGTEAMS_IMG_EDITOR_RESIZE_DESC);
    $resizeinfo = \str_replace('%h', (string)$helper->getConfig('img_maxheight_ie'), $resizeinfo);
    $imageTray3->addElement(new \XoopsFormLabel($resizeinfo, ''));
    $imageTray3->addElement(new \XoopsFormRadioYN('', 'img_resize', 1));
    $form->addElement($imageTray3);

    $form->addElement(new \XoopsFormHidden($imageOrigin, $imageId));
    $form->addElement(new \XoopsFormHidden('op', 'uploadImage'));
    $form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));

    return $form;
}
