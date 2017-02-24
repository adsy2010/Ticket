<tr id="{ID}">
    <td>{ID}</td>
    <td><p class="catName" contenteditable="true">{CATEGORY}</p></td>
    <td>
        Open Ticket<input class="openState" type="radio" name="openState{ID}" id="openState{ID}" value="1" {OPENSTATE}>
        <br>
        Close Ticket<input class="openState" type="radio" name="openState{ID}" id="openState{ID}" value="2" {CLOSESTATE}>
    </td>
    <td>
        <a href="#" class="btn btn-success btn-sm">
            <span class="glyphicon glyphicon-ok"></span>
        </a>

        <a href="#" id="remove{ID}" class="removeCategory btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-remove"></span>
        </a>
    </td>
</tr>