<?php 
include("{$_SERVER['DOCUMENT_ROOT']}/shopmee/pages/header.php");
include("database/Connection.php");
include("database/SQLFunctions.php");

$sucessCode = 0; // 0 - sucess / 1 - error / 2 - not exist
$email = "";
$data_collect = 0;
$created_at = "";

try {
    if (isset($_POST['id'])) {
        $accountId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
    } elseif (isset($_GET['id'])) {
        $accountId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        $accountId = "";
    }

    $database = new SQLFunctions();
    $fetch = $database->selectAccountPerId(array($accountId))->fetch(PDO::FETCH_ASSOC);

    if ($fetch) {
        $email = $fetch['email'];
        $data_collect = $fetch['data_collect'];
        $created_at = $fetch['created_at'];
    } else {
        $sucessCode = 2;
    }
} catch (Exception $e) {
    $sucessCode = 1;
}
?>

<form class="container" action="tableUpdate.php" method="POST">
    <div class="boxContainer"> 
        <div>
            <img src="images/shopmee.svg" alt="Shopmee" />
        </div>
        <div>
            <?php 
                if ($sucessCode == 0) {
            ?>
                    <div>
                        <h1>ID (Não pode ser alterado)</h1>
                        <input name="id" placeholder="Id" type="number" value=
                            <?php echo "{$accountId}" ?>
                        readonly>
                    </div>
                    <div>
                        <h1>Email</h1>
                        <input name="email" placeholder="Email" type="text" value=
                            <?php echo "{$email}" ?>
                        >
                    </div>
                    <div>
                        <h1>Coletar Dados</h1>
                        <input name="data_collect" placeholder="Coletar Dados (0 ou 1)" type="number" value=
                            <?php echo "{$data_collect}" ?>
                        >
                    </div>
                    <div>
                        <h1>Data de Criação</h1>
                        <input name="created_at" placeholder="Data de Criação (YYYY-mm-dd)" type="text" value=
                            <?php echo "{$created_at}" ?>
                        >
                    </div>

                    <button type="submit">
                        Atualizar
                    </button>
                    <a class="painelButton" href="tableManagement.php">
                        <button type="button">
                            Voltar
                        </button>
                    </a>
            <?php
                }
                elseif ($sucessCode == 2) {
                    echo "<h1>Cadastro não foi encontrado.</h1>";
                }
                else {
                    echo "<h1>Ocorreu um problema ao editar cadastro.</h1>";
                }
                
                //show button back
                if ($sucessCode != 0) {
            ?>
                    <a class="buttonBack" href="tableManagement.php">
                        <button type="button">
                            Voltar
                        </button>
                    </a>
            <?php
                }
            ?>
        </div>
    </div>
</form>

<?php include("{$_SERVER['DOCUMENT_ROOT']}/shopmee/pages/footer.php"); ?>