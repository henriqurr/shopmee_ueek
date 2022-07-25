<?php

class SQLFunctions extends Connection {

    private $Counter;
    private $Crud;

    private function preparedStatements($Query, $Parameters) {
        $this->Counter = count($Parameters);
        $this->Crud = $this->connect()->prepare($Query);

        if ($this->Counter > 0) {
            for ($i = 1; $i <= $this->Counter; $i++) {
                $this->Crud->bindValue($i, $Parameters[$i - 1]);
            }
        }

        $this->Crud->execute();
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