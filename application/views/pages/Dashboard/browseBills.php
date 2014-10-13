<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 10/10/14
 * Time: 8:44 PM
 */
?>

<style type="text/css">
    h3
    {
        display: inline-flex;
    }
    h3 + h3
    {
        margin-left:20px;
    }
    .tt-dropdown-menu
    {
        width: 100%;
    }
    .tt-hint
    {
        width: 100%;
    }
    .typeahead
    {
        width: 100%;
    }
</style>

<div class="container" style="width:100%;">
    <div class="row">
        <div class="col-md-2">
            <form id="form_searchCriteria" action="#" method="get">
                <div class="form-group" style="max-height: 200px; overflow-y: auto;">
                    <label>Invoice Type</label>
                    <ul class="list-group">
                        <?php
                        foreach($invoiceTypes as $invoiceTypeId=>$invoiceType)
                        {
                            ?>
                            <li class="list-group-item">
                                <input type="checkbox" name="invoiceType" value="<?php echo $invoiceTypeId; ?>"
                                    <?php if($invoiceTypeVal == $invoiceTypeId) echo "checked"; ?>>
                                <?php echo $invoiceType['typeName']; ?>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="form-group">
                    <label>Consignee</label>
                    <input type="text" name="consigneeName" id="input_consigneeName" class="form-control typeahead" autocomplete="off" value="<?php echo $consigneeNameVal; ?>">
                </div>
                <div class="form-group">
                    <label>TIN Number</label>
                    <input type="text" name="consigneeTIN" id="input_consigneeTin" class="form-control typeahead" autocomplete="off" value="<?php echo $consigneeTINVal; ?>">
                </div>
                <div class="form-group">
                    <label>Book Number</label>
                    <input type="text" name="bookNo" class="form-control" value="<?php echo $bookNoVal; ?>">
                </div>
                <div class="form-group">
                    <label>Invoice Number</label>
                    <input type="text" name="invoiceNo" class="form-control" value="<?php echo $invoiceNoVal; ?>">
                </div>
                <div class="form-group">
                    <label>Date From</label>
                    <input type="date" name="dateFrom" class="form-control" value="<?php echo $dateFromVal; ?>">
                </div>
                <div class="form-group">
                    <label>Date Upto</label>
                    <input type="date" name="dateUpto" class="form-control" value="<?php echo $dateUptoVal; ?>">
                </div>
                <div class="form-group">
                    <input type="checkbox" class=>
                    <label>Show cancelled bills</label>
                </div>
                <input type="hidden" name="sortBy" id="input_sortBy" value>
                <input type="hidden" name="sortOrder" id="input_sortOrder" value>
            </form>
        </div>
        <div class="col-md-10">
            <div class="row">
            </div>
            <div class="row">
                <table class="col-md-8 table table-hover table-bordered table-condensed">
                    <tr>
                        <th style="width: 10px;">#</th>
                        <th>
                            Consignee
                        </th>
                        <th>
                            TIN No
                        </th>
                        <th>
                            Date
                            <span class="pull-right">
                                <a><span class="glyphicon glyphicon-chevron-up sort_desc" value="invoiceDate"></span></a>
                                <a><span class="glyphicon glyphicon-chevron-down sort_asc" value="invoiceDate"></span></a>
                            </span>
                        </th>
                        <th>
                            Invoice No
                            <span class="pull-right">
                                <a><span class="glyphicon glyphicon-chevron-up sort_desc" value="invoiceNo"></span></a>
                                <a><span class="glyphicon glyphicon-chevron-down sort_asc" value="invoiceNo"></span></a>
                            </span>
                        </th>
                        <th>
                            Book No
                            <span class="pull-right">
                                <a><span class="glyphicon glyphicon-chevron-up sort_desc" value="bookNo"></span></a>
                                <a><span class="glyphicon glyphicon-chevron-down sort_asc" value="bookNo"></span></a>
                            </span>
                        </th>
                        <th>
                            Invoice Type
                        </th>
                        <th>

                        </th>
                    </tr>
                    <?php
                    foreach($invoices as $key=>$invoice)
                    {
                    ?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $consigneeDetails[$invoice->invoice_consignee]; ?></td>
                            <td><?php echo $invoice->invoice_consignee; ?></td>
                            <td><?php echo $invoice->invoice_date; ?></td>
                            <td><?php echo "{$invoiceTypes[$invoice->invoice_type]['typeInitial']}-{$invoice->invoice_no}"; ?></td>
                            <td><?php echo $invoice->invoice_book_no; ?></td>
                            <td><?php echo $invoiceTypes[$invoice->invoice_type]['typeName']; ?></td>
                            <td>
                                <a class="btn btn-sm btn-default" href="/<?php echo BASEURL; ?>index.php/Billing/billPdf/<?php echo $invoice->invoice_id; ?>" target="new">View</a>
                                <a class="btn btn-sm btn-default" href="/<?php echo BASEURL; ?>index.php/Billing/editBill/<?php echo $invoice->invoice_id; ?>">Edit</a>
                                <a class="btn btn-sm btn-default" href="/<?php echo BASEURL; ?>index.php/">Cancel</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function ()
    {
        $('#input_consigneeName').typeahead({
            remote: '/<?php echo BASEURL ?>index.php/AJAX/consigneeSuggestions?searchAttribute=consignee_name&retrieveAttribute=consignee_name&keyword=%QUERY'
        });

        $('#input_consigneeName').bind('typeahead:selected', function(obj, datum, name)
        {
            $('#form_searchCriteria').submit();
        });

        $('#input_consigneeName').bind('typeahead:autocompleted', function(obj, datum, name)
        {
            $('#form_searchCriteria').submit();
        });

        $('#form_searchCriteria input').change(function()
        {
            $('#form_searchCriteria').submit();
        })

        $('#input_consigneeTin').typeahead({
            remote: '/<?php echo BASEURL ?>index.php/AJAX/consigneeSuggestions?searchAttribute=consignee_tin_no&retrieveAttribute=consignee_tin_no&keyword=%QUERY'
        });

        $('#input_consigneeTin').bind('typeahead:selected', function(obj, datum, name)
        {
            $('#form_searchCriteria').submit();
        });

        $('#input_consigneeTin').bind('typeahead:autocompleted', function(obj, datum, name)
        {
            $('#form_searchCriteria').submit();
        });

        $('.sort_desc').click(function()
        {
            $('#input_sortOrder').val("DESC");
            $('#input_sortBy').val($(this).attr("value"));
            $('#form_searchCriteria').submit();
        });

        $('.sort_asc').click(function()
        {
            $('#input_sortOrder').val("ASC");
            $('#input_sortBy').val($(this).attr("value"));
            $('#form_searchCriteria').submit();
        });
    });
</script>