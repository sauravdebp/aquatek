<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 9/23/14
 * Time: 8:59 AM
 */
?>

<div class="col-md-10">
    <!--<center><h1>Create new Invoice</h1></center>
    <br><br>-->
    <div class="col-md-4"></div>
    <form role="form" class="col-md-4" method="post">
        <div class="form-group row" style="color: #ac2925; font-size: .9em;">
            <?php
                if(validation_errors())
                {
                    echo validation_errors('<div class="row col-sm-12">', '</div>');
                }
                if(isset($updateMessage))
                {
                ?>
                    <div class="alert alert-success" role="alert"><?php echo $updateMessage; ?></div>
                <?php
                }
                ?>
        </div>

        <div class="form-group <?php if(form_error("invoiceType") != "") echo "has-error"; ?>">
            <label for="invoiceType">Invoice Type</label>
            <select class="form-control" id="invoiceType" name="invoiceType">
                <option value>Select Invoice Type</option>
                <?php
                foreach($invoiceTypes as $type)
                {
                ?>
                <option value="<?php echo $type->invoice_type_id; ?>"
                        <?php
                        if(set_value("invoiceType") == $type->invoice_type_id || (isset($invoiceDetails) && $invoiceDetails->invoice_type == $type->invoice_type_id))
                            echo "selected";
                        ?>>
                    <?php echo $type->invoice_type_name; ?>
                </option>
                <?php
                }
                ?>
            </select>
        </div>

        <div class="form-group <?php if(form_error("invoiceDate")) echo "has-error"; ?>">
            <label for="invoiceDate">Invoice Date</label>
            <input class="form-control" type="date" id="invoiceDate" name="invoiceDate"
                   value=
                   "<?php
                    if(set_value("invoiceDate"))
                        echo set_value("invoiceDate");
                    else if(isset($invoiceDetails))
                        echo $invoiceDetails->invoice_date;
                   ?>">
        </div>

        <div class="form-group <?php if(form_error("invoiceConsigneeName")) echo "has-error"; ?>">
            <div>
                <label for="invoiceConsigneeName">Company Name</label>
            </div>
            <input type="text" class="form-control typeahead" id="invoiceConsigneeName" name="invoiceConsigneeName" placeholder="Company Name"
                   value=
                   "<?php
                    if(set_value("invoiceConsigneeName"))
                        echo set_value("invoiceConsigneeName");
                    else if(isset($consigneeDetails))
                        echo $consigneeDetails->consignee_name;
                   ?>">
        </div>

        <div class="form-group <?php if(form_error("invoiceConsigneeTIN")) echo "has-error"; ?>">
            <div>
                <label for="invoiceConsigneeTIN">Consignee TIN No.</label>
            </div>
            <input type="text" class="form-control typeahead" id="invoiceConsigneeTIN" name="invoiceConsigneeTIN" placeholder="Consignee TIN No."
                   value=
                   "<?php
                    if(set_value("invoiceConsigneeTIN"))
                        echo set_value("invoiceConsigneeTIN");
                    else if(isset($consigneeDetails))
                        echo $consigneeDetails->consignee_tin_no;
                   ?>">
        </div>

        <div class="form-group <?php if(form_error("invoiceConsigneeContactPerson")) echo "has-error"; ?>">
            <label for="invoiceConsigneeContactPerson">Authorised Contact Person</label>
            <input type="text" class="form-control" id="invoiceConsigneeContactPerson" name="invoiceConsigneeContactPerson" placeholder="Contact Person"
                   value=
                   "<?php
                    if(set_value("invoiceConsigneeContactPerson"))
                        echo set_value("invoiceConsigneeContactPerson");
                   else if(isset($consigneeDetails))
                        echo $consigneeDetails->consignee_contact_person;
                   ?>">
        </div>

        <div class="form-group <?php if(form_error("invoiceConsigneeContactPersonMobile")) echo "has-error"; ?>">
            <label for="invoiceConsigneeContactPersonMobile">Consignee Authorised Tel/Mobile No.</label>
            <input type="text" class="form-control" id="invoiceConsigneeContactPersonMobile" name="invoiceConsigneeContactPersonMobile" placeholder="Contact Number"
                   value=
                   "<?php
                    if(set_value("invoiceConsigneeContactPersonMobile"))
                        echo set_value("invoiceConsigneeContactPersonMobile");
                   else if(isset($consigneeDetails))
                        echo $consigneeDetails->consignee_contact_mobile;
                   ?>">
        </div>

        <div class="form-group <?php if(form_error("invoiceConsigneeAddressStreet") || form_error("invoiceConsigneeAddressCity") || form_error("invoiceConsigneeAddressState") || form_error("invoiceConsigneeAddressPincode")) echo "has-error"; ?>">
            <label for="invoiceConsigneeAddress">Bill To</label>
            <div>
                <div class="form-group <?php if(form_error("invoiceConsigneeAddressStreet")) echo "has-error"; ?>">
                    <label for="invoiceConsigneeAddressStreet" class="sr-only">Street Address</label>
                    <input type="text" class="form-control" id="invoiceConsigneeAddressStreet" name="invoiceConsigneeAddressStreet" placeholder="Street Address"
                           value=
                           "<?php
                            if(set_value("invoiceConsigneeAddressStreet"))
                                echo set_value("invoiceConsigneeAddressStreet");
                            else if(isset($consigneeDetails))
                                echo $consigneeDetails->consignee_address_street;
                           ?>">
                </div>
                <div class="form-group <?php if(form_error("invoiceConsigneeAddressCity")) echo "has-error"; ?>">
                    <label for="invoiceConsigneeAddressCity" class="sr-only">City</label>
                    <input type="text" class="form-control" id="invoiceConsigneeAddressCity" name="invoiceConsigneeAddressCity" placeholder="City"
                           value=
                           "<?php
                           if(set_value("invoiceConsigneeAddressCity"))
                               echo set_value("invoiceConsigneeAddressCity");
                           else if(isset($consigneeDetails))
                               echo $consigneeDetails->consignee_address_city;
                           ?>">
                </div>
                <div class="form-group <?php if(form_error("invoiceConsigneeAddressState")) echo "has-error"; ?>">
                    <label for="invoiceConsigneeAddressState" class="sr-only">State</label>
                    <input type="text" class="form-control" id="invoiceConsigneeAddressState" name="invoiceConsigneeAddressState" placeholder="State"
                           value=
                           "<?php
                           if(set_value("invoiceConsigneeAddressState"))
                               echo set_value("invoiceConsigneeAddressState");
                           else if(isset($consigneeDetails))
                               echo $consigneeDetails->consignee_address_state;
                           ?>">
                </div>
                <div class="form-group <?php if(form_error("invoiceConsigneeAddressPincode")) echo "has-error"; ?>">
                    <label for="invoiceConsigneeAddressPincode" class="sr-only">Pincode</label>
                    <input type="text" class="form-control" id="invoiceConsigneeAddressPincode" name="invoiceConsigneeAddressPincode" placeholder="Pincode"
                           value=
                           "<?php
                           if(set_value("invoiceConsigneeAddressPincode"))
                               echo set_value("invoiceConsigneeAddressPincode");
                           else if(isset($consigneeDetails))
                               echo $consigneeDetails->consignee_address_pincode;
                           ?>">
                </div>
            </div>
        </div>

        <div class="form-group <?php if(form_error("invoiceVehicleNo")) echo "has-error"; ?>">
            <label for="invoiceVehicleNo">Vehicle No.</label>
            <input type="text" class="form-control" id="invoiceVehicleNo" name="invoiceVehicleNo" placeholder="Vehicle No."
                   value=
                   "<?php
                   if(set_value("invoiceVehicleNo"))
                       echo set_value("invoiceVehicleNo");
                   else if(isset($invoiceDetails))
                       echo $invoiceDetails->invoice_vehicle_no;
                   ?>">
        </div>

        <div class="form-group <?php if(form_error("invoiceGrBillTno")) echo "has-error"; ?>">
            <label for="invoiceGrBillTno">GR/Bill T No.</label>
            <input type="text" class="form-control" id="invoiceGrBillTno" name="invoiceGrBillTno" placeholder="GR/Bill T No."
                   value=
                   "<?php
                   if(set_value("invoiceGrBillTno"))
                       echo set_value("invoiceGrBillTno");
                   else if(isset($invoiceDetails))
                       echo $invoiceDetails->invoice_gr_bill_tno;
                   ?>">
        </div>

        <div class="form-group <?php if(form_error("invoiceRoadPermitNo")) echo "has-error"; ?>">
            <label for="invoiceRoadPermitNo">Road Permit No.</label>
            <input type="text" class="form-control" id="invoiceRoadPermitNo" name="invoiceRoadPermitNo" placeholder="Road Permit No."
                   value=
                   "<?php
                   if(set_value("invoiceRoadPermitNo"))
                       echo set_value("invoiceRoadPermitNo");
                   else if(isset($invoiceDetails))
                       echo $invoiceDetails->invoice_road_permit_no;
                   ?>">
        </div>

        <div class="form-group <?php if(form_error("invoiceFreightCharge")) echo "has-error"; ?>">
            <label for="invoiceFreightCharge">Freight Charge</label>
            <input type="text" class="form-control" id="invoiceFreightCharge" name="invoiceFreightCharge" placeholder="Freight Charge"
                   value=
                   "<?php
                   if(set_value("invoiceFreightCharge"))
                       echo set_value("invoiceFreightCharge");
                   else if(isset($invoiceDetails))
                       echo $invoiceDetails->invoice_freight_charge;
                   ?>">
        </div>

        <div class="form-group">
            <input type="submit" value="Proceed" class="btn btn-default btn-lg center-block">
        </div>
        <?php
        if(isset($invoiceDetails))
        {
        ?>
            <input type="hidden" name="detailsUpdated" value="true">
        <?php
        }
        ?>
    </form>
</div>

<script type="text/javascript">
    // Waiting for the DOM ready...
    $(function(){

        $('#invoiceConsigneeTIN').typeahead({
            remote: '/<?php echo BASEURL ?>index.php/AJAX/consigneeSuggestions?searchAttribute=consignee_tin_no&retrieveAttribute=consignee_tin_no&keyword=%QUERY'
        });

        $('#invoiceConsigneeTIN').bind('typeahead:selected', function(obj, datum, name) {
            $.get("/<?php echo BASEURL; ?>index.php/AJAX/consigneeDetailsByTIN?consigneeTIN=" + $('#invoiceConsigneeTIN').val(), function(data, status) {
                //alert("Data: " + data + "\nStatus: " + status);
                var details = JSON.parse(data);
                $('#invoiceConsigneeContactPerson').val(details.consignee_contact_person);
                $('#invoiceConsigneeContactPersonMobile').val(details.consignee_contact_mobile);
                $('#invoiceConsigneeName').val(details.consignee_name);
                $('#invoiceConsigneeAddressStreet').val(details.consignee_address_street);
                $('#invoiceConsigneeAddressCity').val(details.consignee_address_city);
                $('#invoiceConsigneeAddressState').val(details.consignee_address_state);
                $('#invoiceConsigneeAddressPincode').val(details.consignee_address_pincode);
            });
        });

        $('#invoiceConsigneeTIN').bind('typeahead:autocompleted', function(obj, datum, name) {
            $.get("/<?php echo BASEURL; ?>index.php/AJAX/consigneeDetailsByTIN?consigneeTIN=" + $('#invoiceConsigneeTIN').val(), function(data, status) {
                //alert("Data: " + data + "\nStatus: " + status);
                var details = JSON.parse(data);
                $('#invoiceConsigneeContactPerson').val(details.consignee_contact_person);
                $('#invoiceConsigneeContactPersonMobile').val(details.consignee_contact_mobile);
                $('#invoiceConsigneeName').val(details.consignee_name);
                $('#invoiceConsigneeAddressStreet').val(details.consignee_address_street);
                $('#invoiceConsigneeAddressCity').val(details.consignee_address_city);
                $('#invoiceConsigneeAddressState').val(details.consignee_address_state);
                $('#invoiceConsigneeAddressPincode').val(details.consignee_address_pincode);
            });
        });

        $('#invoiceConsigneeName').typeahead({
            remote: '/<?php echo BASEURL ?>index.php/AJAX/consigneeSuggestions?searchAttribute=consignee_name&retrieveAttribute=consignee_name&keyword=%QUERY'
        });

        $('#invoiceConsigneeName').bind('typeahead:selected', function(obj, datum, name) {
            $.get("/<?php echo BASEURL; ?>index.php/AJAX/consigneeDetailsByName?consigneeName=" + $('#invoiceConsigneeName').val(), function(data, status)
            {
                //alert("Data: " + data + "\nStatus: " + status);
                var details = JSON.parse(data);
                $('#invoiceConsigneeContactPerson').val(details.consignee_contact_person);
                $('#invoiceConsigneeContactPersonMobile').val(details.consignee_contact_mobile);
                $('#invoiceConsigneeTIN').val(details.consignee_tin_no);
                $('#invoiceConsigneeAddressStreet').val(details.consignee_address_street);
                $('#invoiceConsigneeAddressCity').val(details.consignee_address_city);
                $('#invoiceConsigneeAddressState').val(details.consignee_address_state);
                $('#invoiceConsigneeAddressPincode').val(details.consignee_address_pincode);
            });
        });

        $('#invoiceConsigneeName').bind('typeahead:autocompleted', function(obj, datum, name) {
            $.get("/<?php echo BASEURL; ?>index.php/AJAX/consigneeDetailsByName?consigneeName=" + $('#invoiceConsigneeName').val(), function(data, status) {
                //alert("Data: " + data + "\nStatus: " + status);
                var details = JSON.parse(data);
                $('#invoiceConsigneeContactPerson').val(details.consignee_contact_person);
                $('#invoiceConsigneeContactPersonMobile').val(details.consignee_contact_mobile);
                $('#invoiceConsigneeTIN').val(details.consignee_tin_no);
                $('#invoiceConsigneeAddressStreet').val(details.consignee_address_street);
                $('#invoiceConsigneeAddressCity').val(details.consignee_address_city);
                $('#invoiceConsigneeAddressState').val(details.consignee_address_state);
                $('#invoiceConsigneeAddressPincode').val(details.consignee_address_pincode);
            });
        });
    });
</script>