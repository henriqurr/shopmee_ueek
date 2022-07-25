<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<title>Shopmee - Download de Planilha</title>
	<head>
	<body>
        <?php
        include("database/Connection.php");
        include("database/SQLFunctions.php");

        $file = '';
        $file .= '
        <table border="1">
            <tr>
                <td>Id</td>
                <td>Email</td>
                <td>Coletar Dados</td>
                <td>Data de Criação</td>
            </tr>
        ';

        $database = new SQLFunctions();
        $result = $database->selectAccounts();

        while ($fetch = $result->fetch(PDO::FETCH_ASSOC)) {

            $file .= "
                <tr>
                    <td>{$fetch["id"]}</td>
                    <td>{$fetch["email"]}</td>
                    <td>{$fetch["data_collect"]}</td>
                    <td>{$fetch["created_at"]}</td>
                </tr>
            ";
        }

        $file .= ' </table>';

		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename = Cadastros.xls" );
		header ("Content-Description: PHP Generated Data" );

		echo $file;

        exit; ?>
    </body>
</html>