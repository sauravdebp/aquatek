<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 10/5/14
 * Time: 10:48 PM
 */
?>

<div class="col-md-10">
    <!--<center><h1>Add accessory items</h1></center>
    <br><br>-->
    <div class="row col-md-12 center-block">
        <table class="table table-striped table-hover table_billItems">
            <tr>
                <th>SL.</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Serial No.</th>
                <th>Remarks</th>
                <th>Op</th>
            </tr>
            <?php
            $sno = 0;
            foreach($accessoryItems as $accessoryItem)
            {
                ?>
                <tr>
                    <td><?php echo ++$sno; ?></td>
                    <td><?php echo $accessoryItem->accessory_item_description; ?></td>
                    <td><?php echo $accessoryItem->quantity; ?></td>
                    <td>
                        <?php
                        foreach($unitTypes as $unitType)
                        {
                            if($accessoryItem->unit_type == $unitType->unit_type_id)
                            {
                                echo $unitType->unit_type_name;
                            }
                        }
                        ?>
                    </td>
                    <td><?php echo $accessoryItem->serial_no; ?></td>
                    <td><?php echo $accessoryItem->remarks; ?></td>
                    <td>
                        <!--<button class="btn btn-default btn-sm but_edit" type="button" name="but_add">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>-->
                        <button class="btn btn-default btn-sm but_remove" type="button" name="but_add">
                            <span class="glyphicon glyphicon-minus"></span>
                        </button>
                    </td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td></td>
                <td><input class="form-control input_item" type="text" autocomplete="off" placeholder="Accessory Item Name" name="accessoryNames[]" style="width: 300px;"></td>
                <td><input class="form-control input_quantity" type="number" min="0" autocomplete="off" placeholder="Quantity" name="itemQuantities[]" style="width: 100px;"></td>
                <td>
                    <select class="form-control select_unit" style="width: 80px;" name="itemUnits[]">
                        <option value>Unit</option>
                        <?php
                        foreach($unitTypes as $type)
                        {
                            ?>
                            <option value="<?php echo $type->unit_type_id; ?>"><?php echo $type->unit_type_name; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
                <td><input class="form-control input_serialNo" type="text" autocomplete="off" placeholder="Serial No." name="serialNos[]"></td>
                <td><input class="form-control input_remark" type="text" autocomplete="off" placeholder="Remark" name="remarks[]"></td>
                <td>
                    <button class="btn btn-default btn-sm but_add" type="button" id="but_add">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </td>
            </tr>
        </table>
    </div>
    <form role="form" class="form_hidden" method="post" action="#">
        <div class="row col-md-12">
            <input type="submit" value="Proceed" class="btn btn-default btn-lg center-block">
        </div>
    </form>
</div>

<script>
    $(document).ready(function ()
    {
        $('.input_item').typeahead({
            remote: '/<?php echo BASEURL ?>index.php/AJAX/accessoryItemSuggestions?keyword=%QUERY'
        });
        $('#but_add').click(addButtonHandler);

        function addButtonHandler()
        {
            var itemAttrs = {
                item: $('.input_item').val(),
                quantity: $('.input_quantity').val(),
                unit: $('.select_unit').val(),
                serialNo: $('.input_serialNo').val(),
                remark: $('.input_remark').val()
            };
            if(!verify(itemAttrs))
                return;
            for(var x in itemAttrs)
            {
                var inputNode = document.createElement("input");
                inputNode.type = "hidden";
                inputNode.name = x + "[]";
                inputNode.value = itemAttrs[x];
                $('.form_hidden').append(inputNode);
            }
            itemAttrs.unit = $('.select_unit option:selected').text();
            addItemToTable(itemAttrs);
            clearInputs();
            //$('.table_billItems tr:last-child td:first-child').text(nItems+1);
        }

        function verify(attrs)
        {return true;
            for(x in attrs)
            {
                if(x != "serialNo" && x!="remark" && attrs[x] == "")
                {
                    return false;
                }
            }
            return true;
        }

        function addItemToTable(item)
        {
            var trNode = document.createElement("tr");
            var tdNode = document.createElement("td");
            //tdNode.innerText = ++nItems;
            trNode.appendChild(tdNode);
            for(var x in item)
            {
                tdNode = document.createElement("td");
                tdNode.innerText = item[x];
                trNode.appendChild(tdNode);
            }

            tdNode = document.createElement("td");
            tdNode.innerHTML =
                /*"<button class=\"btn btn-default btn-sm but_edit\" type=\"button\" name=\"but_add\">" +
                 "<span class=\"glyphicon glyphicon-pencil\"></span>" +
                 "</button>" +*/
                "<button class=\"btn btn-default btn-sm but_remove\" type=\"button\" name=\"but_add\">" +
                    "<span class=\"glyphicon glyphicon-minus\"></span>" +
                    "</button>";
            trNode.appendChild(tdNode);
            $('.table_billItems tbody tr:nth-last-child(2)').after(trNode);
        }

        function clearInputs()
        {
            $('.input_item').val(null);
            $('.select_unit').val(null);
            $('.input_quantity').val(null);
            $('.input_remark').val(null);
            $('.input_serialNo').val(null);
            $('.txt_total').text("0");
        }
    });
</script>