<?php

class movementModel extends Model
{

  public $id;
  public $type;
  public $description;
  public $amount;
  public $created_at;
  public $updated_at;

  /**
   * Method to add a new movement
   *
   * @return integer
   */
  public function add()
  {
    $sql = 'INSERT INTO movements (type, description, amount, created_at) VALUES (:type, :description, :amount, :created_at)';
    $data =
      [
        'type' => $this->type,
        'description' => $this->description,
        'amount' => (float) $this->amount,
        'created_at' => now()
      ];

    try {
      return ($this->id = parent::query($sql, $data)) ? $this->id : false;
    } catch (Exception $e) {
      throw $e;
    }
  }

  /**
   * Method to load all movements from the database
   *
   * @return void
   */
  public function all()
  {
    $sql = 'SELECT *,
    COUNT(id) AS total,
    (SELECT SUM(amount) FROM movements WHERE type = "income") AS total_incomes,
    (SELECT SUM(amount) FROM movements WHERE type = "expense") AS total_expenses
    FROM movements 
    ORDER BY id DESC';
    try {
      return ($rows = parent::query($sql)) ? $rows : false;
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function all_by_date($date = null)
  {
    $date = $date === null ? now() : $date;

    $sql = 'SELECT *,
    (SELECT COUNT(id) FROM movements WHERE 
      MONTH(created_at) = MONTH(:current_date) AND 
      YEAR(created_at) = YEAR(:current_date)) AS total,
    (SELECT SUM(amount) FROM movements WHERE
    type = "income" AND 
    MONTH(created_at) = MONTH(:current_date) AND 
    YEAR(created_at) = YEAR(:current_date)) AS total_incomes,
    (SELECT SUM(amount) FROM movements WHERE
      type = "expense" AND 
      MONTH(created_at) = MONTH(:current_date) AND 
      YEAR(created_at) = YEAR(:current_date)) AS total_expenses
    FROM movements 
    WHERE MONTH(created_at) = MONTH(:current_date) AND YEAR(created_at) = YEAR(:current_date)
    ORDER BY id DESC';

    try {
      return ($rows = parent::query($sql, ['current_date' => $date])) ? $rows : false;
    } catch (Exception $e) {
      throw $e;
    }
  }

  /**
   * Method to load a record from the database using its id
   *
   * @return void
   */
  public function one()
  {
    $sql = 'SELECT * FROM movements WHERE id=:id LIMIT 1';
    try {
      return ($rows = parent::query($sql, ['id' => $this->id])) ? $rows[0] : false;
    } catch (Exception $e) {
      throw $e;
    }
  }

  /**
   * Method to update a record in the database
   *
   * @return bool
   */
  public function update()
  {
    $sql = 'UPDATE movements SET type=:type, description=:description, amount=:amount WHERE id=:id';
    $data =
      [
        'id' => $this->id,
        'type' => $this->type,
        'description' => $this->description,
        'amount' => (float) $this->amount,
      ];

    try {
      return (parent::query($sql, $data)) ? true : false;
    } catch (Exception $e) {
      throw $e;
    }
  }

  /**
   * Method to delete a movement from the database using the id
   *
   * @return void
   */
  public function delete()
  {
    $sql = 'DELETE FROM movements WHERE id=:id LIMIT 1';
    $data =
      [
        'id' => $this->id
      ];

    try {
      return (parent::query($sql, $data)) ? true : false;
    } catch (Exception $e) {
      throw $e;
    }
  }
}