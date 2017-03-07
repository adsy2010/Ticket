<tr onclick="expandticket({LOGID})" id="{LOGID}">
    <td style="vertical-align: middle;"><input title="check" type="checkbox" id="log{LOGID}" onclick="event.stopPropagation()"></td>
    <td style="vertical-align: middle;" id="logID">{LOGID}</td>
    <td style="vertical-align: middle;" id="dateTimeLogged">{DATETIMELOGGED}</td>
    <td style="vertical-align: middle;" id="loggedBy">{LOGGEDBY}</td>
    <td style="vertical-align: middle;" id="department">{DEPARTMENT}</td>
    <td style="vertical-align: middle;" id="assignedTo">{ASSIGNEDTO}</td>
    <td style="vertical-align: middle;" id="location">{LOCATION}</td>
    <td style="vertical-align: middle;" id="category">{CONTENTTYPE}</td>
    <td style="vertical-align: middle;" id="closedBy">{CLOSEDBY}</td>
    <td style="vertical-align: middle; max-width: 150px;" id="closedReason">{CLOSEDREASON}<br>Why: {CLOSEDWHY}</td>
    <td style="vertical-align: middle;" id="closedDateTime">{CLOSEDDATETIME}</td>

    <td style="vertical-align: middle;">
        <input class="btn btn-default btn-reopen" type="button" id="close" value="Reopen Ticket" onclick="event.stopPropagation()">
    </td>
</tr>
<tr style="display: none;"  class="contentRow" id="td{LOGID}">

    <td colspan="12" style="min-height: 200px; max-height: 350px;">
        <div style="width:50%;" class="left content">{CONTENT}</div>
        <div style="width:50%;" class="right content"><p>{COMMENTS}</p></div>


    </td>

</tr>