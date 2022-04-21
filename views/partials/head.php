<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?php echo $config['APP_DESC']; ?>" />
    <meta name="keywords" content="<?php echo $config['APP_KEYWORDS']; ?>" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="author" content="<?php echo $config['APP_AUTHOR']; ?>" />
    <meta name="robots" content="follow"/>
    <link rel="canonical" href="<?php echo url();?>" />

    <link rel=icon sizes=192x192 href="<?php echo home().$config['APP_ICON']; ?>" />
    <meta name="theme-color" content="<?php echo $config['APP_THEME_COLOR']; ?>" />

     <!-- OPEN GRAPH -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $config['APP_SHORT_TITLE']; ?>" />
    <meta property="og:url" content="<?php echo home(); ?>" />
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:creator" content="<?php echo home().$config['APP_TWITTER_CREATOR']; ?>">

    <meta property="og:image:secure_url" itemprop="image" content="<?php echo home().$config['APP_OG_ICON']; ?>"/>
    <meta property="og:image" itemprop="image" content="<?php echo home().$config['APP_OG_ICON']; ?>"/>

    <meta property="og:image:secure_url" itemprop="image" content="<?php echo home().$config['APP_OG_ICON_MOBILE']; ?>"/>
    <meta property="og:image" itemprop="image" content="<?php echo home().$config['APP_OG_ICON_MOBILE']; ?>"/>
    <meta property="og:description" content="<?php echo $config['APP_DESC']; ?>" />
    <meta property="og:site_name" content="<?php echo $config['APP_NAME']; ?>"/>
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css?family=Roboto+Condensed&subset=cyrillic&display=swap" onload="this.onload=null;this.rel='stylesheet'">



    

    
    <!-- Bootstrap core CSS -->
    <link href="<?php echo home();?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?php echo home();?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Jquery -->
    <script src="<?php echo home();?>assets/jquery/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <!-- Icons -->
    <script src="https://kit.fontawesome.com/30fd2510e8.js"></script>
    

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="<?php echo home().'assets/css/app.css';?>">

    <title><?php echo $config['APP_TITLE']; ?></title>
</head>




