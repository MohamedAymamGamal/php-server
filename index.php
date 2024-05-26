<?php
// connection database
$host = 'localhost';
$username = "root";
$password = "";
$dbName = "company";
$con = mysqli_connect($host, $username, $password, $dbName);

// DELETE DATA
if (isset($_GET["delete"])) {
  $id = $_GET["delete"];
  $deleteQuery = "DELETE FROM `employees` where id = $id";
  $delete = mysqli_query($con, $deleteQuery);
  header("Location: index.php");
}
if (isset($_GET["delete"])){
  $id = $_GET["delete"];
  $deleteQuery = "DELETE FROM `employees` WHERE id = $id";
  $delete = mysqli_query($con, $deleteQuery);
  header("Location: index.php");
}
// Edit Data
$userid = "";
$name = '';
$phone = '';
$gender = '';
$department = '';
$mode = "create";
 
// GET employee
if (isset($_GET["edit"])) {
  $id = $_GET["edit"];
  $editQuery = "SELECT * FROM `employees` where id = $id";
  $edit = mysqli_query($con, $editQuery);
  $result = mysqli_fetch_assoc($edit);
  $name =  $result["name"];
  $phone =  $result["phone"];
  $gender =  $result["gender"];
  $department =  $result["department"];
  $userid = $result["id"];
  $mode = "update";
}
// update employee
if (isset($_POST["update"])) {
  $name = $_POST["name"];
  $phone = $_POST["phone"];
  $gender = $_POST["gender"];
  $department = $_POST["department"];
  $updateQuery = "UPDATE `employees` SET `name`='$name',`gender`='$gender',`phone`='$phone',`department`='$department' WHERE id = $userid";
  $update = mysqli_query($con, $updateQuery);
  header('location:index.php');
}

// create data
if (isset($_POST["submit"])) {
  $name = $_POST["name"];
  $phone = $_POST["phone"];
  $gender = $_POST["gender"];
  $department = $_POST["department"];
  $createQuery = "INSERT INTO `employees` VALUES (NULL, '$name','$gender', '$phone',  '$department')";
  $insert = mysqli_query($con, $createQuery);
}


// READ DATA
$selectQuery = "SELECT * FROM `employees`";
$select = mysqli_query($con, $selectQuery);


// "<a href="?delete=<?= //$emp["id"] " class="btn btn-danger">Delete</a>""
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #333;
      color: white;
    }
  </style>
</head>

<body>

  <div class="container col-6 py-5">
    <div class="card bg-dark text-light">
      <div class="card-body">
        <form method="POST">
          <div class="form-group mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" value="<?= $name ?>" name="name" id="name" class="form-control">
          </div>

          <div class="form-group mb-3">
            <label for="gender" class="form-label">gender</label>
            <select name="gender" id="gender" class="form-select">
              <?php if ($gender == "male") : ?>
                <option value="male" selected>Male</option>
                <option value="female">Female</option>
              <?php elseif ($gender == "female") : ?>
                <option value="male">Male</option>
                <option value="female" selected>Female</option>
              <?php else : ?>
                <option disabled selected>choose</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              <?php endif; ?>
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="phone" class="form-label">phone</label>
            <input type="text" value="<?= $phone ?>" name="phone" id="phone" class="form-control">
          </div>
          <div class="form-group mb-3">
            <label for="department" class="form-label">department</label>
            <input type="text" value="<?= $department ?>" name="department" id="department" class="form-control">
          </div>
          <div class="form-group mb-3 text-center">
            <?php if ($mode == "create") : ?>
              <button type="submit" name="submit" class="btn btn-primary">Add Employee</button>
            <?php else : ?>
              <button type="submit" name="update" class="btn btn-warning">Update</button>
              <a href="index.php" class="btn btn-info">Cancel</a>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="card bg-dark">
      <table class="table table-dark">
        <thead>
          <tr>
            <th>id</th>
            <th>name</th>
            <th>gender</th>
            <th>phone</th>
            <th>department</th>
            <th colspan="2">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($select as $emp) : ?>
            <tr>
              <td><?= $emp["id"] ?></td>
              <td><?= $emp["name"] ?></td>
              <td><?= $emp["gender"] ?></td>
              <td><?= $emp["phone"] ?></td>
              <td><?= $emp["department"] ?></td>
              <td><a href="?edit=<?= $emp["id"] ?>" class="btn btn-warning">Edit</a></td>
              <td>
                <form>
                  <input type="text" hidden name="delete" value="<?= $emp["id"] ?>">
                  <button class="btn btn-danger">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>
