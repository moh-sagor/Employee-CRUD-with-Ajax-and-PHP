<?php
$con = new mysqli('localhost', 'root', '', 'employee_information');
$action = $_POST['action'];
$action();

function insert()
{
    global $con;
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $salary = $_POST["salary"];
    $desig = $_POST["desig"];
    $status = $_POST["status"];
    if (check($email) == TRUE) {
        echo "This Email already exist";
    } else if ($name == '') {
        echo "Name is required";
    } else if ($email == '') {
        echo "Email is required";
    } else if ($phone == '') {
        echo "Phone is required";
    } else if ($salary == '') {
        echo "Salary is required";
    } else if ($desig == '') {
        echo "Designation is required";
    } else if ($status == '') {
        echo "Status is required";
    } else {
        $qur = $con->query("INSERT INTO tbl_employee(name,email,phone,salary,desig,status)VALUES('$name','$email','$phone','$salary','$desig','$status')");

        if ($qur) {
            echo "Data Submitted";
        } else {
            echo "Data not Submitted";
        }

    }




}
function update()
{
    global $con;
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $salary = $_POST["salary"];
    $desig = $_POST["desig"];
    $status = $_POST["status"];
    $id = $_POST["id"];
    if ($name == '') {
        echo "Name is required";
    } else if ($email == '') {
        echo "Email is required";
    } else if ($phone == '') {
        echo "Phone is required";
    } else if ($status == '') {
        echo "Status is required";
    } else {
        $qur = $con->query("UPDATE tbl_employee SET name='$name',email='$email',phone='$phone',salary='$salary',desig='$desig',status='$status' WHERE id='$id'");

        if ($qur) {
            echo "Data Updated";
        } else {
            echo "Data not Updated";
        }

    }
}
function show()
{
    global $con;
    $obj = $con->query("SELECT * FROM tbl_employee");
    $allData = "";
    $sl = 1;
    while ($data = $obj->fetch_assoc()) {
        if ($data["status"] == 1) {
            $status = "<button class=' active btn btn-primary btn-sm' value=" . $data["id"] . ">Active</button>";
        } else {
            $status = "<button class='inactive btn btn-warning btn-sm' value=" . $data["id"] . ">Inactive</button>";
        }

        $allData .= "<tr>
        <td>" . $sl . "</td>
        <td>" . $data["name"] . "</td>
        <td>" . $data["email"] . "</td>
        <td>" . $data["phone"] . "</td>
        <td>" . $data["salary"] . "</td>
        <td>" . $data["desig"] . "</td>
        <td>" . $status . "</td>
        <td>
        <button class='btn btn-info btn-sm'   id='edit' value='" . $data['id'] . "'>Edit</button>
        <button data-bs-toggle='modal' data-bs-target='#updateItem' class='btn btn-info btn-sm'   id='editmodal' value='" . $data['id'] . "'>Modal</button>
        <button class='btn btn-danger btn-sm ' id='delete' value='" . $data['id'] . "'>Delete</button></td>
        </tr>";
        $sl++;
    }
    echo $allData;

}
function delete()
{
    global $con;
    $id = $_POST['id'];
    $con->query("DELETE FROM tbl_employee WHERE id = '$id'");
    // echo "Item Deleted";
    show();
}

function active()
{
    global $con;
    $id = $_POST['id'];
    $con->query("UPDATE tbl_employee SET status='2' WHERE id='$id'");


}
function inactive()
{
    global $con;
    $id = $_POST['id'];
    $con->query("UPDATE tbl_employee SET status='1' WHERE id='$id'");


}
function check($email)
{
    global $con;

    $qur = $con->query("SELECT email FROM tbl_employee WHERE email='$email'");
    if ($qur->num_rows > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}


function finddata()
{
    global $con;
    $id = $_POST['id'];
    $qur = $con->query("SELECT * FROM tbl_employee WHERE id='$id'");
    $qur = $qur->fetch_assoc();
    echo json_encode($qur);
}

?>