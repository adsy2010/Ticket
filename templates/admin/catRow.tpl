<tr>
    <td>{ID}</td>
    <td><p contenteditable="true">{CATEGORY}</p></td>
    <td>
        Open Ticket<input type="radio" name="openState{ID}" id="openState{ID}" value="1" {OPENSTATE}>
        <br>
        Close Ticket<input type="radio" name="openState{ID}" id="openState{ID}" value="2" {CLOSESTATE}>
    </td>
    <td>
        <a href="#" id="{ID}" class="removeCategory btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-remove"></span>
        </a>
    </td>
</tr>