<?php 
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

include("{$_SERVER['DOCUMENT_ROOT']}/shopmee/pages/header.php");
include("database/Connection.php");
include("database/SQLFunctions.php");

$sucessCode = 0; // 0 - sucess / 1 - error / 2 - already exist / 3 - can not

try {
    if (isset($_POST['email'])) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    } elseif (isset($_GET['email'])) {
        $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
    } else {
        $email = "";
    }

    #create in the database
    if ($email == "" || $email == null) {
        $sucessCode = 1;
    } elseif (!str_contains($email, '@') || strlen($email) < 10) {
        $sucessCode = 3;
    } else {
        $database = new SQLFunctions();

        if ($database->selectAccountPerEmail(array($email))->fetch(PDO::FETCH_ASSOC)) {
            $sucessCode = 2;
        }
        else {
            $database->insertAccount(array(
                $email,
                1, //true
                date('Y-m-d')
            ));
            if (!$database->selectAccountPerEmail(array($email))->fetch(PDO::FETCH_ASSOC)) {
                $sucessCode = 1;
            }
        }
    }
} catch (Exception $e) {
    $sucessCode = 1;
}

#send email
/*if ($sucessCode == 0) {
    $mail = new PHPMailer();
    
    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->CharSet = 'UTF-8';
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'ProjectBrazilliansBR@gmail.com';                     //SMTP username
        $mail->Password   = 'projectbrazilliansbrasil2016';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('ProjectBrazilliansBR@gmail.com', 'Shopmee');
        $mail->addAddress($email, 'Usuário');     //Add a recipient

        //Content
        $mail->isHTML(true);                           //Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->Subject = 'Test subject';
        $mail->Body    = 'Test body';
    
        if ($mail->send()) {
            echo 'Message has been sent';
        }
    } catch (Exception $e) {
    }
}*/
?>

<form class="container" action="index.php" method="POST">
    <div class="boxContainer"> 
        <div>
            <img src="images/shopmee.svg" alt="Shopmee" />
        </div>
        <div>
            <?php 
                if ($sucessCode == 0) {
                    echo "<h1>Cadastro foi realizado com sucesso.</h1>";
                }
                elseif ($sucessCode == 2) {
                    echo "<h1>O email já está cadastrado.</h1>";
                }
                elseif ($sucessCode == 3) {
                    echo "<h1>O email não pode ser cadastrado.</h1>";
                }
                else {
                    echo "<h1>Ocorreu um problema ao realizar cadastro.</h1>";
                }
            ?>
            <button class="buttonBack" type="submit">
                Voltar
            </button>
        </div>
    </div>
</form>

<?php include("{$_SERVER['DOCUMENT_ROOT']}/shopmee/pages/footer.php"); ?>