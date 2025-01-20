<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Management System - Employee List</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap'>
  <link rel="stylesheet" href="../public/css/styletable.css">
  <style>
 
    
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #333;
      color: #fff;
      padding: 10px 20px;
    }
    header h1 {
      margin: 0;
      font-size: 1.8rem;
    }
    main {
      margin-top: 10px;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      color: #009639;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
      color: #4CAF50;
    }
    th {
      background-color: #f2f2f2;
      font-weight: bold;
    }
    .odd {
      background-color: #f9f9f9;
    }
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
    }
    .modal-content {
      background-color: #fefefe;
      margin: 10% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      border-radius: 8px;
    }
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }
    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }
    form {
      display: grid;
      gap: 10px;
    }
    form label {
      font-weight: bold;
    }
    form input[type="text"],
    form input[type="email"],
    form input[type="number"],
    form input[type="date"] {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    form button[type="submit"] {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }
    form button[type="submit"]:hover {
      background-color: #fefefe;
    }
    .logout {
      background-color: #45a049;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }
    .logout:hover {
      background-color: #da190b;
    }
  </style>
</head>
<body>

<header>
  <h1>Employee List</h1>
  <button class="logout" onclick="logout()">Logout</button>
</header>

<main>
  <table id="employeeTable">
    <thead>
      <tr>
        <th>ID</th>
        <th>Last Name</th>
        <th>First Name</th>
        <th>Date of Birth</th>
        <th>Age</th>
        <th>City of Birth</th>
        <th>CIN</th>
        <th>Email</th>
        <th>Department</th>
        <th>Position</th>
        <th>Department ID</th>
        <th>Site</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $dialect = "mysql";
      $username = "myuser";
      $password = "mypassword";
      $host = "localhost";
      $port = 3306;
      $db_name = "employee_management";
      $count = 0;

      try {
          $pdo = new PDO("$dialect:host=$host;port=$port;dbname=$db_name", $username, $password);
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $pdo->query("SELECT * FROM Employees");

          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $class = ($count % 2 == 0) ? 'odd' : '';
              echo "<tr class=\"$class\">";
              echo "<td>" . htmlspecialchars($row['id']) . "</td>";
              echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
              echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
              echo "<td>" . htmlspecialchars($row['date_of_birth']) . "</td>";
              echo "<td>" . htmlspecialchars($row['age']) . "</td>";
              echo "<td>" . htmlspecialchars($row['city_of_birth']) . "</td>";
              echo "<td>" . htmlspecialchars($row['cin']) . "</td>";
              echo "<td>" . htmlspecialchars($row['email']) . "</td>";
              echo "<td>" . htmlspecialchars($row['department']) . "</td>";
              echo "<td>" . htmlspecialchars($row['position']) . "</td>";
              echo "<td>" . htmlspecialchars($row['department_id']) . "</td>";
              echo "<td>" . htmlspecialchars($row['site']) . "</td>";
              echo "<td>";
              echo "<button onclick=\"editEmployee({$row['id']})\">Edit</button>";
              echo "<button onclick=\"deleteEmployee({$row['id']})\">Delete</button>";
              echo "</td>";
              echo "</tr>";
              $count++;
          }
      } catch (PDOException $e) {
          die("Error: " . $e->getMessage());
      }
      ?>
    </tbody>
  </table>
</main>

<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>Edit Employee</h2>
    <form id="editForm" onsubmit="updateEmployee(); return false;">
      <input type="hidden" id="editId">
      <div>
        <label for="editLastName">Last Name:</label>
        <input type="text" id="editLastName" name="last_name" required>
      </div>
      <div>
        <label for="editFirstName">First Name:</label>
        <input type="text" id="editFirstName" name="first_name" required>
      </div>
      <div>
        <label for="editDOB">Date of Birth:</label>
        <input type="date" id="editDOB" name="date_of_birth" required>
      </div>
      <div>
        <label for="editAge">Age:</label>
        <input type="number" id="editAge" name="age" required>
      </div>
      <div>
        <label for="editCityOfBirth">City of Birth:</label>
        <input type="text" id="editCityOfBirth" name="city_of_birth" required>
      </div>
      <div>
        <label for="editCIN">CIN:</label>
        <input type="text" id="editCIN" name="cin" required>
      </div>
      <div>
        <label for="editEmail">Email:</label>
        <input type="email" id="editEmail" name="email" required>
      </div>
      <div>
        <label for="editDepartment">Department:</label>
        <input type="text" id="editDepartment" name="department">
      </div>
      <div>
        <label for="editPosition">Position:</label>
        <input type="text" id="editPosition" name="position">
      </div>
      <div>
        <label for="editDepartmentId">Department ID:</label>
        <input type="number" id="editDepartmentId" name="department_id">
      </div>
      <div>
        <label for="editSite">Site:</label>
        <input type="text" id="editSite" name="site">
      </div>
      <button type="submit">Save</button>
    </form>
  </div>
</div>

<script>
  function editEmployee(id) {
    const row = document.querySelector(`tr[data-id="${id}"]`);
    document.getElementById('editId').value = id;
    document.getElementById('editLastName').value = row.querySelector('.last_name').textContent;
    document.getElementById('editFirstName').value = row.querySelector('.first_name').textContent;
    document.getElementById('editDOB').value = row.querySelector('.date_of_birth').textContent;
    document.getElementById('editAge').value = row.querySelector('.age').textContent;
    document.getElementById('editCityOfBirth').value = row.querySelector('.city_of_birth').textContent;
    document.getElementById('editCIN').value = row.querySelector('.cin').textContent;
    document.getElementById('editEmail').value = row.querySelector('.email').textContent;
    document.getElementById('editDepartment').value = row.querySelector('.department').textContent;
    document.getElementById('editPosition').value = row.querySelector('.position').textContent;
    document.getElementById('editDepartmentId').value = row.querySelector('.department_id').textContent;
    document.getElementById('editSite').value = row.querySelector('.site').textContent;
    document.getElementById('editModal').style.display = 'block';
  }

  function updateEmployee() {
    const id = document.getElementById('editId').value;
    const last_name = document.getElementById('editLastName').value;
    const first_name = document.getElementById('editFirstName').value;
    const date_of_birth = document.getElementById('editDOB').value;
    const age = document.getElementById('editAge').value;
    const city_of_birth = document.getElementById('editCityOfBirth').value;
    const cin = document.getElementById('editCIN').value;
    const email = document.getElementById('editEmail').value;
    const department = document.getElementById('editDepartment').value;
    const position = document.getElementById('editPosition').value;
    const department_id = document.getElementById('editDepartmentId').value;
    const site = document.getElementById('editSite').value;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_employee.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        location.reload();
      }
    };
    xhr.send(`id=${id}&last_name=${last_name}&first_name=${first_name}&date_of_birth=${date_of_birth}&age=${age}&city_of_birth=${city_of_birth}&cin=${cin}&email=${email}&department=${department}&position=${position}&department_id=${department_id}&site=${site}`);
  }

  function closeModal() {
    document.getElementById('editModal').style.display = 'none';
  }

  function deleteEmployee(id) {
    if (confirm('Are you sure you want to delete this employee?')) {
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'delete_employee.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          location.reload();
        }
      };
      xhr.send(`id=${id}`);
    }
  }

  function logout() {
    window.location.href = 'logout.php';
  }
</script>

</body>
</html>
