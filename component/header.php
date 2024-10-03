<nav class="navbar navbar-expand-xl navbar-light" style="padding: 0;">
    <div class="container-fluid" style="background: #fff; border-bottom: 1px solid rgb(0 0 0 / 5%);">
        <a class="navbar-brand" href="#">
            <img src="./image/logo.png" alt="" width="350" height="62" class="d-inline-block align-text-top">
        </a>
        <div class="d-flex">
            <span class="text fs-3 fw-bolder">
                MEETING ROOM BOOKING SYSTEM
            </span>
        </div>
        <div class="d-xxl-flex fs-5 px-1">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item me-2 px-3 py-1">
                        <a class="nav-link" aria-current="page" href="booking.php">Booking</a>
                    </li>
                    <li class="nav-item me-2 px-3 py-1">
                        <a class="nav-link" aria-current="page" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item me-2 px-3 py-1">
                        <a class="nav-link" aria-current="page" href="<?php echo $staffAcc; ?>">User</a>
                    </li>
                    <li class="nav-item me-2 px-3 py-1">
                        <a id="logout" href="#">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</nav>