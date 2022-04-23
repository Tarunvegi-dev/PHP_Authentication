<?php include('functions.php');
if (!isLoggedIn()) {
    header('location: login.php');
}
?>
<html>

<head>
    <title>Admin</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="./js/script.js" type="text/javascript"></script>
    <script src="https://kit.fontawesome.com/057772d77f.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <center>
        <?php

        $per_page_record = 2;  // Number of entries to show in a page.   
        // Look for a GET variable page if not found default is 1.        
        if (isset($_GET["page"])) {
            $page  = $_GET["page"];
        } else {
            $page = 1;
        }

        $start_from = ($page - 1) * $per_page_record;

        $db = mysqli_connect('localhost', 'root', '', 'multi_login');
        $query = "SELECT * FROM users LIMIT $start_from, $per_page_record";
        $rs_result = mysqli_query($db, $query);
        ?>

        <div class="container">
            <br>
            <div>
                <div class="row">
                    <h2 style="font-family: Poppins;">Manage <b>users</b></h2>
                </div><br />
                <div class="row">
                    <a href="#addUserModal" class="btn btn-success" data-toggle="modal"><i class="fa fa-add"></i> <span>Add New User</span></a>
                </div>
                <br />
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names and emails" class="form-control" title="Type in a name"><br /><br />
                <table id="users" class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="10%">Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Gender</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($rs_result)) {
                            // Display each field of the records.    
                        ?>
                            <tr>
                                <td><?php echo $row["firstname"]; ?></td>
                                <td name="email"><?php echo $row["email"]; ?></td>
                                <td><?php echo $row["mobile"]; ?></td>
                                <td><?php echo $row["gender"]; ?></td>
                                <td>
                                    <center>
                                        <a href="#editUserModal" onclick="editProfile('<?php echo $row['email'] ?>')" data-toggle="modal"><i class="fa-solid fa-pen-to-square" style="cursor:pointer"></i></a>&nbsp;&nbsp;
                                        <a href="#deleteUserModal" onclick="deleteProfile('<?php echo $row['email'] ?>')" data-toggle="modal"><i style="cursor:pointer" class="fa fa-trash"></i></a>
                                    </center>
                                </td>
                            </tr>
                        <?php
                        };
                        ?>
                    </tbody>
                </table>

                <div class="pagination">
                    <?php
                    $db = mysqli_connect('localhost', 'root', '', 'multi_login');
                    $query = "SELECT COUNT(*) FROM users";
                    $rs_result = mysqli_query($db, $query);
                    $row = mysqli_fetch_row($rs_result);
                    $total_records = $row[0];

                    echo "</br>";
                    // Number of pages required.   
                    $total_pages = ceil($total_records / $per_page_record);
                    $pagLink = "";

                    if ($page >= 2) {
                        echo "<a href='index.php?page=" . ($page - 1) . "'>  Prev </a>";
                    }

                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $page) {
                            $pagLink .= "<a class = 'active' href='index.php?page="
                                . $i . "'>" . $i . " </a>";
                        } else {
                            $pagLink .= "<a href='index.php?page=" . $i . "'>   
                                                " . $i . " </a>";
                        }
                    };
                    echo $pagLink;

                    if ($page < $total_pages) {
                        echo "<a href='index.php?page=" . ($page + 1) . "'>  Next </a>";
                    }

                    ?>
                </div>
            </div>
        </div>
    </center>
    <!-- Add Modal HTML -->
    <div id="addUserModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="index.php" onsubmit="return submitForm();">
                    <div class="modal-header">
                        <h4 class="modal-title">Add User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <center>
                            <div class="file-upload">
                                <input type="file" name="image" onchange="handleProfile(this)" required />
                                <img id="profile_img" name="profile" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" style="margin-bottom:40px; cursor:pointer" width="150" />
                            </div>
                        </center>
                        <div class="form-group">
                            <label>firstname</label>
                            <input type="text" id="firstName" name="firstname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>lastname</label>
                            <input type="text" id="lastName" name="lastname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <input class="form-control" id="mobile" name="mobile" required maxlength="13">
                        </div><br />
                        <div class="form-group">
                            <select class="form-control" aria-label="Default select example" id="gender" name="gender" required>
                                <option value="">Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div><br />
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div><br />
                        <?php if (isset($_SESSION['error'])) : ?>
                            <div class='alert alert-danger' role='alert'>
                                <strong><?php echo $_SESSION['error']; ?></strong>
                                <?php unset($_SESSION['errror']) ?>
                            </div>
                        <?php endif ?>
                        <div id="errors"></div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-success" value="Add" name="add_user">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    <div id="editUserModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="index.php" onsubmit="return validateForm()">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <center>
                            <div class="file-upload">
                                <input type="file" name="_image" onchange="handleProfileImage(this)" required />
                                <img id="profile_image" name="profile" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" style="margin-bottom:40px; cursor:pointer" width="150" />
                            </div>
                        </center>
                        <div class="form-group">
                            <label>firstname</label>
                            <input type="text" id="first_Name" name="first_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>lastname</label>
                            <input type="text" id="last_Name" name="last_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>email</label>
                            <input type="email" id="_email" name="_email" class="form-control" required readonly>
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <input class="form-control" id="_mobile" name="_mobile" required maxlength="13">
                        </div><br />
                        <div class="form-group">
                            <select class="form-control" aria-label="Default select example" id="_gender" name="_gender" required>
                                <option value="">Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div><br />
                        <div class="form-group">
                            <input type="password" class="form-control" id="_password" name="_password" placeholder="Password" required>
                        </div><br />
                        <div id="error"></div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-info" value="Save" name="edit_user">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal HTML -->
    <div id="deleteUserModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="index.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <input name="umail" type="email" id="umail" readonly hidden />
                    <div class="modal-body">
                        <p>Are you sure you want to delete these Record?</p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-danger" name="delete_user" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("users");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
            for (j = 0; j < tr.length; j++) {
                td1 = tr[j].getElementsByTagName("td")[1];
                if (td1) {
                    txtValue = td1.textContent || td1.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[j].style.display = "";
                    } else {
                        tr[j].style.display = "none";
                    }
                }
            }
        }

        function editProfile(email) {
            document.getElementById('_email').value = email
        }

        function deleteProfile(email) {
            document.getElementById('umail').value = email
        }

        function go2Page() {
            var page = document.getElementById("page").value;
            page = ((page > <?php echo $total_pages; ?>) ? <?php echo $total_pages; ?> : ((page < 1) ? 1 : page));
            window.location.href = 'index.php?page=' + page;
        }
    </script>
</body>

</html>