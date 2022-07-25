<?php

include("{$_SERVER['DOCUMENT_ROOT']}/shopmee/pages/header.php");
include("database/Connection.php");
include("database/SQLFunctions.php");

$sucessCode = 0; // 0 - sucess / 1 - error / 2 - not exist

if (isset($_POST['id'])) {
    $accountId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
} elseif (isset($_GET['id'])) {
    $accountId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $accountId = 0;
}

if ($accountId == 0 || $accountId == null) {
    $sucessCode = 1;
}

if ($sucessCode == 0) {
    $database = new SQLFunctions();

    if (!$database->selectAccountPerId(array($accountId))->fetch(PDO::FETCH_ASSOC)) {
        $sucessCode = 2;
    }
    else {
        $database->deleteAccount(array(
            $accountId
        ));
        if ($database->selectAccountPerId(array($accountId))->fetch(PDO::FETCH_ASSOC)) {
            $sucessCode = 1;
        }
    }
}
?>

<form class="container" action="tableManagement.php" method="POST">
    <div class="boxContainer"> 
        <div>
            <img src="images/shopmee.svg" alt="Shopmee" />
        </div>
        <div>
            <?php 
                if ($sucessCode == 0) {
                    echo "<h1>Cadastro foi deletado com sucesso.</h1>";
                }
                elseif ($sucessCode == 2) {
                    echo "<h1>Cadastro não foi encontrado ou já foi deletado.</h1>";
                }
                else {
                    echo "<h1>Ocorreu um problema ao deletar cadastro.</h1>";
                }
            ?>
            <button class="buttonBack" type="submit">
                Voltar
            </button>
        </div>
    </div>
</form>

<?php include("{$_SERVER['DOCUMENT_ROOT']}/shopmee/pages/footer.php"); ?>