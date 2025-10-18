<?php
include '../../connectMySql.php';
include '../../loginverification.php';

if(logged_in() && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $suggestion = mysqli_real_escape_string($conn, $_POST['suggestion']);
    
    // Check if category already exists
    $check_query = "SELECT * FROM category WHERE name = '$name'";
    $check_result = $conn->query($check_query);
    
    if ($check_result->num_rows > 0) {
        // Category already exists
        echo "<script src='../../js/sweetalert2.all.min.js'></script>
        <body onload='error()'></body>
        <script> 
        function error(){
            Swal.fire({
                icon: 'error',
                title: 'Category Already Exists',
                text: 'A category with this name already exists.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php';
                }
            });
        }
        </script>";
    } else {
        // Insert new category
        $sql = "INSERT INTO category (name, suggestion) VALUES ('$name', '$suggestion')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script src='../../js/sweetalert2.all.min.js'></script>
            <body onload='success()'></body>
            <script> 
            function success(){
                Swal.fire({
                    icon: 'success',
                    title: 'Category Added Successfully',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php';
                    }
                });
            }
            </script>";
        } else {
            echo "<script src='../../js/sweetalert2.all.min.js'></script>
            <body onload='error()'></body>
            <script> 
            function error(){
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to add category. Please try again.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php';
                    }
                });
            }
            </script>";
        }
    }
} else {
    header('location:../../index.php');
}
?>
