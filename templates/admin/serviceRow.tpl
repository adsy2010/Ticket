<tr id="{ID}">
    <td>{ID}</td>
    <td><p class="statusName" contenteditable="true">{NAME}</p></td>
    <td>
        <select name="statusStatus" id="statusStatus">
            <option value="1" {S1}>Working</option>
            <option value="2" {S2}>Intermittent</option>
            <option value="3" {S3}>Problem</option>
        </select>
    </td>

    <td>
        <a href="#" id="remove{ID}" class="removeCategory btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-remove"></span>
        </a>
    </td>
</tr>