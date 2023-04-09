<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PHP Test Application</title>

    <link nonce="<?=$_SESSION['nonce']?>" href="favicon.ico" type="image/x-icon" rel="icon" />
    <link nonce="<?=$_SESSION['nonce']?>" href="favicon.ico" type="image/x-icon" rel="shortcut icon" />

    <link nonce="<?=$_SESSION['nonce']?>" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin>
    <link nonce="<?=$_SESSION['nonce']?>" rel="stylesheet" type="text/css" href="css/application.css">

    <script nonce="<?=$_SESSION['nonce']?>" defer src="https://www.google.com/recaptcha/api.js?render=6Lcf01ElAAAAAAD2SziA020840uSyVwgxzZyiss8&trustedtypes=true"></script>
    <script nonce="<?=$_SESSION['nonce']?>" type="module" src="../node_modules/jquery/dist/jquery.min.js" integrity="sha384-UG8ao2jwOWB7/oDdObZc6ItJmwUkR/PfMyt9Qs5AwX7PsnYn1CRKCTWyncPTWvaS" crossorigin></script>
    <script nonce="<?=$_SESSION['nonce']?>" defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin></script>
    <script nonce="<?=$_SESSION['nonce']?>" type="module" src="../js/src/index.js"></script>

</head>
<body>
<div id="main" class="main container-lg bg-light" aria-label="Website Content">
    <?= $content ?>
</div>

</body>
</html>