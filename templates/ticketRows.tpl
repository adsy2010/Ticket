<tr onclick="expandticket({LOGID})">
    <td><input title="check" type="checkbox" id="log{LOGID}" onclick="event.stopPropagation()"></td>
    <td id="logID">{LOGID}</td>
    <td id="loggedBy">{LOGGEDBY}</td>
    <td id="assignedTo">

            {AUTHENTICATEDUSERS}
    </td>
    <td id="dateTimeLogged">{DATETIMELOGGED}</td>
    <td id="location">{LOCATION}</td>
    <td id="category">{CONTENTTYPE}</td>
    <td id="department">{DEPARTMENT}</td>
    <td>
        <input type="button" id="close{LOGID}" value="Close Ticket" onclick="event.stopPropagation()">
        <select title="reason" name="reason[]" id="reason" onclick="event.stopPropagation()">
            <option value="">Reason for closure</option>
        </select>
    </td>
</tr>
<tr style="display: none;"  class="contentRow" id="td{LOGID}">

    <td colspan="9" style="min-height: 200px; max-height: 350px;">
        <div class="left content"><p>{CONTENT}</p></div>
        <div class="right content"><p>{COMMENTS}</p></div>


    </td>

</tr>