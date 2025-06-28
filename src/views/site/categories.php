<?php

use yii\helpers\Html;

$this->title = 'Categorías';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container my-4">
  <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

  <div class="d-flex justify-content-end mb-3">
    <button class="btn btn-success" onclick="abrirFormularioCategoria()">➕ Nueva categoría</button>
  </div>

  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>Nombre</th>
        <th class="text-center">Acciones</th>
      </tr>
    </thead>
    <tbody id="category-table-body">
      <tr><td colspan="2" class="text-center">Cargando...</td></tr>
    </tbody>
  </table>
</div>

<!-- Modal Crear/Editar -->
<div class="modal fade" id="categoriaModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="form-categoria" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id">
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" class="form-control" name="name" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Ver -->
<div class="modal fade" id="detalleCategoriaModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalles de categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>ID:</strong> <span id="ver-cat-id"></span></p>
        <p><strong>Nombre:</strong> <span id="ver-cat-name"></span></p>
      </div>
    </div>
  </div>
</div>

<?php
$this->registerJsFile('@web/js/categories.js', [
    'depends' => [\yii\web\YiiAsset::class],
]);
?>