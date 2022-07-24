<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;700&display=swap" rel="stylesheet/less">

    <link rel="stylesheet/less" type="text/css" href="styles/management.less" />
    <script>
        less = {
            env: "development"
        };
    </script>
    <script src="includes/less.js" type="text/javascript" data-env="development"></script>

    <link rel="shortcut icon" href="images/tool-favicon.jpg" type="image/jpg" />
    <title>Shopmee - Database</title>
</head>
<body>
    <form class="container" action="index.php" method="post">
        <div class="boxContainer"> 
            <div>
                <img src="images/shopmee.svg" alt="Shopmee" />
            </div>
            <div>
                <span>Contas cadastradas</span>
                <h1>Sistema: Edição permitida (Id não está permitido).</h1>
                <table>
                    <tr>
                        <td>Id</td>
                        <td>Email</td>
                        <td>Coletar Dados</td>
                        <td>Data de Criação</td>
                    </tr>

                    <?php
                        include("database/Connection.php");
                        include("database/SQLFunctions.php"); 

                        $database = new SQLFunctions();
                        $result = $database->selectAccounts();

                        while ($fetch = $result->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                            <tr>
                                <td><?php echo $fetch['id']; ?></td>
                                <td>
                                    <input name="email" value=<?php echo $fetch['email']; ?>></input>
                                </td>
                                <td>
                                    <input name="dataCollect" value=<?php echo $fetch['data_collect']; ?>></input>
                                </td>
                                <td>
                                    <input name="createdAt" value=<?php echo $fetch['created_at']; ?>></input>
                                </td>
                                <td>
                                    <a class="updateButton" 
                                        name="updateButton"
                                        href=
                                        <?php
                                            echo "tableUpdate.php?id=".$fetch['id']."&email=".$fetch['email']."&dataCollect=".$fetch['data_collect']."&createdAt=".$fetch['created_at'];
                                        ?>
                                    >
                                        Atualizar
                                    </a>
                                    <a class="deleteButton" 
                                        name="deleteButton"
                                        href=
                                        <?php
                                            echo "tableDelete.php?id=".$fetch['id'];
                                        ?>
                                    >
                                        Deletar
                                    </a>

                                </td>
                            </tr>
                    <?php
                        }
                    ?>
                </table>
                <button class="buttonBack" type="submit">
                    Voltar
                </button>
            </div>
        </div>
    </form>
</body>
</html>