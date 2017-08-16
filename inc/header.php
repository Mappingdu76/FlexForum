<header>
    <nav class="menu">
    <a href="index.php"><?php echo ACCUEIL; ?></a>
    <?php
    if(isset($_SESSION['id']))
    {
    ?>
    <a href="sign_out.php"><?php echo SIGN_OUT; ?></a>
    <?php
    }
    else
    {
    ?>
    <a href="sign_up.php"><?php echo SIGN_UP; ?></a>
    <a href="sign_in.php"><?php echo SIGN_IN; ?></a>
    <?php
    }
    ?>
    </nav>
</header>
