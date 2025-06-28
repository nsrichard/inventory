<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Productos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-success" onclick="abrirFormulario()">➕ Nuevo producto</button>
    </div>

    <div class="container my-4">
        <form id="filter-form" class="row g-3 mb-3">
            <div class="col-md-4">
            <input type="text" class="form-control" name="name" placeholder="Buscar por nombre">
            </div>
            <div class="col-md-3">
            <select class="form-select" name="category_id" id="category-select">
                <option value="">Todas las categorías</option>
            </select>
            </div>
            <div class="col-md-2">
            <input type="number" class="form-control" name="price_min" placeholder="Precio mín.">
            </div>
            <div class="col-md-2">
            <input type="number" class="form-control" name="price_max" placeholder="Precio máx.">
            </div>
            <div class="col-md-1">
            <button type="submit" class="btn btn-primary w-100">🔍</button>
            </div>
        </form>

        <table class="table table-striped">
            <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th class="text-center">Acciones</th>
            </tr>
            </thead>
            <tbody id="product-table-body">
            <tr><td colspan="5" class="text-center">Cargando...</td></tr>
            </tbody>
        </table>

        <nav>
            <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>
    </div>

</div>

<div class="modal fade" id="productoModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="form-producto" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productoModalLabel">Crear producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id">
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" class="form-control" name="name" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Precio</label>
          <input type="number" class="form-control" name="price" min="0" step="0.01" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Stock</label>
          <input type="number" class="form-control" name="stock" min="0">
        </div>
        <div class="mb-3">
          <label class="form-label">Categoría</label>
          <select class="form-select" name="category_id" required></select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="detalleModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalles del producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detalleProducto">
        <p><strong>Nombre:</strong> <span id="ver-name"></span></p>
        <p><strong>Precio:</strong> <span id="ver-price"></span></p>
        <p><strong>Stock:</strong> <span id="ver-stock"></span></p>
        <p><strong>Categoría:</strong> <span id="ver-category"></span></p>
      </div>
    </div>
  </div>
</div>


<?php
$this->registerJsFile('@web/js/products.js', [
    'depends' => [\yii\web\YiiAsset::class],
]);
?>
