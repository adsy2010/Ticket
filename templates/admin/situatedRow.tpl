<tr id="{ID}">
    <td>{ID}</td>
    <td><p class="situatedMake">{MAKE}</p></td>
    <td><p class="situatedModel">{MODEL}</p></td>
    <td><p class="situatedLocation" contenteditable="true">{LOCATION}</p></td>
    <td>
            <select name="situatedCostDept" id="situatedCostDept">
                {COSTDEPT}
            </select>
    </td>
    <td><input class="situatedExemption" type="checkbox" value="{EXEMPT}"></td>
    <td>
        <a href="#" class="btn btn-success btn-sm">
            <span class="glyphicon glyphicon-ok"></span>
        </a>

        <a href="#" id="remove{ID}" class="removeSituatedPrinter btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-remove"></span>
        </a>
    </td>
</tr>