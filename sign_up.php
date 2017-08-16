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
        <title><?php echo CONFIG_SITE_NAME,' | ', INSCRIPTION; ?></title>
        <?php require_once 'inc/head.php'; ?>
    </head>
    <body>
        <?php require_once 'inc/header.php'; ?>
        <div class="content">
        <h1><?php echo INSCRIPTION; ?></h1>
        <div class="form-box">
        <?php
        $form=true;
        if(isset($_POST['sign_up']))
        {
            if(!empty($_POST['email']) AND !empty($_POST['email_verif']) AND !empty($_POST['username']) AND !empty($_POST['password']) AND !empty($_POST['password_verif']))
            {
                $email=htmlspecialchars($_POST['email']);
                $email_verif=htmlspecialchars($_POST['email_verif']);
                $username=htmlspecialchars($_POST['username']);
                $password=password_hash($_POST['password'], PASSWORD_BCRYPT);
                if($email==$email_verif)
                {
                    if($_POST['password']==$_POST['password_verif'])
                    {
                        if(filter_var($email, FILTER_VALIDATE_EMAIL))
                        {
                            $username_lenght=strlen($username);
                            if($username_lenght <= 15)
                            {
                                if($username_lenght >= 4)
                                {
                                    $req_email_exist=bdd()->prepare('SELECT email FROM users WHERE email=?');
                                    $req_email_exist->execute(array($email));
                                    $verif_email=$req_email_exist->fetch();
                					if(empty($verif_email))
                                    {
                                        $req_username_exist=bdd()->prepare('SELECT email FROM users WHERE email=?');
                                        $req_username_exist->execute(array($email));
                                        $verif_username=$req_username_exist->fetch();
                                        if(empty($verif_username))
                                        {
                                            $new_user=bdd()->prepare('INSERT INTO users (username, email, password, register_date) VALUES (:username, :email, :password, :register_date)');
                                            $new_user->execute(array(
                                                                    'username'      =>   $username,
                                                                    'email'         =>   $email,
                                                                    'password'         =>   $password,
                                                                    'register_date' =>   time()));
                                            $form=false;
                                            echo SIGN_UP_MESSAGE_COMPTE_CREER;
                                        }
                                        else
                                        {
                                            echo SIGN_UP_MESSAGE_CE_NOM_DUTILISATEUR_EST_DEJA_UTILISER_PAR_UN_AUTRE_COMPTE;
                                        }
                                    }
                                    else
                                    {
                                        echo SIGN_UP_MESSAGE_CETTE_EMAIL_EST_DEJA_UTILISER_PAR_UN_AUTRE_COMPTE;
                                    }
                                }
                                else
                                {
                                    echo SIGN_UP_MESSAGE_CE_NOM_DUTILISATEUR_EST_TROP_COURT;
                                }
                            }
                            else
                            {
                                echo SIGN_UP_MESSAGE_CE_NOM_DUTILISATEUR_EST_TROP_LONG;
                            }
                        }
                        else
                        {
                            echo SIGN_UP_MESSAGE_CETTE_EMAIL_NEST_PAS_VALIDE;
                        }
                    }
                    else
                    {
                        echo SIGN_UP_MESSAGE_LES_DEUX_MOTS_DE_PASSE_NE_CORRESPONDENT_PAS;
                    }
                }
                else
                {
                    echo SIGN_UP_MESSAGE_LES_DES_EMAILS_NE_CORRESPONDENT_PAS;
                }
            }
            else
            {
                echo SIGN_UP_MESSAGE_MERCI_DE_REMPLIR_TOUTS_LES_CHAMPS;
            }
        }
        if($form)
        {
        ?>
        <form action="" method="post">
            <input placeholder="<?php echo SIGN_UP_FORM_VOTRE_ADRESSE_EMAIL ;?>" type="email" name="email"><br><br>
            <input placeholder="<?php echo SIGN_UP_FORM_CONFIRMEZ_VOTRE_EMAIL ;?>" type="email" name="email_verif"><br><br>
            <input placeholder="<?php echo SIGN_UP_FORM_NOM_DUTILISATEUR ;?>" type="text" name="username"><br><br>
            <input placeholder="<?php echo SIGN_UP_FORM_MOT_DE_PASSE ;?>" type="password" name="password"><br><br>
            <input placeholder="<?php echo SIGN_UP_FORM_CONFIRMEZ_VOTRE_MOT_DE_PASSE ;?>" type="password" name="password_verif"><br><br>
            <input type="submit" name="sign_up" value="<?php echo SIGN_UP_FORM_SINSCRIRE; ?>">
        </form>
        <?php
        }
        ?>
    </div>

            </div>
    </body>
</html>
