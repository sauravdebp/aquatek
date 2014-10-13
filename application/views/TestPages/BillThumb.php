<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 10/8/14
 * Time: 10:11 PM
 */
?>

<style type="text/css">
    /*.search_input
    {
        position: absolute;
        top: 40px;
        width: 100%;
        display: none;
        z-index: 1;
    }*/
    h3
    {
        display: inline-flex;
    }
    h3 + h3
    {
        margin-left:20px;
    }
</style>

<div class="container" style="width:100%;">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group" style="max-height: 200px; overflow-y: auto;">
                <label>Invoice Type</label>
                <input type="text" class="form-control">
                <ul class="list-group">
                    <li class="list-group-item">
                        <input type="checkbox">
                        Tax
                    </li>
                    <li class="list-group-item">
                        <input type="checkbox">
                        Retail
                    </li>
                    <li class="list-group-item">
                        <input type="checkbox">
                        Job Work
                    </li>
                </ul>
            </div>
            <div class="form-group">
                <label>Consignee</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>TIN Number</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Book Number</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Invoice Number</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Date From</label>
                <input type="date" class="form-control">
            </div>
            <div class="form-group">
                <label>Date Upto</label>
                <input type="date" class="form-control">
            </div>
        </div>
        <div class="col-md-10">
            <div class="row">
                <h3>
                    Invoice Type :&nbsp;
                    <span class="label label-info">
                        Tax
                        <button class="btn btn-xs btn-info">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </span>
                </h3>
                <h3>
                    Invoice Type :&nbsp;
                    <span class="label label-info">
                        Tax
                        <button class="btn btn-xs btn-info">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </span>
                </h3><h3>
                    Invoice Type :&nbsp;
                    <span class="label label-info">
                        Tax
                        <button class="btn btn-xs btn-info">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </span>
                </h3>
            </div>
            <div class="row">
                <table class="col-md-8 table table-striped table-hover table-bordered">
                    <tr>
                        <th>
                            Consignee
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Invoice No
                        </th>
                        <th>
                            Book No
                        </th>
                        <th>
                            Invoice Type
                        </th>
                        <th>

                        </th>
                    </tr>
                    <tr>
                        <td>Sample</td>
                        <td>Sample</td>
                        <td>Sample</td>
                        <td>Sample</td>
                        <td>Sample</td>
                        <td>
                            <a href="#">Edit</a>
                            <a href="#">View</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sample</td>
                        <td>Sample</td>
                        <td>Sample</td>
                        <td>Sample</td>
                        <td>Sample</td>
                        <td>
                            <a href="#">Edit</a>
                            <a href="#">View</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!--<script>
    $(document).ready(function ()
    {
        $('.button_search').click(function ()
        {
            var elem = $("div", $(this).parent());
            if($(elem).css("display") == "none")
                $(elem).show();
            else
            {
                $("input", elem).val(null);
                $(elem).hide();
            }
        });
    });
</script>-->