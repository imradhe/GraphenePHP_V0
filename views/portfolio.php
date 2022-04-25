<!DOCTYPE html>
<html lang="en">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    #app {
        margin-top: 16vh;
        max-height: 100vh !important;
    }

    img {
        user-select: none !important;
        pointer-events: none !important;
    }

    #app img {
        max-height: 40vh;
    }

    * {
        color: white;
    }

    .btn-graphene {
        font-weight: bolder;
        letter-spacing: 1px;
        padding: 8px 28px;
        border-radius: 50px;
        transition: 0.5s;
        margin: 10px;
        background-color: rgba(173, 220, 203);
        color: #000;
        border: 2px solid #ADDCCB;
    }

    .btn-graphene:hover,
    .btn-graphene:active,
    .btn-graphene:focus {
        background-color: rgba(173, 220, 203, .3);
        border: 2px solid #ADDCCB;
        color: #000;
    }

    .bg-main {
        background-image: url(../assets/img/banner.gif);
        width: 100%;
        min-height: 100vh;
        background-color: #050A30 !important;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        background-position-x: center;
        font-family: 'Josefin Sans';
        transition: 0.5s;
        text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .5);
        box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);
    }

    .profile-pic {
        border-radius: 50%;
        max-height: 30vh;
    }

    .mainContainer {
        margin: 20vh 0;
    }
    
    @media (max-width: 991px) {
        .row{
            justify-content: center;
            text-align: center !important;
        }
    }

    header{
        min-height: 100vh;
    }

</style>

<body id="page-top" data-bs-spy="scroll" data-bs-target="#mainNav">


    <nav class="navbar navbar-light navbar-expand-lg fixed-top" id="mainNav">
        <div class="container"><a class="navbar-brand" href="#page-top">Radhe Shyam Salopanthula</a><button data-bs-toggle="collapse" data-bs-target="#navbarResponsive" class="navbar-toggler float-end" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#download">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Projects</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="masthead bg-main">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-5 my-auto">
                    <div class="device-container">
                        <div class="device-mockup iphone6_plus portrait white">
                            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" class="profile-pic">                                
                        </img>
                    </div>
                </div>
                <div class="col-lg-7 my-auto">
                    <div class="mx-auto header-content">
                        <h1 class="mb-5">Hello there! 😉<br></h1><a class="btn btn-outline-warning btn-xl" role="button" href="#download">Start Now for Free!</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/new-age.js"></script>
</body>

</html>