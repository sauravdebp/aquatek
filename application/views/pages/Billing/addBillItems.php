<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 9/25/14
 * Time: 6:41 PM
 */
?>

<div class="container">
    <center><h1>Add invoice items</h1></center>
    <br><br>
    <div class="row">
        <div class="col-md-12 center-block bg-primary">
            <center><h4><?php echo $invoiceTypes[$invoiceDetails->invoice_type]; ?> Invoice</h4></center>
        </div>
    </div>
    <div class="row bg-info">
        <div class="col-md-6">
            <div class="row col-md-12">Date : <?php echo $invoiceDetails->invoice_date; ?></div>
            <div class="row col-md-12">Invoice No. : <?php echo $invoiceDetails->invoice_no; ?></div>
            <div class="row col-md-12">Book No. : <?php echo $invoiceDetails->invoice_book_no; ?></div>
        </div>
        <div class="col-md-6">
            <div class="row col-md-12">Bill To</div>
            <div class="row col-md-12"><?php echo $consigneeDetails->consignee_name; ?></div>
            <div class="row col-md-12"><?php echo $consigneeDetails->consignee_address_street; ?></div>
            <div class="row col-md-12"><?php echo $consigneeDetails->consignee_address_city . " (" . $consigneeDetails->consignee_address_state . ") PIN - " . $consigneeDetails->consignee_address_pincode; ?></div>
        </div>
    </div>
    <div class="row bg-warning">
        <div class="col-md-6">
            <div class="row col-md-12">Consignee TIN No. : <?php echo $invoiceDetails->invoice_consignee; ?></div>
            <div class="row col-md-12">Authorised Contact Person : <?php echo $consigneeDetails->consignee_contact_person; ?></div>
            <div class="row col-md-12">Consignee Authorised Tel/Mobile No. : <?php echo $consigneeDetails->consignee_contact_mobile; ?></div>
        </div>
        <div class="col-md-6">
            <div class="row col-md-12">Vehicle No. : <?php echo $invoiceDetails->invoice_vehicle_no; ?></div>
            <div class="row col-md-12">GR/Bill T No. : <?php echo $invoiceDetails->invoice_gr_bill_tno; ?></div>
            <div class="row col-md-12">Road Permit No. : <?php echo $invoiceDetails->invoice_road_permit_no; ?></div>
        </div>
    </div>

    <div class="row col-md-12 center-block">
        <table class="table table-striped table-hover table_billItems">
            <tr>
                <th>SL.</th>
                <th>Item Description</th>
                <th>Rate</th>
                <th>Unit</th>
                <th>Qty</th>
                <th>Discount%</th>
                <th>Tax%</th>
                <th>Total</th>
                <th>Op</th>
            </tr>
            <?php
            $sno = 0;
            $totalAmount = 0;
            $totalTax = 0;
            foreach($invoiceItems as $invoiceItem)
            {
            ?>
                <tr>
                    <td><?php echo ++$sno; ?></td>
                    <td><?php echo $invoiceItem->invoice_item_description; ?></td>
                    <td><?php echo $invoiceItem->rate; ?></td>
                    <td>
                        <?php
                        foreach($unitTypes as $unitType)
                        {
                            if($invoiceItem->unit_type == $unitType->unit_type_id)
                            {
                                echo $unitType->unit_type_name;
                            }
                        }
                        ?>
                    </td>
                    <td><?php echo $invoiceItem->quantity; ?></td>
                    <td><?php echo $invoiceItem->discount_perc; ?> %</td>
                    <td>
                        <?php
                        $taxPerc = 0;
                        foreach($taxTypes as $taxType)
                        {
                            if($invoiceItem->tax_type == $taxType->tax_type_id)
                            {
                                $taxPerc = $taxType->tax_perc;
                                echo $taxType->tax_perc;
                            }
                        }
                        ?>
                        %
                    </td>
                    <td class="total">
                        <?php
                        $total = $invoiceItem->rate * $invoiceItem->quantity;
                        $total = $total - $total * $invoiceItem->discount_perc/100;
                        $totalAmount += $total;
                        $totalTax += $total * $taxPerc/100;
                        $total = $total + $total * $taxPerc/100;
                        echo $total;
                        ?>
                    </td>
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
                <td><?php echo $sno+1; ?></td>
                <td><input class="form-control input_item" type="text" autocomplete="off" placeholder="Item Name" name="itemNames[]" style="width: 300px;"></td>
                <td><input class="form-control input_rate" type="number" min="0" autocomplete="off" placeholder="Rate" name="itemRates[]" style="width: 100px;"></td>
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
                <td><input class="form-control input_quantity" type="number" min="0" autocomplete="off" placeholder="Qty" style="width: 100px;" name="itemQuantities[]"></td>
                <td><input class="form-control input_discount" type="number" min="0" max="100" autocomplete="off" placeholder="Discount" style="width: 100px;" name="itemDiscounts[]"></td>
                <td>
                    <select class="form-control sel_tax select_taxRate" style="width: 110px;" name="itemTaxRates[]">
                        <option value>Tax Rate</option>
                        <?php
                        foreach($taxTypes as $type)
                        {
                            ?>
                            <option value="<?php echo $type->tax_type_id; ?>"><?php echo $type->tax_perc; ?>%</option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
                <td class="txt_total">0</td>
                <td>
                    <button class="btn btn-default btn-sm but_add" type="button" id="but_add">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </td>
            </tr>
        </table>
    </div>
    <div class="row col-md-12">
        <div class="col-md-4"></div>
        <div class="col-md-4 center-block">
            <table class="table table-striped table-condensed">
                <tr>
                    <td>Total</td>
                    <td id="txt_total"><?php echo $totalAmount; ?></td>
                </tr>

                <tr>
                    <td>Tax Amount</td>
                    <td id="txt_tax"><?php echo $totalTax; ?></td>
                </tr>
                <tr>
                    <td>Freight</td>
                    <td id="txt_freight"><?php echo $invoiceDetails->invoice_freight_charge; ?></td>
                </tr>
                <tr>
                    <td>Grand Total</td>
                    <td id="txt_grandTotal"><?php echo $totalAmount + $totalTax + $invoiceDetails->invoice_freight_charge; ?></td>
                </tr>
                <tr>
                    <td>Received</td>
                    <td>
                        <input type="number" min="0" name="invoiceReceivedAmount" id="input_received" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>Balance</td>
                    <td id="txt_balance"></td>
                </tr>
            </table>
        </div>
        <div class="col-md-4"></div>
    </div>
    <form role="form" class="form_hidden" method="post" action="#">
        <div class="row col-md-12">
            <a href="/<?php echo BASEURL; ?>index.php/Billing/addAccessoryItems/<?php echo $invoiceDetails->invoice_id; ?>" class="btn center-block">Add accessory items</a>
        </div>
        <div class="row col-md-12">
            <input type="submit" value="Proceed" class="btn btn-default btn-lg center-block">
        </div>
    </form>
</div>



<script>
    $(document).ready(function ()
    {
        var nItems = <?php echo $sno; ?>;
        var invoiceFreight = <?php echo $invoiceDetails->invoice_freight_charge; ?>;

        $('.input_item').typeahead({
            remote: '/<?php echo BASEURL ?>index.php/AJAX/invoiceItemSuggestions?keyword=%QUERY'
        });

        $('.but_add').click(addButtonHandler);
        $('.input_discount, .input_quantity, .input_rate, .select_taxRate').change(setTotalAmount);
        $('#input_received').change(function ()
        {
            var balance = $('#txt_balance').text();
            if(balance == "")
                balance = 0;
            else
                balance = parseFloat(balance);
            $('#txt_balance').text(parseFloat($('#txt_grandTotal').text()) - parseFloat($('#input_received').val()));
        });

        function addButtonHandler()
        {
            var itemAttrs = {
                item: $('.input_item').val(),
                rate: $('.input_rate').val(),
                unit: $('.select_unit').val(),
                quantity: $('.input_quantity').val(),
                discount: $('.input_discount').val(),
                tax: $('.select_taxRate').val()
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
            itemAttrs.tax = $('.select_taxRate option:selected').text();
            addItemToTable(itemAttrs);
            clearInputs();
            $('.table_billItems tr:last-child td:first-child').text(nItems+1);
            setInvoiceAmounts(itemAttrs.rate, itemAttrs.quantity, itemAttrs.discount, itemAttrs.tax);
            rate = tax = discount = quantity = 0;
        }

        function addItemToTable(item)
        {
            var trNode = document.createElement("tr");
            var tdNode = document.createElement("td");
            tdNode.innerText = ++nItems;
            trNode.appendChild(tdNode);
            for(var x in item)
            {
                tdNode = document.createElement("td");
                tdNode.innerText = item[x];
                trNode.appendChild(tdNode);
            }
            tdNode = document.createElement("td");
            tdNode.innerText = $('.txt_total').text();
            $(tdNode).addClass("total");
            trNode.appendChild(tdNode);

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
            $('.input_rate').val(null);
            $('.select_unit').val(null);
            $('.input_quantity').val(null);
            $('.input_discount').val(null);
            $('.select_taxRate').val(null);
            $('.txt_total').text("0");
        }

        function verify(attrs)
        {
            for(x in attrs)
            {
                if(attrs[x] == "")
                {
                    return false;
                }
            }
            return true;
        }

        var rate=0, quantity=0, discount=0, tax=0;

        function setTotalAmount()
        {
            var classVal = $(this).attr("class");
            var classes  = classVal.split(' ');

            if($.inArray('input_rate', classes) != -1)
            {
                if($(this).val() != "")
                    rate = $(this).val();
                else
                    rate = 0;
            }
            else if($.inArray('input_quantity', classes) != -1)
            {
                if($(this).val() != "")
                    quantity = $(this).val()
                else
                    quantity = 0;
            }
            else if($.inArray('input_discount', classes) != -1)
            {
                if($(this).val() != "")
                    discount = $(this).val();
                else
                    discount = 0;
            }
            else if($.inArray('select_taxRate', classes) != -1)
            {
                if($(this).val() != "")
                {
                    tax = $('option:selected', $(this)).text();
                    tax = tax.replace(/%$/, "");
                }
                else
                    tax = 0;
            }
            $('.txt_total').text(calculateAmount(rate, quantity, discount, tax));
        }

        function setInvoiceAmounts(rate, quantity, discount, tax)
        {
            var total = calculateTotal(rate, quantity, discount);
            var invoiceTotal = parseInt($('#txt_total').text()) + total;
            var invoiceTax = parseInt($('#txt_tax').text()) + calculateTax(total, tax.replace(/%$/, ""));
            $('#txt_total').text(invoiceTotal);
            $('#txt_tax').text(invoiceTax);
            $('#txt_grandTotal').text(invoiceTotal + invoiceTax + invoiceFreight);
        }

        function calculateAmount(rate, quantity, discount, tax)
        {
            var amount = calculateTotal(rate, quantity, discount);
            amount = amount + calculateTax(amount, tax);
            return amount;
        }

        function calculateTotal(rate, quantity, discount)
        {
            var total = rate * quantity;
            total = total- (total * discount/100);
            return total;
        }

        function calculateTax(total, tax)
        {
            var taxVal = (total * tax/100);
            return taxVal;
        }
    })
</script>