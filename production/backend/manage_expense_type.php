<?php
require_once("db.php");
// Include the check_login.php file
require_once("check_login.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['key'])) {
        switch ($_POST['key']) {
            case 'add_expense_type':
                addExpenseType($conn);
                break;
            case 'update_expense_type':
                updateExpenseType($conn);
                break;
            case 'get_single_expense_type':
                getSingleExpenseType($conn);
                break;
            case 'delete_expense_type':
                deleteExpenseType($conn);
                break;
            case 'get_all_expense_type':
                getAllExpenseType($conn);
                break;
        }
    }
}
function getAllExpenseType($conn)
{
    $sql = "SELECT * FROM expense_types";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $html = '';
    $i = 1;

    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
        <th scope="row">' . $i . '</th>
        <td>' . $row['type_name'] . '</td>
        <td>
            <button class="btn btn-sm btn-round btn-info" onclick="editIncome(' . $row['type_id'] . ')">Edit</button>
            <button class="btn btn-sm btn-round btn-danger" onclick="deleteIncome(' . $row['type_id'] . ')">Delete</button>
        </td>
    </tr>';
        $i++;
    }
    echo $html;
}

function addExpenseType($conn)
{
    // Validate and sanitize input
    $expenseType = isset($_POST['expenseType']) ? $_POST['expenseType'] : '';
    // Add additional validation as needed

    // Insert into the database
    $sql = "INSERT INTO expense_types (type_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $expenseType);

    if ($stmt->execute()) {
        echo "<script> window.location.href  = '../view-expense.php';</script>";
    } else {
        echo "Error adding expense type: " . $stmt->error;
    }

    $stmt->close();
}

function updateExpenseType($conn)
{
    // Validate and sanitize input
    $expenseTypeId = isset($_POST['id']) ? $_POST['id'] : '';
    $expenseType = isset($_POST['expenseType']) ? $_POST['expenseType'] : '';
    // Add additional validation as needed

    // Update in the database
    $sql = "UPDATE expense_types SET type_name = ? WHERE type_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $expenseType, $expenseTypeId);

    if ($stmt->execute()) {
        echo "<script> window.location.href  = '../view-expense.php';</script>";
    } else {
        echo "Error updating expense type: " . $stmt->error;
    }

    $stmt->close();
}

function getSingleExpenseType($conn)
{
    // Validate and sanitize input
    $expenseTypeId = isset($_POST['id']) ? $_POST['id'] : '';

    // Fetch from the database
    $sql = "SELECT * FROM expense_types WHERE type_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $expenseTypeId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Send the result as JSON
    echo json_encode($row);

    $stmt->close();
}

function deleteExpenseType($conn)
{
    // Validate and sanitize input
    $expenseTypeId = isset($_POST['id']) ? $_POST['id'] : '';

    // Delete from the database
    $sql = "DELETE FROM expense_types WHERE type_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $expenseTypeId);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error deleting expense type: " . $stmt->error;
    }

    $stmt->close();
}

// Close the database connection (if opened)
$conn->close();
