<tr class="expandable" id="{LOGID}">
    <td style="vertical-align: middle;" id="logID">{LOGID}</td>
    <td style="vertical-align: middle;" id="dateTimeLogged">{DATETIMELOGGED}</td>
    <td style="vertical-align: middle;" id="assignedTo">{ASSIGNEDTO}</td>
    <td style="vertical-align: middle;" id="location">{LOCATION}</td>
    <td style="vertical-align: middle;" id="category">{CONTENTTYPE}</td>
    <td style="vertical-align: middle;">
        <select class="closedReason" title="reasonMy" name="reasonMy[]" id="reasonMy">
            <option value="0">Reason for closure...</option>
            {CLOSEDREASON}
        </select>
    </td>
</tr>
<tr style="display: none;"  class="contentRow" id="td{LOGID}">

    <td colspan="6" style="min-height: 200px; max-height: 350px;">
        <div style="width:60%;" class="left content">{CONTENT}</div>
        <div style="width:39%;" class="right pullright content comment{LOGID}">
            <div class="{LOGID}">
                <textarea class="comment" id="commentBox{LOGID}" name="comment"></textarea>
                <input id="sendComment" class="btn btn-default" onclick="app.ticketHandler.addComment(this);" type="button" value="Add Comment" style="width: 100%; padding: 3px; margin: 2px; font-size: large;">
                <br><br>

            {COMMENTS}
            </div>
        </div>

    </td>

</tr>