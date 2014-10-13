<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 10/12/14
 * Time: 3:09 PM
 */
$invoiceCreated = false;
$invoiceItemsAdded = false;
$invoiceAccessoryItemsAdded = false;

if(isset($_SESSION['Billing']['newBill']['invoiceId']))
{
    $invoiceCreated = true;
}
if(isset($_SESSION['Billing']['addBillItems']['itemsAdded']))
{
    $invoiceItemsAdded = true;
}
if(isset($_SESSION['Billing']['addAccessoryItems']['accessoryItemsAdded']))
{
    $invoiceAccessoryItemsAdded = true;
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" style="/*background-color: #bce8f1; */border-radius: 4px; height: 100%;">
                <?php
                if($invoiceCreated)
                {
                ?>
                    <a href="/<?php echo BASEURL; ?>index.php/Billing/editBill/<?php echo $_SESSION['Billing']['newBill']['invoiceId']; ?>" class="thumbnail <?php if($page=="newBillForm") echo "active"; ?>">
                    <span style="font-size: 1.5em;" class="glyphicon glyphicon-check"></span>
                <?php
                }
                else
                {
                ?>
                    <a href="/<?php echo BASEURL; ?>index.php/Billing/newBill" class="thumbnail <?php if($page=="newBillForm") echo "active"; ?>">
                    <span style="font-size: 1.5em;" class="glyphicon glyphicon-unchecked"></span>
                <?php
                }
                ?>
                <?php if($invoiceCreated) echo "Edit"; else echo "Add";?> invoice details
            </a>
            <!-- do not close below a tag here!. Look ahead you'll understand why. -->
            <a
                <?php
                if(isset($_SESSION['Billing']['newBill']['invoiceId']))
                {
                ?>
                    href="/<?php echo BASEURL; ?>index.php/Billing/addBillItems/<?php echo $_SESSION['Billing']['newBill']['invoiceId']; ?>"
                <?php
                }
                ?>
                class="thumbnail <?php if($page=="addBillItems") echo "active"; ?>">
                <?php
                if($invoiceCreated && !$invoiceItemsAdded)
                {
                ?>
                    <span style="font-size: 1.5em;" class="glyphicon glyphicon-unchecked"></span>
                <?php
                }
                else if($invoiceCreated && $invoiceItemsAdded)
                {
                ?>
                    <span style="font-size: 1.5em;" class="glyphicon glyphicon-check"></span>
                <?php
                }
                else
                {
                ?>
                    <span style="font-size: 1.5em;" class="glyphicon glyphicon-ban-circle"></span>
                <?php
                }
                ?>
                Add invoice items
            </a>
            <a
                <?php
                if(isset($_SESSION['Billing']['newBill']['invoiceId']))
                {
                ?>
                    href="/<?php echo BASEURL; ?>index.php/Billing/addAccessoryItems/<?php echo $_SESSION['Billing']['newBill']['invoiceId']; ?>"
                <?php
                }
                ?>
                class="thumbnail <?php if($page=="addAccessoryItems") echo "active"; ?>">
                <?php
                if($invoiceCreated && !$invoiceAccessoryItemsAdded)
                {
                ?>
                    <span style="font-size: 1.5em;" class="glyphicon glyphicon-unchecked"></span>
                <?php
                }
                else if($invoiceCreated && $invoiceAccessoryItemsAdded)
                {
                ?>
                    <span style="font-size: 1.5em;" class="glyphicon glyphicon-check"></span>
                <?php
                }
                else
                {
                ?>
                    <span style="font-size: 1.5em;" class="glyphicon glyphicon-ban-circle"></span>
                <?php
                }
                ?>
                Add accessory items
            </a>
            <a
                <?php
                if($invoiceCreated)
                {
                ?>
                    href="/<?php echo BASEURL; ?>index.php/Billing/billPdf/<?php echo $_SESSION['Billing']['newBill']['invoiceId']; ?>"
                <?php
                }
                ?>
                class="thumbnail" target="new">
                <?php
                if($invoiceCreated)
                {
                ?>
                    <span style="font-size: 1.5em;" class="glyphicon glyphicon-unchecked"></span>
                <?php
                }
                else
                {
                ?>
                    <span style="font-size: 1.5em;" class="glyphicon glyphicon-ban-circle"></span>
                <?php
                }
                ?>
                View Bill
            </a>
        </div>