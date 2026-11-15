<!-- Header -->
<{include file='db:wgteams_admin_header.tpl'}>

<{if $form|default:false}>
    <{$form}>
<{/if}>

<{if $relations_list|default:false}>
    <table class="outer" id="sortable">
        <thead>
            <tr class="head">
                <th class="center">&nbsp;</th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_MEMBER_ID}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_1_FIELD}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_1}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_2_FIELD}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_2}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_3_FIELD}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_3}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_4_FIELD}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_4}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_5_FIELD}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_5}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_SUBMITTER}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_DATE_CREATE}></th>
                <th class="center width-action"><{$smarty.const._AM_WGTEAMS_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $relations_count|default:false}>
            <{foreach item=relation from=$relations_list}>
                <tr class="even" id="rorder_<{$relation.id}>">
                    <td class="center">
                        <{if $relation.nb_rels_team|default:0 > 1}>
                            <i class="icon-sortable fa-solid fa-up-down-left-right"></i>
                        <{/if}>
                    </td>
                    <td class="center"><{$relation.member_name}></td>
                    <td class="center"><{$relation.info_1_field|default:false}></td>
                    <td class="left"><{$relation.info_1}></td>
                    <td class="center"><{$relation.info_2_field|default:false}></td>
                    <td class="left"><{$relation.info_2}></td>
                    <td class="center"><{$relation.info_3_field|default:false}></td>
                    <td class="left"><{$relation.info_3}></td>
                    <td class="center"><{$relation.info_4_field|default:false}></td>
                    <td class="left"><{$relation.info_4}></td>
                    <td class="center"><{$relation.info_5_field|default:false}></td>
                    <td class="left"><{$relation.info_5}></td>
                    <td class="center"><{$relation.submitter}></td>
                    <td class="center"><{$relation.date_create}></td>
                    <td class="center width-action xo-buttons">
                    <a href="relations.php?op=edit&rel_id=<{$relation.id}>&start=<{$start}>&limit=<{$limit}>" title="<{$smarty.const._EDIT}>"><i class="fa fa-edit"></i></a>
                    <a href="relations.php?op=delete&rel_id=<{$relation.id}>&start=<{$start}>&limit=<{$limit}>" title="<{$smarty.const._DELETE}>"><i class='fa fa-trash'></i></a>
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
<{else}>
    <div class="info-box-light center"><{$smarty.const._AM_WGTEAMS_SELECT_TEAMS}></div>
<{/if}>

<{if $error|default:false}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<br>
<!-- Footer -->
<{include file='db:wgteams_admin_footer.tpl'}>


<script>
    $(document).ready(function () {

        function saveItemOrder(element) {
            var list = element.sortable("serialize");
            var token = $("#xoopsSortToken").val();

            $.post("relations.php?op=order&start=<{$start}>", list + "&XOOPS_TOKEN_REQUEST=<{$wgteams_btn_token|default:''|escape}>")
                .fail(function (xhr) {
                    console.error("Error when sorting:", xhr.responseText);
                });
        }

        $("#sortable > tbody").sortable({
            items: "tr:has(td)",
            opacity: 0.6,
            cursor: "move",

            update: function (event, ui) {
                saveItemOrder($(this));
            },

            receive: function (event, ui) {
                saveItemOrder($(this));
            }

        }).disableSelection();

    });
</script>
