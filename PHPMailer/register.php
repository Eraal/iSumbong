<?php
include('../../connectMySql.php');
include '../../loginverification.php';
if(logged_in()){

$type = "";
$grave_slot_id = "";
$user_id = "";
$payment_date = "";
$service_date = "";
$status = "";
$firstname = "";
$lastname = "";
$email = "";

if(isset($_GET['id']))
{
    $query = "SELECT a.*,b.firstname,b.lastname,b.email FROM request a 
    left JOIN users b on b.id = a.user_id
    WHERE a.id ='".$_GET['id']."'";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $type = $row['type'];
        $grave_slot_id = $row['grave_slot_id'];
        $user_id = $row['user_id'];
        $payment_date = $row['payment_date'];
        $service_date = $row['service_date'];
        $status = $row['status'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $email = $row['email'];
    }
    //EDIT if ID is not null
    if(isset($_POST['btn_save']))
    {
        $id=$_GET['id'];
        $type = $_POST['type'];
        $grave_slot_id = $_POST['grave_slot_id'];
        $payment_date = $_POST['payment_date'];
        $service_date = $_POST['service_date'];
        $status = $_POST['status'];

        $sql= "UPDATE request
        SET 
        type = '". $type ."',
        grave_slot_id = '". $grave_slot_id ."',
        payment_date = '". $payment_date ."',
        service_date = '". $service_date ."',
        status = '". $status ."'
        WHERE id = '". $id ."'";
        $result = mysqli_query($conn, $sql);
        if($status == 'APPROVED'){
            require_once('../../PHPMailer/PHPMailerAutoload.php');
                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPAuth = true;
                $mail->Username = 'sendernotifalert@gmail.com';
                $mail->Password = 'asng husd wqqr xuwp';
                $mail->setFrom('sendernotifalert@gmail.com', 'Binan City Cemetery');
                $mail->addReplyTo('sendernotifalert@gmail.com', 'Binan City Cemetery');
                $mail->addAddress( $email , 'Receiver Name');
                $mail->Subject = 'SERVICE APPROVED';
                $mail->Body = 
                'Dear '.$firstname.' '.$lastname.',

We are pleased to inform you that your request for the grave '.$type.' has been approved.';
                if (!$mail->send()) {
                    echo 'Email not valid : ' . $mail->ErrorInfo;
                    return;
                }
        }
        header("location:index.php");

    }
}
else
{
    //ADD if ID is null
    if(isset($_POST['btn_save']))
    {
        $type = $_POST['type'];
        $grave_slot_id = $_POST['grave_slot_id'];
        $user_id = $_SESSION['user_id'];
        $payment_date = $_POST['payment_date'];
        $service_date = $_POST['service_date'];
        $status = $_POST['status'];

        $sql = "INSERT INTO request (
                                    `type`,
                                    `grave_slot_id`,
                                    `user_id`,
                                    `payment_date`,
                                    `service_date`,
                                    `status`
                                  )
        VALUES (
                            '". $type ."',
                            '". $grave_slot_id ."',
                            '". $user_id ."',
                            '". $payment_date ."',
                            '". $service_date ."',
                            '". $status ."'
                )";
        $result = mysqli_query($conn, $sql);
        if($status == 'APPROVED'){
            require_once('../../PHPMailer/PHPMailerAutoload.php');
                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPAuth = true;
                $mail->Username = 'sendernotifalert@gmail.com';
                $mail->Password = 'asng husd wqqr xuwp';
                $mail->setFrom('sendernotifalert@gmail.com', 'Binan City Cemetery');
                $mail->addReplyTo('sendernotifalert@gmail.com', 'Binan City Cemetery');
                $mail->addAddress( $email , 'Receiver Name');
                $mail->Subject = 'SERVICE APPROVED';
                $mail->Body = 
                'Dear '.$firstname.' '.$lastname.',

We are pleased to inform you that your request for the grave '.$type.' has been approved.';
                if (!$mail->send()) {
                    echo 'Email not valid : ' . $mail->ErrorInfo;
                    return;
                }
        }
        header("location:index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Biñan City Cemetery</title>

    <link rel="icon" type="image/x-icon" href="../../img/logo.jpg" />
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.css' rel='stylesheet' />
</head>

<body id="page-top" onload="getLocation()">

    <div id="wrapper">

       <?php include'../sidebar.php';?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

               <?php include'../nav.php';?>

                <div class="container-fluid">

                         <div class="container">

                            <div class="card o-hidden border-0 shadow-lg my-5">
                                <div class="card-body p-0">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="p-5">
                                                <div class="text-center">
                                                    <h1 class="h4 text-gray-900 mb-4">Request Service</h1>
                                                </div>
                                                <form  method="post">
                                                    <div class="form-group row">
                                                    <input type="hidden" name="lng" id="lng" value=""  />
                                                    <input type="hidden" name="lat" id="lat" value=""  />
                                                        <div class="col-sm-6 col-12 mb-sm-0">
                                                            <p>Slot</p>
                                                            <select name="grave_slot_id" class="form-control" required>
                                                                <option value="">-SELECT-</option>
                                                                <?php
                                                                $query = "SELECT a.*,b.name as grave_name FROM grave_slot a
                                                                LEFT JOIN graves b on b.id = a.grave_id";
                                                                $result = $conn->query($query);
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $selected = ($grave_slot_id ==$row['id']) ? 'selected':'';
                                                                    echo'<option value="'.$row['id'].'" '.$selected.'>'.$row['grave_name'].'-'.$row['slot_value'].'</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6 col-12 mb-sm-0">
                                                            <p>Type</p>
                                                            <select name="type" class="form-control" required>
                                                                <option value="">-SELECT-</option>
                                                                <option value="GRAVEYARD PAINT" <?= $type == 'GRAVEYARD PAINT'? 'selected' : ''?>>GRAVEYARD PAINT</option>
                                                                <option value="GRAVEYARD CLEAN" <?= $type == 'GRAVEYARD CLEAN'? 'selected' : ''?>>GRAVEYARD CLEAN</option>
                                                                <option value="USE LOT" <?= $type == 'USE LOT'? 'selected' : ''?>>USE LOT</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-6 col-12 mb-sm-0">
                                                            <p>Payment Date</p>
                                                            <input type="date" class="form-control form-control" name="payment_date" value="<?php echo $payment_date;?>" required>
                                                        </div>
                                                        <div class="col-sm-6 col-12 mb-sm-0">
                                                            <p>Service Date</p>
                                                            <input type="date" class="form-control form-control" name="service_date" value="<?php echo $service_date;?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12 col-12 mb-sm-0">
                                                        <p>Status</p>
                                                            <select name="status" class="form-control" required>
                                                                <option value="">-SELECT-</option>
                                                                <option value="PENDING" <?= $status == 'PENDING'? 'selected' : ''?>>PENDING</option>
                                                                <option value="APPROVED" <?= $status == 'APPROVED'? 'selected' : ''?>>APPROVED</option>
                                                                <option value="DECLINED" <?= $status == 'DECLINED'? 'selected' : ''?>>DECLINED</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                    <button type="submit" name="btn_save" class="btn btn-primary btn-user btn-block col-sm-6"> Save </button>
                                                    <hr>
                                                    <a href="index.php" class="btn btn-google btn-user btn-block col-sm-6"> Cancel </a>
                                                    </div>
                                                </form>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

            </div>
        </div>
            
            <!-- End of Main Content -->

            <?php include'../footer.php';?>

        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../../js/sb-admin-2.min.js"></script>
    <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
      $(function () {
        $("#dataTable").DataTable({
          "responsive": true,
          "autoWidth": false,
          "bDestroy": true,
        });
      });
    function getLocation() {
        const latitude = <?=$lat?>;
        const longitude = <?=$lng?>;

        document.getElementById('lng').value = longitude;
        document.getElementById('lat').value = latitude;

        mapboxgl.accessToken = 'pk.eyJ1Ijoicm9tZ29kIiwiYSI6ImNsaTc2c3lpMzBsejgzZWx1eHF2N2szMDkifQ.f3wXh8auB8hZQ1oB_ojnNw';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v10',
            center: [longitude, latitude],
            zoom: 16
        });

        var draggableMarker = new mapboxgl.Marker({
            draggable: true
        }).setLngLat([longitude, latitude])
            .addTo(map);

        draggableMarker.on('dragend', function () {
            var lngLat = draggableMarker.getLngLat();
            console.clear();
            console.log(lngLat.lng + ', ' + lngLat.lat);
            document.getElementById('lng').value = lngLat.lng;
            document.getElementById('lat').value = lngLat.lat;
        });
    }
        </script>
</body>

</html>
<?php
}
else
{
    header('location:../../index.php');
}?>
