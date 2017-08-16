<?php
require_once 'root.php';
if(isset($_SESSION['id']))
{
    header('location:home');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo CONFIG_SITE_NAME,' | ', CONNECTION; ?></title>
        <?php require_once 'inc/head.php'; ?>
    </head>
    <body>
        <?php require_once 'inc/header.php'; ?>
        <div class="content">
        <h1><?php echo CONNECTION; ?></h1>
        <div class="form-box">
        <?php
        $form=true;
        if(isset($_POST['sign_in']))
        {
            if(!empty($_POST['email']) AND !empty($_POST['password']))
            {
                $email=htmlspecialchars($_POST['email']);
                $password=htmlspecialchars($_POST['password']);
                if(filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $req_verif_user=bdd()->prepare('SELECT id, email, password FROM users WHERE email=?');
                    $req_verif_user->execute(array($email));
                    $existe_user=$req_verif_user->fetch();
                    if(!empty($existe_user))
                    {
                        if(password_verify($password, $existe_user['password']))
                        {
                            echo SIGN_IN_MESSAGE_BIENVENU;
                            $_SESSION['id']=$existe_user['id'];
                            $form=false;
                        }
                        else
                        {
                            echo SIGN_IN_MESSAGE_MOT_DE_PASSE_INCORRECT;
                        }
                    }
                    else
                    {
                        echo SIGN_IN_MESSAGE_CETTE_EMAIL_NE_CORRESPOND_A_AUCUN_COMPTE;
                    }
                }
                else
                {
                    echo SIGN_IN_MESSAGE_CETTE_EMAIL_NEST_PAS_VALIDE;
                }
            }
            else
            {
                echo SIGN_IN_MESSAGE_MERCI_DE_REMPLIR_TOUTS_LES_CHAMPS;
            }
        }
        if($form)
        {
        ?>
        <form action="" method="post">
            <input placeholder="<?php echo SIGN_IN_FORM_EMAIL ;?>" type="email" name="email"><br><br>
            <input placeholder="<?php echo SIGN_IN_FORM_MOT_DE_PASSE; ?>" type="password" name="password"><br><br>
            <input type="submit" name="sign_in" value="<?php echo SIGN_IN_FORM_SE_CONNECTER; ?>">
        </form>
        <?php
        }
        ?>
    </div>
    </div>
    </body>
</html>
