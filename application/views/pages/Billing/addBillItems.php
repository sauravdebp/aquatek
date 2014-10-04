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
            <table class="table">
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
                foreach($invoiceItems as $invoiceItem)
                {
                ?>
                    <tr>
                        <td></td>
                        <td><?php echo $invoiceItem->invoice_item_description; ?></td>
                        <td><?php echo $invoiceItem->rate; ?></td>
                        <td>

                        </td>
                        <td><?php echo $invoiceItem->quantity; ?></td>
                        <td><?php echo $invoiceItem->discount_perc; ?> %</td>
                        <td>

                        </td>
                        <td></td>
                        <td>
                            <button class="btn btn-default btn-sm but_edit" type="button" name="but_add">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                            <button class="btn btn-default btn-sm but_remove" type="button" name="but_add">
                                <span class="glyphicon glyphicon-minus"></span>
                            </button>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td>1</td>
                    <td><input class="form-control txt_item" type="text" placeholder="Item Name" name="itemNames[]" style="width: 300px;"></td>
                    <td><input class="form-control txt_rate" type="text" placeholder="Rate" name="itemRates[]" style="width: 100px;"></td>
                    <td>
                        <select class="form-control" style="width: 80px;" name="itemUnits[]">
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
                    <td><input class="form-control txt_quantity" type="text" placeholder="Qty" style="width: 100px;" name="itemQuantities[]"></td>
                    <td><input class="form-control txt_discount" type="text" placeholder="Discount" style="width: 100px;" name="itemDiscounts[]"></td>
                    <td>
                        <select class="form-control sel_tax" style="width: 110px;" name="itemTaxRates[]">
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
                    <td>0</td>
                    <td>
                        <button class="btn btn-default btn-sm but_add" type="button" id="but_add">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </td>
                </tr>
            </table>
    </div>
    <div class="row col-md-4">
        <div class="row">
            <span class="col-md-5">Total</span>
            <span class="col-md-7" id="txt_total">0</span>
        </div>
        <div class="row">
            <span class="col-md-5">Tax Amount</span>
            <span class="col-md-7" id="txt_tax">0</span>
        </div>
        <div class="row">
            <span class="col-md-5">Freight</span>
            <span class="col-md-7"><?php echo $invoiceDetails->invoice_freight_charge; ?>.00</span>
        </div>
        <div class="row">
            <span class="col-md-5">Grand Total</span>
            <span class="col-md-7">0</span>
        </div>
        <div class="row">
            <span class="col-md-5">Received</span>
            <span class="col-md-7">
                <input type="text" class="form-control" style="height: 20px; width: 50px;">
            </span>
        </div>
        <div class="row">
            <span class="col-md-5">Balance</span>
            <span class="col-md-7">0</span>
        </div>
    </div>
    <form role="form" class="form-horizontal" method="post" action="#">
        <div class="row col-md-12">
            <input type="submit" value="Proceed" class="btn btn-default btn-lg center-block">
        </div>
    </form>
</div>

<script>
    var noofItems = 1;
    var sno = 1;
    $(document).ready(function ()
    {
        function add()
        {
            if(!verify())
                return;
            var html =  "<tr>" +
                "<td>" + $('.table tbody tr:last-child td:first').text() + "</td>" +
                "<td>" + $('.table tbody tr:last-child td:nth-child(2) input:nth-child(2)').val() + "</td>" +
                "<td>" + $('.table tbody tr:last-child td:nth-child(3) input').val() + "</td>" +
                "<td>" + $('.table tbody tr:last-child td:nth-child(4) select option:selected').text() + "</td>" +
                "<td>" + $('.table tbody tr:last-child td:nth-child(5) input').val() + "</td>" +
                "<td>" + $('.table tbody tr:last-child td:nth-child(6) input').val() + "</td>" +
                "<td>" + $('.table tbody tr:last-child td:nth-child(7) select option:selected').text() + "</td>" +
                "<td>" + $('.table tbody tr:last-child td:nth-child(8)').text() + "</td>" +
                "<td>" +
                "<button class=\"btn btn-default btn-sm but_edit\" type=\"button\" name=\"but_add\">" +
                "<span class=\"glyphicon glyphicon-pencil\"></span>" +
                "</button>" +
                "<button class=\"btn btn-default btn-sm but_remove\" type=\"button\" name=\"but_add\">" +
                "<span class=\"glyphicon glyphicon-minus\"></span>" +
                "</button>" +
                "</td>" +
                "</tr>";
            $('.table tbody tr:nth-child(' + (noofItems+1) + ')').hide();
            $('.table tbody tr:nth-child(' + (noofItems+1) + ')').parent().append(html);
            $('.table tbody:last-child').append("<tr>" + $('.table tbody tr:nth-last-child(2)').html() + "</tr>");
            noofItems += 2;
            $('.table tbody tr:last-child td:first').text(++sno);
            $('.but_add').click(add);
            $('.but_remove').unbind();
            $('.but_remove').click(remove);
            $('.txt_rate, .txt_quantity, .txt_discount, .sel_tax').unbind();
            $('.txt_rate, .txt_quantity, .txt_discount, .sel_tax').change(setTotalAmount);
            $('.txt_item').typeahead({
                remote: '/<?php echo BASEURL ?>index.php/AJAX/invoiceItemSuggestions?keyword=%QUERY'
            });
            rate=0, quantity=0, discount=0, tax=0;
        }

        function remove()
        {
            $(this).parent().parent().prev().remove();
            $(this).parent().parent().remove();
            noofItems -= 2;
        }

        function verify()
        {
            if( $('.table tbody tr:last-child td:nth-child(2) input:nth-child(2)').val() == "" ||
                $('.table tbody tr:last-child td:nth-child(3) input').val() == "" ||
                $('.table tbody tr:last-child td:nth-child(4) select').val() == "" ||
                $('.table tbody tr:last-child td:nth-child(5) input').val() == "" ||
                $('.table tbody tr:last-child td:nth-child(7) select').val() == ""
                )
            {
                return false;
            }
            return true;
        }

        var rate=0, quantity=0, discount=0, tax=0;

        function setTotalAmount()
        {
            var classVal = $(this).attr("class");
            var classes  = classVal.split(' ');

            if($.inArray('txt_rate', classes) != -1)
            {
                if($(this).val() != "")
                    rate = $(this).val();
                else
                    rate = 0;
            }
            else if($.inArray('txt_quantity', classes) != -1)
            {
                if($(this).val() != "")
                    quantity = $(this).val()
                else
                    quantity = 0;
            }
            else if($.inArray('txt_discount', classes) != -1)
            {
                if($(this).val() != "")
                    discount = $(this).val();
                else
                    discount = 0;
            }
            else if($.inArray('sel_tax', classes) != -1)
            {
                if($(this).val() != "")
                {
                    tax = $('option:selected', $(this)).text();
                    tax = tax.replace(/%$/, "");
                }
                else
                    tax = 0;
            }
            //alert(calculateAmount(rate, quantity, discount, tax));
            $('td:nth-last-child(2)', $(this).parents('tr')).text(calculateAmount(rate, quantity, discount, tax));
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

        $('.txt_rate, .txt_quantity, .txt_discount, .sel_tax').change(setTotalAmount);
        $('.but_add').click(add);
        $('.txt_item').typeahead({
            remote: '/<?php echo BASEURL ?>index.php/AJAX/invoiceItemSuggestions?keyword=%QUERY'
        });
    });
</script>