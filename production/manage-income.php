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
                <h3><?php echo $id == '' ? 'Add' : 'Update'; ?> Income</h3>
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
                        <h2><?php echo $id == '' ? 'Add' : 'Update'; ?> Income</h2>
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
                            <form id="demo-form2" action="backend/manage_income.php" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                                <input type="hidden" name="id" id="income_id">
                                <input type="hidden" name="key" id="" value="update_income">
                            <?php    } else { ?>
                                <form id="demo-form2" action="backend/manage_income.php" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                                    <input type="hidden" name="key" id="" value="add_income">
                                <?php } ?>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Amount: <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="amount" name="amount" required="required" class="form-control ">
                                    </div>
                                </div>
                               
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="Month">Month: <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select class="form-control" name="month" id="month" required>
                                            <?php
                                            // Generate dropdown options for months
                                            for ($i = 1; $i <= 12; $i++) {
                                                $monthName = date("F", mktime(0, 0, 0, $i, 1));
                                                echo "<option  value='$i'>$monthName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Year: <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select class="form-control" name="year" id="year" required>
                                            <?php
                                            // Generate dropdown options for years (adjust the range as needed)
                                            $currentYear = date("Y");
                                            for ($i = $currentYear; $i >= $currentYear - 2; $i--) {
                                                echo "<option  value='$i'>$i</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="comment">Comment: 
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <textarea name="comment" id="comment" class="form-control" ></textarea>
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
        getIncomeData();


    });

    function getIncomeData() {
        // Fetch income data using jQuery Ajax
        var id = '<?php echo $id; ?>';
        $.ajax({
            url: 'backend/manage_income.php?id=' + id, // PHP script to fetch income data
            type: 'GET',
            data: {
                key: 'get_single_data',
            },
            // dataType: 'json',
            success: function(data) {
                var data = $.parseJSON(data, true);
                $("#amount").val(data.amount);
                $("#year").val(data.year);
                $("#month").val(data.month);
                $("#income_id").val(data.income_id);
                $("#comment").val(data.comment);
            },
            error: function(error) {
                console.error('Error fetching income data:', error);
            }
        });
    }

</script>
<?php include "footer.php"; ?>