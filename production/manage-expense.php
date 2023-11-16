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
                <h3><?php echo $id == '' ? 'Add' : 'Update'; ?> Expense</h3>
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
                        <h2><?php echo $id == '' ? 'Add' : 'Update'; ?> Expense</h2>
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
                            <form id="demo-form2" action="backend/manage_expense.php" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                                <input type="hidden" name="id" id="expense_id">
                                <input type="hidden" name="key" id="" value="update_expense">
                            <?php    } else { ?>
                                <form id="demo-form2" action="backend/manage_expense.php" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                                    <input type="hidden" name="key" id="" value="add_expense">
                                <?php } ?>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="Amount">Amount: <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="amount" name="amount" required="required" class="form-control ">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="Expense Type">Expense Type: <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select class="form-control" name="expenseType" id="expenseType" required>

                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Date: <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="date" id="expenseDate" name="expenseDate" class="form-control " required>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="comment">Comment:
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <textarea name="comment" id="comment" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="item form-group">
                                    <div class="col-md-6 col-sm-6 offset-md-3">
                                        <?php if ($id) { ?>
                                            <button type="submit" class="btn btn-success">Update</button>
                                        <?php  } else { ?>
                                            <button type="submit" class="btn btn-success">Submit</button>
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
        getSingleExpenseData();
        getExpenseTypes();
    });

    function getSingleExpenseData() {
        // Fetch in
        var id = '<?php echo $id; ?>';
        $.ajax({
            url: 'backend/manage_expense.php', // PHP script to fetch income data
            type: 'POST',
            data: {
                "id": id,
                key: 'get_single_expense',
            },
            // dataType: 'json',
            success: function(data) {
                var data = $.parseJSON(data, true);
               $("#amount").val(data.amount);
               $("#expenseType").val(data.type_name);
               $("#expenseDate").val(data.expense_date);
               $("#comment").val(data.comments);
               $("#expense_id").val(data.expense_id);
            },
            error: function(error) {
                console.error('Error fetching income data:', error);
            }
        });
    }

    function getExpenseTypes() {
        $.ajax({
            url: 'backend/manage_expense.php', // Adjust the path based on your setup
            type: 'GET',
            dataType: 'json',
            data: {
                "key": 'get_all_expense_types',
            },
            success: function(data) {
                // Populate the dropdown with fetched expense types
                var select = $('#expenseType');
                select.empty();

                $.each(data, function(index, item) {
                    select.append($('<option>').text(item.type_name).attr('value', item.type_id));
                });
            },
            error: function(error) {
                console.error('Error fetching expense types:', error);
            }
        });
    }
</script>
<?php include "footer.php"; ?>