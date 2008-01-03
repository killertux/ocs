{**
 * rooms.tpl
 *
 * Copyright (c) 2000-2007 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Display list of rooms in the Scheduler in conference management.
 *
 * $Id$
 *}
{assign var="pageTitle" value="manager.scheduler.rooms"}
{assign var="pageId" value="manager.scheduler.rooms"}
{include file="common/header.tpl"}

<ul class="menu">
	<li><a href="{url op="editBuilding" path=$buildingId}">{translate key="manager.scheduler.building.editBuilding"}</a></li>
	<li class="current"><a href="{url op="rooms" path=$buildingId}">{translate key="manager.scheduler.rooms"}</a></li>
</ul>

<br />

<a name="rooms"></a>

<table width="100%" class="listing">
	<tr>
		<td colspan="2" class="headseparator">&nbsp;</td>
	</tr>
	<tr class="heading" valign="bottom">
		<td width="85%">{translate key="manager.scheduler.room.name"}</td>
		<td width="15%">{translate key="common.action"}</td>
	</tr>
	<tr>
		<td colspan="2" class="headseparator">&nbsp;</td>
	</tr>
{iterate from=rooms item=room}
	<tr valign="top">
		<td>{$room->getRoomName()|escape}</td>
		<td><a href="{url op="editRoom" path=$room->getBuildingId()|to_array:$room->getRoomId()}" class="action">{translate key="common.edit"}</a>&nbsp;|&nbsp;<a href="{url op="deleteRoom" path=$room->getRoomId()}" onclick="return confirm('{translate|escape:"jsparam" key="manager.scheduler.room.confirmDelete"}')" class="action">{translate key="common.delete"}</a></td>
	</tr>
	<tr>
		<td colspan="2" class="{if $rooms->eof()}end{/if}separator">&nbsp;</td>
	</tr>
{/iterate}
{if $rooms->wasEmpty()}
	<tr>
		<td colspan="2" class="nodata">{translate key="manager.scheduler.room.noneCreated"}</td>
	</tr>
	<tr>
		<td colspan="2" class="endseparator">&nbsp;</td>
	</tr>
{else}
	<tr>
		<td colspan="2" align="left">{page_info iterator=$rooms}</td>
		<td colspan="2" align="right">{page_links anchor="rooms" name="rooms" iterator=$rooms}</td>
	</tr>
{/if}
</table>

<a href="{url op="createRoom" path=$buildingId}" class="action">{translate key="manager.scheduler.room.create"}</a>

{include file="common/footer.tpl"}
