<tr id="{ID}">
    <td>{ID}</td>
    <td><p class="cartridgeName" contenteditable="true">{NAME}</p></td>
    <td>
        <!--<input type="color" class="cartridgeColor" value="{COLOR}">-->
        <select name="cartridgeColor" id="cartridgeColor">
            <option value="black" {BLACK}>Black</option>
            <option value="cyan" {CYAN}>Cyan</option>
            <option value="magenta" {MAGENTA}>Magenta</option>
            <option value="yellow" {YELLOW}>Yellow</option>
        </select>
    </td>
    <td><p class="cartridgeStock" contenteditable="true">{STOCK}</p></td>
    <td>
        <select name="cartridgePrinterName" id="cartridgePrinterName">
            {PRINTERS}
        </select>
    </td>
    <td><p><span class="currencyinput">£<span class="cartridgeCost" contenteditable="true">{COST}</span></span></p></td>
    <td>
        <a href="#" id="remove{ID}" class="removeCategory btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-remove"></span>
        </a>
    </td>
</tr>