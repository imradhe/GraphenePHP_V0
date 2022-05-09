<!DOCTYPE html>
<html lang="en">
<?php include("views/partials/head.php") ?>
<style>
    #app {
        margin-top: 16vh;
        max-height: 100vh !important;
    }
    img{
        user-select: none !important;
        pointer-events:none !important;
    }
    #app img {
        max-height: 40vh;
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
</style>

<body>
    <div id="app" class="container text-center">
        <img src="<?php assets("img/GraphenePHP.png");?>" alt="GraphenePHP logo" title="GraphenePHP logo" class="img-fluid mb-4">
        <h1>Welcome to your first <b>GraphenePHP</b> App</h1> 
        <a href="https://github.com/imradhe/graphenephp#readme" class="btn btn-graphene" rel="noopener"
            target="_blank">Documentation</a>
        <?php include('views/partials/footer.php') ;?>
    </div>
</body>

</html>