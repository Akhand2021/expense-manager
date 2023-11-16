<?php
require_once("db.php");
require_once("check_login.php");
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['key']) && $_GET['key'] == 'get_all_expense_types') {
    // Fetch all expense types from the database
    $sql = "SELECT * FROM expense_types";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $expenseTypes = array();

        while ($row = $result->fetch_assoc()) {
            $expenseTypes[] = $row;
        }

        // Send the result as JSON
        echo json_encode($expenseTypes);
    } else {
        echo "No expense types found";
    }
} else {
    // Handle other cases or requests
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['key'])) {
    switch ($_POST['key']) {
        case 'add_expense':
            addExpense();
            break;
        case 'update_expense':
            updateExpense();
            break;
        case 'delete_expense':
            deleteExpense();
            break;
        case 'get_all_expenses':
            getAllExpenses();
            break;
        case 'get_single_expense':
            getSingleExpense();
            break;
    }
}

function addExpense()
{
    global $conn;
    $amount = $_POST['amount'];
    $expenseType = $_POST['expenseType'];
    $date = $_POST['expenseDate'];
    $comments = $_POST['comment'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO expenses (amount, user_id,type_id, expense_date, comments) VALUES (?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("diiss", $amount, $user_id, $expenseType, $date, $comments);

    if ($stmt->execute()) {
        echo "<script> window.location.href  = '../view-expense.php';</script>";
    } else {
        echo "Error adding expense: " . $stmt->error;
    }

    $stmt->close();
}
function getSingleExpense()
{
    global $conn;
    $id = $_POST['id'];
    $sql = "SELECT * FROM expenses as e inner join expense_types as et on et.type_id = e.type_id where expense_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    echo json_encode($row);
}
function updateExpense()
{
    global $conn;

    $expenseId = $_POST['id'];
    $amount = $_POST['amount'];
    $expenseType = $_POST['expenseType'];
    $date = $_POST['expenseDate'];
    $comments = $_POST['comment'];

    $sql = "UPDATE expenses SET amount = ?, type_id = ?, expense_date = ?, comments = ? WHERE expense_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("disss", $amount, $expenseType, $date, $comments, $expenseId);

    if ($stmt->execute()) {
        echo "<script> window.location.href  = '../view-expense.php';</script>";
    } else {
        echo "Error updating expense: " . $stmt->error;
    }

    $stmt->close();
}

function deleteExpense()
{
    global $conn;

    $expenseId = $_POST['id'];

    $sql = "DELETE FROM expenses WHERE expense_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $expenseId);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error deleting expense: " . $stmt->error;
    }

    $stmt->close();
}

function getAllExpenses()
{
    global $conn;
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM expenses as e inner join expense_types as et on et.type_id = e.type_id where user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $sql1 = "SELECT SUM(amount) AS total_expense FROM expenses WHERE user_id = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("i", $user_id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $row1 = $result1->fetch_assoc();
    $total_expense = $row1['total_expense'];
    if ($result->num_rows > 0) {
        $expenses = array();

        $html = '';
        $i = 1;

        while ($row = $result->fetch_assoc()) {
            $html .= '<tr>
            <th scope="row">' . $i . '</th>
            <td>' . $row['type_name']  . '</td>
            <td>' . date("d-M-Y", strtotime($row['expense_date']))  . '</td>
            <td>' . $row['amount'] . ' ' . $row['currency'] . '</td>
            <td>' . $row['comments'] . '</td>
            <td>
                <button class="btn btn-sm btn-round btn-info" onclick="editExpense(' . $row['expense_id'] . ')">Edit</button>
                <button class="btn btn-sm btn-round btn-danger" onclick="deleteExpense(' . $row['expense_id'] . ')">Delete</button>
            </td>
        </tr>';
            $i++;
        }
        $arr = array(
            'total_expense' =>$total_expense,
            "html" => $html,
        );

        // Send the result as JSON
        echo json_encode($arr);
    } else {
        echo "No expenses found";
    }
}
