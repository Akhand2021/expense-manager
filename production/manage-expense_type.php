<?php
require_once("backend/check_login.php");
include "header.php";
include "sidebar.php";
$id = '';
if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = $_GET['id'];
}
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><?php echo $id == '' ? 'Add' : 'Update'; ?> Expense Type</h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5   form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php echo $id == '' ? 'Add' : 'Update'; ?> Expense Type</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Settings 1</a>
                                    <a class="dropdown-item" href="#">Settings 2</a>
                                </div>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?php if ($id) { ?>
                            <form id="demo-form2" action="backend/manage_expense_type.php" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                                <input type="hidden" name="id" id="expense_id">
                                <input type="hidden" name="key" id="" value="update_expense_type">
                            <?php    } else { ?>
                                <form id="demo-form2" action="backend/manage_expense_type.php" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                                    <input type="hidden" name="key" id="" value="add_expense_type">
                                <?php } ?>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Expense Type: <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="expenseType" name="expenseType" required="required" class="form-control ">
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="item form-group">
                                    <div class="col-md-6 col-sm-6 offset-md-3">
                                        <?php if ($id) { ?>
                                            <button type="submit" class="btn btn-success">Update Expense Type</button>
                                        <?php  } else { ?>
                                            <button type="submit" class="btn btn-success">Add Expense Type</button>
                                        <?php } ?>
                                    </div>
                                </div>

                                </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<script>
    $(document).ready(function() {
        getExpenseData();
    });

    function getExpenseData() {
        // Fetch income data using jQuery Ajax
        var id = '<?php echo $id; ?>';
        $.ajax({
            url: 'backend/manage_expense_type.php?id=', // PHP script to fetch income data
            type: 'POST',
            data: {
                id: id,
                key: 'get_single_expense_type',
            },
            // dataType: 'json',
            success: function(data) {
                var data = $.parseJSON(data, true);
                $("#expenseType").val(data.type_name);
                $("#expense_id").val(data.type_id);
            },
            error: function(error) {
                console.error('Error fetching income data:', error);
            }
        });
    }


</script>
<?php include "footer.php"; ?>