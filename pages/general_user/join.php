<?php
session_start();
include '../sqlCommands/connectDb.php';
include 'main.php';
include 'room.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shuttle Service</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/shuttle.css">

    <!-- Bootstrap CSS links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="../../assets/img/logo1.png">


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" charset="utf-8"></script>


    <!-- Custom Styles -->
    <style>
        /* Your custom styles here */

        /* Center the container */
        .shuttle-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Customize shuttle list styles */
        .shuttle-list {
            width: 80%;
            margin-top: 20px;
        }

        .shuttle-card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
        }

        .shuttle-card h4 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .shuttle-card p {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        .shuttle-card p.map-link {
            color: #007bff;
        }

        .btn.btn-uiu {
            background-color: rgb(46, 164, 79);
            color: white;
            border: none;
            height: 36px;
            width: 85px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            transition: box-shadow 0.15s;
        }

        .btn.btn-uiu:hover {
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.15);
        }

        .btn.btn-uiu1 {
            background-color: rgb(203, 0, 0);
            color: white;
            border: none;
            height: 36px;
            width: 105px;
            border-radius: 2px;
            cursor: pointer;
            margin-right: 8px;
            transition: opacity 0.15s;
        }

        .btn.btn-uiu1:hover {
            opacity: 0.8;
        }

        .btn.btn-uiu1:active {
            opacity: 0.4;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg bg-light fixed-top shadow-sm bg-white" style="padding-top: 0; padding-bottom: 0;">
        <div class="container-fluid">
            <a class="navbar-brand logo" href="#" style="padding-top: 0; padding-bottom: 0;">
                <img src="../../assets/img/logo1.png" alt="" style="width: 70px; height: 70px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="mainPage.php"> <i class="fa-solid fa-home-user"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="club_forum.php"><i class="fa-solid fa-people-group"></i> Club/Forum</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="join.php"> <i class="fa-solid fa-comment-dots"></i> Joined</a>
                    </li>

                    <li class="nav-item">
                            <div class="dropdown">
                                <?php if ($gender == "Female") {?>
                                    <img class="dropdown-toggle pro" src="../../img/Female.png" alt="img" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php } ?>
                                <?php if ($gender == "Male") { ?>
                                    <img class="dropdown-toggle pro" src="../../img/man.png" alt="img" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php } ?>
                                <?php if ($gender != "Male" && $gender != "Female") { ?>
                                    <img class="dropdown-toggle pro" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($image); ?>" alt="img" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php } ?>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="profile.php"><i class="fa-solid fa-user"></i> My Profile</a></li>
                                    <li><a class="dropdown-item" onclick="cpass('<?php echo $_SESSION['email']?>', '<?php echo $pass; ?>')"><i class="fa-solid fa-key"></i> Change Password</a></li>
                                    <li><a class="dropdown-item" href="../login/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Shuttle Container -->
    <div class="container py-5 shuttle-container">
        <div class="shuttle-list">

            <!-- joined -->
            <?php if (mysqli_num_rows($joined_q) == 0) : ?>
                <h2 class="text-center">Please join a forum discussion room first</h2>
            <?php else : ?>
                <?php while ($a_row = mysqli_fetch_assoc($joined_q)) : ?>
                    <div class="card w-60 m-auto mb-3 pt-2 mt-2" style="height: 200px; background-color: aqua;">
                        <div class="card-title text-center text-uppercase fw-bold" style="font-size: 1.8em;"><?php echo $a_row["forum_name"]; ?></div>
                        <div class="card-body">
                            <form action="chat.php" class="d-flex flex-column justify-content-center align-items-center" method="post">
                                <input type="hidden" name="joined_room" <?php echo "value='{$a_row["id"]}'" ?>>
                                <input type="hidden" name="forum" <?php echo "value='{$a_row["forum_name"]}'" ?>>
                                <div>
                                    <button class="btn btn-uiu" type="submit">Go</button>
                                    <a <?php echo "href='leaveForum.php?delete_forum={$a_row["id"]}'" ?> class="btn btn-uiu1 text-uppercase">
                                        Leave
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endwhile ?>
            <?php endif ?>


            <!-- Add more shuttle cards here -->
        </div>
    </div>





    <!-- Include necessary scripts and libraries here -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/all.min.js"></script>
    <script src="assets/js/custom.js"></script>
</body>

</html>