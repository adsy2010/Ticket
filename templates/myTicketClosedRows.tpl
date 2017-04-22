<tr class="expandable" id="{LOGID}">
    <td style="vertical-align: middle;" id="logID">{LOGID}</td>
    <td style="vertical-align: middle;" id="dateTimeLogged">{DATETIMELOGGED}</td>
    <td style="vertical-align: middle;" id="assignedTo">{ASSIGNEDTO}</td>
    <td style="vertical-align: middle;" id="location">{LOCATION}</td>
    <td style="vertical-align: middle;" id="category">{CONTENTTYPE}</td>
    <td style="vertical-align: middle;" id="category">{CLOSEDDATETIME}</td>
    <td style="vertical-align: middle;" id="category">{CLOSEDBY}</td>
    <td style="vertical-align: middle;" id="category">{CLOSEDREASON}<br>Why: {CLOSEDWHY}</td>
    <td style="vertical-align: middle;" class="status">
        <input class="btn btn-default btn-reopen" type="button" id="closeMy" value="Reopen Ticket" onclick="event.stopPropagation()">
    </td>
</tr>
<tr style="display: none;"  class="contentRow" id="td{LOGID}">

    <td colspan="9" style="min-height: 200px; max-height: 350px;">
        <div style="width:60%;" class="left content">{CONTENT}</div>
        <div style="width:39%;" class="right content">
            <div class="{LOGID}">
                <textarea class="comment" id="commentBox{LOGID}" name="comment"></textarea>
                <input id="sendComment" class="btn btn-default" onclick="app.ticketHandler.addComment(this);" type="button" value="Add Comment" style="width: 100%; padding: 3px; margin: 2px; font-size: large;">
                <br><br>
                {COMMENTS}
            </div>

        </div>
    </td>

</tr>