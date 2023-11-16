<?php
require_once("backend/check_login.php");
include "header.php";
include "sidebar.php";
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Your Income</h3>
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
                        <h2>View Income</h2>
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
                        <p><b>Total Income:</b><span id="total_income"></span></p>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Income</th>
                                    <th>Comment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="income-data">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<script>
function editIncome(incomeId) {
    // Redirect to the edit page with the specific income ID
    window.location.href = '../production/manage-income.php?id=' + incomeId;
}    

function deleteIncome(id) {
        var confirmDelete = confirm("Are you sure you want to delete this income?");

        if (confirmDelete) {
            $.ajax({
                url: 'backend/manage_income.php',
                type: 'POST',
                data: {
                    key: 'delete_income',
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    if(response == 'Success') {
                        location.reload();
                    }
                    // Add any further actions after successful deletion
                },
                error: function(error) {
                    console.error('Error deleting income:', error);
                }
            });
        }
    }
</script>

<?php include "footer.php"; ?>