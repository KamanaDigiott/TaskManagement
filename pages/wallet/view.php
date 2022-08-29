<?php
include('../../docs/_includes/header.php');
$id = @$_REQUEST['id'];
// echo $id;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Wallet Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Wallet</a></li>
                        <li class="breadcrumb-item active">Wallet Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">


            <div class="hold-transition register-page" style="height: auto;padding:15px;">


                <div class="register-box" style="width: 95%;">
                    <div class="card card-outline card-primary">
                        <div class="card-header text-center">
                            <b>Wallet Details</b>
                            <div class=" mb-3" style="color: green;">
                                <h4><b>Total Amount : <span id="total_amt"></span></b></h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="alert" class="form-group"></div>
                            <div class="errorTxt form-group alert-danger"></div>
                            <div class="row">
                                <div class="input-group mb-3 col-sm-6">
                                    <div class="col-sm-6"><b>User Name :</b></div>
                                    <div class="col-sm-6"><span id="user_name"></span></div>
                                </div>
                                <div class="input-group mb-3 col-sm-6">
                                    <div class="col-sm-6"><b>Mobile Number :</b></div>
                                    <div class="col-sm-6"><span id="mobile"></span></div>
                                </div>
                                <!-- <div class="input-group mb-3 col-sm-6">
                                    <div class="col-sm-6"><b>Userd For :</b></div>
                                    <div class="col-sm-6"><span id="usedfor"></span></div>
                                </div> -->

                                <!-- <div class="input-group mb-3 col-sm-6">
                                <div class="col-sm-6"><b>Transation Status :</b></div>
                                <div class="col-sm-6"><span id="tran_status"></span></div>
                            </div> -->
                                <div class="input-group mb-3 col-sm-6">
                                    <div class="col-sm-6"><b>Amount :</b></div>
                                    <div class="col-sm-6"><span id="amount"></span></div>
                                </div>
                                <div class="input-group mb-3 col-sm-6">
                                    <div class="col-sm-6"><b>Transaction ID :</b></div>
                                    <div class="col-sm-6"><span id="trans_id"></span></div>
                                </div>
                            </div>
                        </div>
                        <!-- /.form-box -->
                    </div><!-- /.card -->
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('../../docs/_includes/footer.php');
?>
<!-- <script src="../../ajax/appointment_ajax.js"></script> -->
<script>
    $(document).ready(function() {
        // alert();
        var id = `<?php echo @$id; ?>`;
        $.ajax({
            type: 'GET',
            url: '../../API/wallet.php',
            dataType: "json",
            data: {
                id: id,
                action: 'wallet_id'
            },
            success: function(result) {
                if (result.success) {
                    let bookingRec = result.data;
                    $('#total_amt').text(bookingRec.Amount);
                    $('#user_name').text(bookingRec.FullName);
                    $('#mobile').text(bookingRec.UserMobileno);
                    $('#usedfor').html(bookingRec.UsedFor);
                    $('#tran_status').html(bookingRec.Tran_status);
                    $('#amount').html(bookingRec.Amount);
                    $('#trans_id').html(bookingRec.Trans_ID);
                }
            }
        });
    });
</script>