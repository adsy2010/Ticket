<tr onclick="expandticket({LOGID})" id="{LOGID}">
    <td style="vertical-align: middle;" id="logID">{LOGID}</td>
    <td style="vertical-align: middle;" id="dateTimeLogged">{DATETIMELOGGED}</td>
    <td style="vertical-align: middle;" id="assignedTo">{ASSIGNEDTO}</td>
    <td style="vertical-align: middle;" id="location">{LOCATION}</td>
    <td style="vertical-align: middle;" id="category">{CONTENTTYPE}</td>
    <td style="vertical-align: middle;">
        <select title="reasonMy" name="reasonMy[]" id="reasonMy" onclick="event.stopPropagation()">
            <option value="0">Reason for closure...</option>
            {CLOSEDREASON}
        </select>
    </td>
</tr>
<tr style="display: none;"  class="contentRow" id="td{LOGID}">

    <td colspan="6" style="min-height: 200px; max-height: 350px;">
        <div style="width:60%;" class="left content">{CONTENT}</div>
        <div style="width:39%;" class="right pullright content commentSide{LOGID}">{COMMENTS}</div>

    </td>

</tr>