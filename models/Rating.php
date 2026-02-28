<?php

require_once __DIR__ . '/../classes/Model.php';

class Rating extends Model {
    protected $table = 'rating';

    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY rating DESC";
        return $this->fetchAll($sql);
    }

    public function getById($id) {
        $id = $this->escape($id);
        $sql = "SELECT * FROM {$this->table} WHERE id = '$id'";
        return $this->fetch($sql);
    }

    public function add($rating, $presentase_bonus) {
        $rating = $this->escape($rating);
        $presentase_bonus = $this->escape($presentase_bonus);

        $sql = "INSERT INTO {$this->table} (rating, presentase_bonus)
                VALUES ('$rating', '$presentase_bonus')";

        $this->execute($sql);
        return $this->getLastId();
    }

    public function update($id, $rating, $presentase_bonus) {
        $id = $this->escape($id);
        $rating = $this->escape($rating);
        $presentase_bonus = $this->escape($presentase_bonus);

        $sql = "UPDATE {$this->table} SET rating = '$rating', presentase_bonus = '$presentase_bonus'
                WHERE id = '$id'";

        $this->execute($sql);
        return $this->getAffectedRows();
    }

    public function delete($id) {
        $id = $this->escape($id);
        $sql = "DELETE FROM {$this->table} WHERE id = '$id'";
        return $this->execute($sql);
    }
}
