<?php

include("{$_SERVER['DOCUMENT_ROOT']}/shopmee/pages/header.php");
include("database/Connection.php");
include("database/SQLFunctions.php");

$sucessCode = 0; // 0 - sucess / 1 - error / 2 - not found

try {
    if (isset($_POST['id'])) {
        $accountId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
    } elseif (isset($_GET['id'])) {
        $accountId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        $accountId = 0;
    }

    if (isset($_POST['email'])) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    } elseif (isset($_GET['email'])) {
        $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
    } else {
        $email = "";
    }

    if (isset($_POST['data_collect'])) {
        $dataCollect = filter_input(INPUT_POST, 'data_collect', FILTER_SANITIZE_SPECIAL_CHARS);
    } elseif (isset($_GET['data_collect'])) {
        $dataCollect = filter_input(INPUT_GET, 'data_collect', FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        $dataCollect = 0;
    }

    if (isset($_POST['created_at'])) {
        $createdAt = filter_input(INPUT_POST, 'created_at', FILTER_SANITIZE_SPECIAL_CHARS);
    } elseif (isset($_GET['created_at'])) {
        $createdAt = filter_input(INPUT_GET, 'created_at', FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        $createdAt = "";
    }

    #update account in the database
    if ($accountId == 0 || $accountId == null) {
        $sucessCode = 1;
    }
    elseif ($email == 0 || $email == null) {
        $sucessCode = 1;
    } else {
        $database = new SQLFunctions();

        if (!$database->selectAccountPerId(array($accountId))->fetch(PDO::FETCH_ASSOC)) {
            $sucessCode = 2;
        }
        else {
            $database->updateAccount(array(
                $email,
                $dataCollect,
                $createdAt,
                $accountId
            ));
        }
    }
}
catch (Exception $e) {
    $sucessCode = 1;
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
                    echo "<h1>Cadastro foi atualizado com sucesso.</h1>";
                }
                elseif ($sucessCode == 2) {
                    echo "<h1>Cadastro não foi encontrado.</h1>";
                }
                else {
                    echo "<h1>Ocorreu um problema ao atualizar cadastro.</h1>";
                }
            ?>
            <button class="buttonBack" type="submit">
                Voltar
            </button>
        </div>
    </div>
</form>

<?php include("{$_SERVER['DOCUMENT_ROOT']}/shopmee/pages/footer.php"); ?>