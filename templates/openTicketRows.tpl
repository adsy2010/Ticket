<tr class="expandable" id="{LOGID}">
    <td style="vertical-align: middle;"><input title="check" type="checkbox" id="log{LOGID}" onclick="event.stopPropagation()"></td>
    <td style="vertical-align: middle;" id="logID">{LOGID}</td>
    <td style="vertical-align: middle;" id="loggedBy">{LOGGEDBY}</td>
    <td style="vertical-align: middle;" id="department">{DEPARTMENT}</td>
    <td style="vertical-align: middle;" id="assignedTo">
        <select class="assignedTo" name="assignedTo" id="assignedTo">
            <option value="0"></option>
            {ASSIGNEDTO}
        </select>
    </td>
    <td style="vertical-align: middle;" id="dateTimeLogged">{DATETIMELOGGED}</td>
    <td style="vertical-align: middle;" id="location">{LOCATION}</td>
    <td style="vertical-align: middle;" id="category">{CONTENTTYPE}</td>
    <td style="vertical-align: middle;" >
        Low <input class="priority" id="priority{LOGID}" name="priority{LOGID}" type="radio" value="1" {LOW} onclick="event.stopPropagation()">
        Med <input class="priority" id="priority{LOGID}" name="priority{LOGID}" type="radio" value="2" {MEDIUM} onclick="event.stopPropagation()">
        High <input class="priority" id="priority{LOGID}" name="priority{LOGID}" type="radio" value="3" {HIGH} onclick="event.stopPropagation()">
    </td>
    <td>


        <select class="closedReason" title="reason" name="reason[]" id="reason" onclick="event.stopPropagation()">
            <option value="0">Reason for closure...</option>
            {CLOSEDREASON}
        </select>
        <input class="btn btn-default" type="button" id="transfer" value="Transfer desk" onclick="event.stopPropagation()">
    </td>
</tr>
<tr style="display: none;"  class="contentRow" id="td{LOGID}">

    <td colspan="10" style="min-height: 200px; max-height: 350px;">
        <div style="width:60%;" class="left content">{CONTENT}</div>
        <div style="width:39%;" class="right content comment{LOGID}">
            <div class="{LOGID}">
                <textarea class="comment" id="commentBox{LOGID}" name="comment"></textarea>
                <input id="sendComment" class="btn btn-default" onclick="app.ticketHandler.addComment(this);" type="button" value="Add Comment" style="width: 100%; padding: 3px; margin: 2px; font-size: large;">
                <br><br>
                {COMMENTS}
            </div>
        </div>

    </td>

</tr>