<!DOCTYPE html>
<html lang="en">
<?php include("views/partials/head.php") ?>


<body>

    <?php require('views/partials/nav.php');?>

    <div id="app" class="container text-center">

    
        <img src="<?php assets("img/MotoBase.png");?>" alt="MotoBase logo" title="MotoBase logo" class="img-fluid mb-4">
        <h1>Car Rental at <b>Ease.</b></h1> 
        <a href="<?php echo route('search');?>" id="search" class="btn btn-motobase" rel="noopener">Rent A Car</a>
        <a href="<?php echo route('register/host');?>" id="registerHost" class="btn btn-motobase" rel="noopener">Become A Host</a>
        <p><?php if($user = getSession()) echo $user['email']." Logged In"; else "Logged Out"; ?></p>
        <?php include('views/partials/footer.php') ;?>
    </div>


    <script>
        var search = document.querySelector('#search')
        var registerHost = document.querySelector('#registerHost')
        <?php
            if(getUser()['role'] == 'customer'){
                ?>
                registerHost.innerText = 'Profile'
                registerHost.href = '<?php echo route("profile");?>'
                <?php
            }elseif(getUser()['role'] == 'host'){
                ?>
                search.style.display = 'none'
                registerHost.innerText = 'Profile'
                registerHost.href = '<?php echo route("profile");?>'
                <?php
            }
        ?>
    </script>
</body>

</html>