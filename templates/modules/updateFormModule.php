<form class="bee_save_movement" novalidate>
  <input type="hidden" name="id" value="<?php echo $d->id; ?>">
  <div class="mb-3 row">
    <div class="col-xl-6">
      <label for="country">Movement type</label>
      <select class="custom-select d-block w-100" id="type" name="type" required>
        <?php foreach ([['none', 'Selecciona...'], ['expense', 'Expense'], ['income', 'Income']] as $option): ?>
          <option value="<?php echo $option[0] ?>" <?php echo $option[0] === $d->type ? 'selected' : ''; ?>>
            <?php echo $option[1]; ?>
          </option>
        <?php endforeach; ?>
      </select>
      <div class="invalid-feedback">
        Choose a valid movement type
      </div>
    </div>
    <div class="col-xl-6">
      <label for="descripcion">Description</label>
      <input type="text" class="form-control" id="description" name="description" placeholder="Description"
        value="<?php echo $d->description; ?>" required>
      <div class="invalid-feedback">
        Write a description
      </div>
    </div>
  </div>
  <div class="mb-3">
    <label for="amount">Amount</label>
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text">$</span>
      </div>
      <input type="text" class="form-control" id="amount" name="amount" placeholder="0.00"
        value="<?php echo $d->amount; ?>" required>
      <div class="invalid-feedback" style="width: 100%;">
        Ingress a valid amount
      </div>
    </div>
  </div>

  <button class="btn btn-primary btn-lg btn-block" type="submit">Save changes</button>
</form>