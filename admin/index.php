<?php include('functions.php');
if (!isLoggedIn()) {
    header('location: login.php');
}
?>
<html>

<head>
    <title>Pagination</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <script>
        function go2Page() {
            var page = document.getElementById("page").value;
            page = ((page > <?php echo $total_pages; ?>) ? <?php echo $total_pages; ?> : ((page < 1) ? 1 : page));
            window.location.href = 'index.php?page=' + page;
        }
    </script>
    <style>
        table {
            border-collapse: collapse;
        }

        .inline {
            display: inline-block;
            float: right;
            margin: 20px 0px;
        }

        input,
        button {
            height: 34px;
        }

        .pagination {
            display: inline-block;
        }

        .pagination a {
            font-weight: bold;
            font-size: 18px;
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid black;
        }

        .pagination a.active {
            background-color: pink;
        }

        .pagination a:hover:not(.active) {
            background-color: skyblue;
        }
    </style>
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
                <h3>MANAGE USERS</h3><br />
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name"><br/><br/>
                <table id="users" class="table table-striped table-condensed    
                                          table-bordered">
                    <thead>
                        <tr>
                            <th width="10%">Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Gender</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($rs_result)) {
                            // Display each field of the records.    
                        ?>
                            <tr>
                                <td><?php echo $row["firstname"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><?php echo $row["mobile"]; ?></td>
                                <td><?php echo $row["gender"]; ?></td>
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
    <script>
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("users");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                td1 = tr[i].getElementsByTagName("td")[1];
                td2 = tr[i].getElementsByTagName("td")[2];
                if (td1) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
                else if (td1) {
                    txtValue = td1.textContent || td1.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
                else if (td2) {
                    txtValue = td2.textContent || td2.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>

</html>