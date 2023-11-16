<?php
require_once("db.php");
// Include the check_login.php file
require_once("check_login.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["key"] == "add_income") {
    $amount = $_POST["amount"];
    $month = $_POST["month"];
    $year = $_POST["year"];
    $comment = $_POST["comment"];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO income (user_id, amount, month, year,comment) VALUES (?, ?, ?, ?,?)");

    // Replace 'user_id' with the actual user ID once you implement user authentication
    $user_id = $_SESSION['user_id'];

    $stmt->bind_param("idiis", $user_id, $amount, $month, $year, $comment);

    if ($stmt->execute()) {
        echo "<script> window.location.href  = '../view-income.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET['key'] == 'get_income_data') {
    if (!isset($_SESSION['user_id'])) {
        // If not logged in, return an empty array
        echo json_encode([]);
        exit();
    }
    // Check if the user is logged in
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM income WHERE user_id = ?";
    $sql1 = "SELECT SUM(amount) AS total_income FROM income WHERE user_id = ?";
    $stmt1 = $conn->prepare($sql1);

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt1->bind_param("i", $user_id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $row1 = $result1->fetch_assoc();
    $totalIncome = $row1['total_income'];
    $stmt1->close();
    $stmt->close();

    // Convert the result into an associative array
    $html = '';
    $i = 1;

    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
        <th scope="row">' . $i . '</th>
        <td>' . date("F", mktime(0, 0, 0, $row['month'], 1))  . '</td>
        <td>' . $row['year'] . '</td>
        <td>' . $row['amount'] . ' ' . $row['currency'] . '</td>
        <td>' . $row['comment'] . '</td>
        <td>
            <button class="btn btn-sm btn-round btn-info" onclick="editIncome(' . $row['income_id'] . ')">Edit</button>
            <button class="btn btn-sm btn-round btn-danger" onclick="deleteIncome(' . $row['income_id'] . ')">Delete</button>
        </td>
    </tr>';
        $i++;
    }
    $arr = array(
        "total_income" => $totalIncome,
        "html" => $html,
    );
    echo json_encode($arr);
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET['key'] == 'get_single_data') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $user_id = $_GET['id'];
        $sql = "SELECT * FROM income WHERE income_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc(); // Fetch the data
        $stmt->close();

        echo json_encode($row); // Encode the fetched data
    } else {
        // Handle the case where 'id' is not set or empty
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['key'] == 'update_income') {
    if (isset($_POST['id']) && $_POST['id'] != '' && isset($_POST['amount']) && isset($_POST['month']) && isset($_POST['year'])) {
        $income_id = $_POST['id'];
        $amount = $_POST['amount'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        $comment = $_POST["comment"];
        
        $sql = "UPDATE income SET amount = ?, month = ?, year = ?, comment = ? WHERE income_id = ?";
        $stmt = $conn->prepare($sql);
        
        // Use 'ssdsi' as the data type for binding parameters
        $stmt->bind_param("ssdsi", $amount, $month, $year, $comment, $income_id);
        
        if ($stmt->execute()) {
            echo "<script>window.location.href = '../view-income.php';</script>";
        } else {
            echo "Error updating income: " . $stmt->error;
        }
        
        $stmt->close();
        

        $stmt->close();
    } else {
        // Handle the case where required parameters are not set
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['key']) && $_POST['key'] == 'delete_income') {
    if (isset($_POST['id']) && $_POST['id'] != '') {
        $income_id = $_POST['id'];

        // Perform the deletion
        $sql = "DELETE FROM income WHERE income_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $income_id);

        if ($stmt->execute()) {
            echo "Success";
        } else {
            echo "Error deleting income: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid request. Missing or empty 'id' parameter.";
    }
} else {
    // Other code for handling different key values or request methods
}





$conn->close();
