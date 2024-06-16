<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <base href="/">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Lance Kenji Parce - KumaTech Developers">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ILINK - Internationalization and Collaboration Information System</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/public/assets/icons/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/assets/icons/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/assets/icons/favicon/favicon-16x16.png">
    <link rel="manifest" href="/public/assets/icons/favicon/site.webmanifest">
    <!-- /favicon -->

    <!-- Global stylesheets -->
    <link href="/public/assets/fonts/inter/inter.css" rel="stylesheet" type="text/css">
    <link href="/public/assets/icons/phosphor/styles.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="/public/assets/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
    <link href="/public/assets/css/ltr/all.min.css" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- <link href="/public/assets/css/animate.min.css" id="stylesheet" rel="stylesheet" type="text/css"> -->
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="/public/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="/public/assets/js/jquery/jquery.min.js"></script>
    <script src="/public/assets/js/vendor/tables/datatables/datatables.min.js"></script>
    <script src="/public/assets/js/vendor/notifications/sweet_alert.min.js"></script>
    <script src="/public/assets/js/vendor/visualization/d3/d3v5.min.js"></script>
    <script src="/public/assets/js/vendor/visualization/c3/c3.min.js"></script>
    <!-- <script src="/public/assets/js/vendor/forms/selects/select2.min.js"></script>
    <script src="/public/assets/js/vendor/ui/moment/moment.min.js"></script> -->
    <script src="/public/assets/js/vendor/pickers/daterangepicker.js"></script>
    <script src="/public/assets/js/vendor/pickers/datepicker.min.js"></script>
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script> -->
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/inline/ckeditor.js"></script> -->
    <script src="/public/assets/js/ckeditor.js"></script>
    <!-- /theme JS files -->

    <!-- Custom JS files -->
    <script src="/public/assets/js/app.js"></script>
    <script src="/public/assets/js/custom.js"></script>
    <!-- /custom JS files -->

    <!-- Pusher WebSocket for Realtime -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <!-- /pusher WebSocket for Realtime -->

    <style>
        .addCard {
            transition: all 0.3s ease-in-out;
            background: rgba(0, 0, 0, 0);
            color: black;
        }

        .addCard:hover {
            background: rgba(0, 0, 0, 255);
            color: white
        }

        .openChatBox {
            cursor: pointer;
        }

        .customSwal {
            justify-self: normal;
            align-self: stretch;
            text-align: initial;
        }

        /* .swal2-html-container {
            
        } */

        .datepicker-cell.has_event:not(.next):not(.prev) {
            background-color: #0C4B05;
            color: white;
        }

        .datepicker-cell.has_event:not(.next):not(.prev):hover {
            background-color: #0C4B05 !important;
            color: white;
        }

        .chatbox {
            width: 100%; 
            max-width: 400px !important; 
        }

        @media (max-width: 575.98px) {
            .chatbox {
                width: 170% !important; 
            }
        }

        @media (min-width: 576px) and (max-width: 767.98px) {
            .chatbox {
                width: 360px !important; 
            }
        }

        @media (min-width: 768px) and (max-width: 991.98px) {
            .chatbox {
                width: 350px !important; 
            }
        }

        @media (min-width: 992px) and (max-width: 1199.98px) {
            .chatbox {
                width: 400px !important; 
            }
        }

        @media (min-width: 1200px) {
            .chatbox {
                width: 400px !important; 
            }
        }
    </style>
</head>

<?php if(isset($_SESSION['user_id']) && ($_SESSION['user_role'] == 'partner' || $_SESSION['user_role'] == 'student')):?>
<script>
    var pusherx = new Pusher('faac39db04715651483d', {
        cluster: 'ap1'
    });

    var channelx = pusherx.subscribe('myProfile-<?=$_SESSION['user_id']?>');

    channelx.bind('update', function(data) {
        if (data.success == 'partner') {
            if(data.partner_photo) {
                $("#partnerPhoto").attr("src", data.partner_photo);
                $("#partnerPhoto1").attr("src", data.partner_photo);
            }

            $("#partnerName").html(data.partner_name);
            $("#partnerName1").text(data.partner_name_plain);
        } else if(data.success == 'student') {
            if(data.student_photo) {
                $("#studentPhoto").attr("src", data.student_photo);
                $("#studentPhoto1").attr("src", data.student_photo);
            }

            $("#studentName").html(data.student_name);
            $("#studentName1").text(data.student_name_plain);
        }

        $("#userEmail").html(data.user_email);
    });
</script>
<?php endif; ?>