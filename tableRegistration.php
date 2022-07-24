<?php 

include("{$_SERVER['DOCUMENT_ROOT']}/shopmee/pages/header.php");
include("database/Connection.php");
include("database/SQLFunctions.php");

$sucessCode = 0; // 0 - sucess / 1 - error / 2 - already exist

if (isset($_POST['email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
} elseif (isset($_GET['email'])) {
    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
} else {
    $email = "";
}

if ($email == "" || $email == null) {
    $sucessCode = 1;
}

if ($sucessCode == 0) {
    $database = new SQLFunctions();

    if ($database->selectAccountPerEmail(array($email))->fetch(PDO::FETCH_ASSOC)) {
        $sucessCode = 2;
    }
    else {
        $database->insertAccount(array(
            $email,
            1, //true
            date('Y-m-d H:i')
        ));
        if (!$database->selectAccountPerEmail(array($email))->fetch(PDO::FETCH_ASSOC)) {
            $sucessCode = 1;
        }
    }
}
?>

<form class="container" action="index.php" method="post">
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