<!-- Header -->
<{include file='db:wgteams_admin_header.tpl'}>
<{if $teams_list|default:false}>
    <table class="outer" id="sortable">
        <thead>
            <tr class="head">
                <th class="center">&nbsp;</th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_TEAM_ID}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_TEAM_NAME}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_TEAM_DESCR}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_TEAM_IMAGE}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_TEAM_NB_COLS}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_TEAM_TABLESTYLE}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_TEAM_IMAGESTYLE}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_TEAM_DISPLAYSTYLE}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_TEAM_RELSCOUNT}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_TEAM_ONLINE}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_SUBMITTER}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_DATE_CREATE}></th>
                <th class="center width-action"><{$smarty.const._AM_WGTEAMS_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $teams_count|default:false}>
            <tbody id="teams-list">
                <{foreach item=team from=$teams_list}>
                    <tr class="even" id="torder_<{$team.id}>" >
                        <td class="center">
                            <{if $teams_count|default:0 > 1}>
                                <i class="icon-sortable fa-solid fa-up-down-left-right"></i>
                            <{/if}>
                        </td>
                        <td class="center"><{$team.id}></td>
                        <td class="center"><{$team.name}></td>
                        <td class="center"><{$team.descr}></td>
                        <td class="center">
                            <{if $team.image|default:false}>
                                <img src="<{$wgteams_upload_url}>/teams/images/<{$team.image}>" alt="teams" style='max-width:50px;' class="<{$team.imagestyle}>" >
                                <br><{$team.image_resxy}>
                            <{/if}>
                        </td>
                        <td class="center"><{$team.nb_cols}></td>
                        <td class="center"><{$team.tablestyle}></td>
                        <td class="center"><{$team.imagestyle}></td>
                        <td class="center"><{$team.displaystyle}></td>
                        <td class="center"><{$team.relscount}></td>
                        <td class="center">
                            <form action='teams.php' method='post' style='display:inline;'>
                                <{$wgteams_form_token}>
                                <input type='hidden' name='op' value='set_onoff'>
                                <input type='hidden' name='team_id' value='<{$team.id}>'>
                                <input type='hidden' name='start' value='<{$start}>'>
                                <input type='hidden' name='limit' value='<{$limit}>'>
                                <span class='xo-buttons'>
                                    <{if $team.team_online == 1}>
                                        <button class='' aria-label="<{$smarty.const._AM_WGTEAMS_IS_ONLINE}>" title="<{$smarty.const._AM_WGTEAMS_IS_ONLINE}>">
                                            <i class='fa fa-eye'></i>
                                        </button>
                                    <{else}>
                                        <button class='' aria-label="<{$smarty.const._AM_WGTEAMS_IS_OFFLINE}>" title="<{$smarty.const._AM_WGTEAMS_IS_OFFLINE}>">
                                            <i class='fa fa-eye-slash'></i>
                                        </button>
                                    <{/if}>
                                </span>
                            </form>
                        </td>
                        <td class="center"><{$team.submitter}></td>
                        <td class="center"><{$team.date_create}></td>
                        <td class="center width-action xo-buttons">
                        <a href="teams.php?op=edit&team_id=<{$team.id}>&start=<{$start}>&limit=<{$limit}>" title="<{$smarty.const._EDIT}>"><i class='fa fa-edit'></i></a>
                        <a href="image_editor.php?op=edit_team&team_id=<{$team.id}>&start=<{$start}>&limit=<{$limit}>" title="<{$smarty.const._AM_WGTEAMS_IMG_EDITOR}>"><i class='fa fa-image'></i></a>
                        <a href="teams.php?op=delete&team_id=<{$team.id}>&start=<{$start}>&limit=<{$limit}>" title="<{$smarty.const._DELETE}>"><i class='fa fa-trash'></i></a>
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

<script>
    $(document).ready(function () {

        function saveItemOrder(element) {
            var list = element.sortable("serialize");
            var token = $("#xoopsSortToken").val();

            $.post("teams.php?op=order&start=<{$start}>", list + "&XOOPS_TOKEN_REQUEST=<{$wgteams_btn_token|default:''|escape}>")
                .fail(function (xhr) {
                    console.error("Error when sorting:", xhr.responseText);
                });
        }

        $("#teams-list").sortable({
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
