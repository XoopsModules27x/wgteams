<!-- Header -->
<{include file='db:wgteams_admin_header.tpl'}>
<{if $infofields_list|default:false}>
    <table class="outer">
        <thead>
            <tr class="head">
                <th class="center"><{$smarty.const._AM_WGTEAMS_INFOFIELD_ID}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_INFOFIELD_NAME}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_INFOFIELD_CLASS}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_SUBMITTER}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_DATE_CREATE}></th>
                <th class="center width-action"><{$smarty.const._AM_WGTEAMS_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $infofields_count|default:0 > 0}>
            <tbody>
                <{foreach item=infofield from=$infofields_list}>
                <tr class="<{cycle values='odd, even'}>">
                    <td class="center"><{$infofield.field_id}></td>
                    <td class="center"><{$infofield.field_name}></td>
                    <td class="center"><{$infofield.field_class_text|default:false}></td>
                    <td class="center"><{$infofield.field_submitter}></td>
                    <td class="center"><{$infofield.field_date_created}></td>
                    <td class="center width-action xo-buttons">
                        <a href="infofields.php?op=edit&infofield_id=<{$infofield.field_id}>&start=<{$start}>&limit=<{$limit}>" title="<{$smarty.const._EDIT}>"><i class="fa fa-edit"></i></a>
                    <a href="infofields.php?op=delete&infofield_id=<{$infofield.field_id}>&start=<{$start}>&limit=<{$limit}>" title="<{$smarty.const._DELETE}>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                <{/foreach}>
            </tbody>
        <{/if}>
    </table>
    <div class="clear">&nbsp;</div>
    <{if $pagenav|default:false}>
        <div class="xo-pagenav floatright"><{$pagenav}></div><div class="clear spacer"></div>
    <{/if}>
<{/if}>

<{if $form|default:false}>
    <{$form}>
<{/if}>

<{if $error|default:false}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<br>
<!-- Footer -->
<{include file='db:wgteams_admin_footer.tpl'}>
