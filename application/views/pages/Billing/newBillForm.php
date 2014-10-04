<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 9/23/14
 * Time: 8:59 AM
 */
?>

<div class="container">
    <center><h1>Create new Invoice</h1></center>
    <br><br>
    <form role="form" class="form-horizontal" method="post">
        <div class="form-group">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <?php echo validation_errors(); ?>
            </div>
        </div>
        <div class="form-group <?php if(form_error("invoiceType") != "") echo "has-error"; ?>">
            <label for="invoiceType" class="col-sm-4 control-label">Invoice Type</label>
            <div class="col-sm-4">
                <select class="form-control" id="invoiceType" name="invoiceType" value="<?php echo set_value("invoiceType"); ?>">
                    <option value>Select Invoice Type</option>
                    <?php
                    foreach($invoiceTypes as $id=>$type)
                    {
                    ?>
                    <option value="<?php echo $id; ?>"><?php echo $type; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group <?php if(form_error("invoiceDate") != "") echo "has-error"; ?>">
            <label for="invoiceDate" class="col-sm-4 control-label">Invoice Date</label>
            <div class="col-sm-4">
                <input class="form-control" type="date" id="invoiceDate" name="invoiceDate" value="<?php echo set_value("invoiceDate"); ?>">
            </div>
        </div>

        <div class="form-group <?php if(form_error("invoiceConsigneeName") != "") echo "has-error"; ?>">
            <label for="invoiceConsigneeName" class="col-sm-4 control-label">Company Name</label>
            <div class="col-sm-4">
                <input type="text" class="form-control typeahead" id="invoiceConsigneeName" name="invoiceConsigneeName" placeholder="Company Name" value="<?php echo set_value("invoiceConsigneeName"); ?>">
            </div>
        </div>

        <div class="form-group <?php if(form_error("invoiceConsigneeTIN") != "") echo "has-error"; ?>">
            <label for="invoiceConsigneeTIN" class="col-sm-4 control-label">Consignee TIN No.</label>
            <div class="col-sm-4">
                <input  type="text" class="form-control typeahead" id="invoiceConsigneeTIN" name="invoiceConsigneeTIN" placeholder="Consignee TIN No." value="<?php echo set_value("invoiceConsigneeTIN"); ?>">
            </div>
        </div>

        <div class="form-group <?php if(form_error("invoiceConsigneeContactPerson") != "") echo "has-error"; ?>">
            <label for="invoiceConsigneeContactPerson" class="col-sm-4 control-label">Authorised Contact Person</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="invoiceConsigneeContactPerson" name="invoiceConsigneeContactPerson" placeholder="Contact Person" value="<?php echo set_value("invoiceConsigneeContactPerson"); ?>">
            </div>
        </div>

        <div class="form-group <?php if(form_error("invoiceConsigneeContactPersonMobile") != "") echo "has-error"; ?>">
            <label for="invoiceConsigneeContactPersonMobile" class="col-sm-4 control-label">Consignee Authorised Tel/Mobile No.</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="invoiceConsigneeContactPersonMobile" name="invoiceConsigneeContactPersonMobile" placeholder="Contact Number" value="<?php echo set_value("invoiceConsigneeContactPersonMobile"); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="invoiceConsigneeAddress" class="col-sm-4 control-label">Bill To</label>
            <div class="col-sm-4">
                <div class="form-group <?php if(form_error("invoiceConsigneeAddressStreet") != "") echo "has-error"; ?>">
                    <label for="invoiceConsigneeAddressStreet" class="col-sm-0 control-label sr-only">Street Address</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="invoiceConsigneeAddressStreet" name="invoiceConsigneeAddressStreet" placeholder="Street Address" value="<?php echo set_value("invoiceConsigneeAddressStreet"); ?>">
                    </div>
                </div>
                <div class="form-group <?php if(form_error("invoiceConsigneeAddressCity") != "") echo "has-error"; ?>">
                    <label for="invoiceConsigneeAddressCity" class="col-sm-0 control-label sr-only">City</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="invoiceConsigneeAddressCity" name="invoiceConsigneeAddressCity" placeholder="City" value="<?php echo set_value("invoiceConsigneeAddressCity"); ?>">
                    </div>
                </div>
                <div class="form-group <?php if(form_error("invoiceConsigneeAddressState") != "") echo "has-error"; ?>">
                    <label for="invoiceConsigneeAddressState" class="col-sm-0 control-label sr-only">State</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="invoiceConsigneeAddressState" name="invoiceConsigneeAddressState" placeholder="State" value="<?php echo set_value("invoiceConsigneeAddressState"); ?>">
                    </div>
                </div>
                <div class="form-group <?php if(form_error("invoiceConsigneeAddressPincode") != "") echo "has-error"; ?>">
                    <label for="invoiceConsigneeAddressPincode" class="col-sm-0 control-label sr-only">Pincode</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="invoiceConsigneeAddressPincode" name="invoiceConsigneeAddressPincode" placeholder="Pincode" value="<?php echo set_value("invoiceConsigneeAddressPincode"); ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="invoiceVehicleNo" class="col-sm-4 control-label">Vehicle No.</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="invoiceVehicleNo" name="invoiceVehicleNo" placeholder="Vehicle No." value="<?php echo set_value("invoiceVehicleNo"); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="invoiceGrBillTno" class="col-sm-4 control-label">GR/Bill T No.</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="invoiceGrBillTno" name="invoiceGrBillTno" placeholder="GR/Bill T No." value="<?php echo set_value("invoiceGrBillTno"); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="invoiceRoadPermitNo" class="col-sm-4 control-label">Road Permit No.</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="invoiceRoadPermitNo" name="invoiceRoadPermitNo" placeholder="Road Permit No." value="<?php echo set_value("invoiceRoadPermitNo"); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="invoiceFreightCharge" class="col-sm-4 control-label">Freight Charge</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="invoiceFreightCharge" name="invoiceFreightCharge" placeholder="Freight Charge" value="<?php echo set_value("invoiceFreightCharge"); ?>">
            </div>
        </div>

        <div class="form-group">
            <input type="submit" value="Proceed" class="btn btn-default btn-lg center-block">
        </div>
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