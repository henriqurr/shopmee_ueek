<?php

class SQLFunctions extends Connection {

    private $Crud;

    #Execute query
    private function preparedStatements($Query, $Parameters) {
        try {
            $Counter = count($Parameters);
            $this->Crud = $this->connect()->prepare($Query);

            if ($Counter > 0) {
                for ($i = 1; $i <= $Counter; $i++) {
                    $this->Crud->bindValue($i, $Parameters[$i - 1]);
                }
            }

            $this->Crud->execute();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function insertAccount($Parameters) {
        $this->preparedStatements(
            "INSERT INTO account (email, data_collect, created_at) VALUES (?, ?, ?)",
        $Parameters);
        return $this->Crud;
    }

    public function deleteAccount($Parameters) {
        $this->preparedStatements("DELETE FROM account WHERE id = ?", $Parameters);
        return $this->Crud;
    }

    public function updateAccount($Parameters) {
        $this->preparedStatements(
            "UPDATE account SET email = ?, data_collect = ?, created_at = ? WHERE id = ?",
            $Parameters);
        return $this->Crud;
    }

    public function selectAccounts() {
        $this->preparedStatements("SELECT * FROM account", array());
        return $this->Crud;
    }

    public function selectAccountPerId($Parameters) {
        $this->preparedStatements("SELECT * FROM account WHERE id = ?", $Parameters);
        return $this->Crud;
    }

    public function selectAccountPerEmail($Parameters) {
        $this->preparedStatements("SELECT * FROM account WHERE email = ?", $Parameters);
        return $this->Crud;
    }
}

?>