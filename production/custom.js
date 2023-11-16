$(document).ready(function() {
    // Get income list on page load
    getIncomeList();
});

function getIncomeList() {
    // Fetch income data using jQuery Ajax
    $.ajax({
        url: 'backend/manage_income.php', // PHP script to fetch income data
        type: 'GET',
        data: {
            key: 'get_income_data',
        },
        // dataType: 'json',
        success: function(data) {
          var data =   $.parseJSON(data);
            $("#income-data").html(data.html);
            $("#total_income").html(data.total_income);
        },
        error: function(error) {
            console.error('Error fetching income data:', error);
        }
    });
}

