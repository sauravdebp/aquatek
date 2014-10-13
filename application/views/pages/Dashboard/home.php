<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 10/12/14
 * Time: 12:21 AM
 */
?>

<style>
    html, body, .container {
        height: 93%;
    }
    .container {
        display: table;
        vertical-align: middle;
    }
    .vertical-center-row {
        display: table-cell;
        vertical-align: middle;
    }
</style>

<div class="container">
    <div class="row vertical-center-row">
        <div class="col-md-2"></div>
        <div class="col-md-8" style="/*background-color: #bce8f1; */padding-top: 15px; border-radius: 4px;">
            <div class="row">
                <div class="col-md-6">
                    <a href="/<?php echo BASEURL; ?>index.php/Billing/newBill" class="thumbnail" style="text-align: center; font-size: 5em; ">
                        <span class="glyphicon glyphicon-plus"></span>
                        <div class="caption">
                            <h5>New Invoice</h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="/<?php echo BASEURL; ?>index.php/Dashboard/browseBills" class="thumbnail" style="text-align: center; font-size: 5em;">
                        <span class="glyphicon glyphicon-list-alt"></span>
                        <div class="caption">
                            <h5>Browse Invoices</h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="#" class="thumbnail" style="text-align: center; font-size: 5em;">
                        <span class="glyphicon glyphicon-stats"></span>
                        <div class="caption">
                            <h5>Analytics</h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="#" class="thumbnail" style="text-align: center; font-size: 5em;">
                        <span class="glyphicon glyphicon-off"></span>
                        <div class="caption">
                            <h5>Sign Out</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>