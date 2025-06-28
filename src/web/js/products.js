let currentPage = 1;

async function cargarCategoriasSelect(target) {
  const res = await fetch("/categories");
  const data = await res.json();
  target.innerHTML = '<option value="">Seleccione categoría</option>';
  data.data.forEach((c) => {
    const opt = new Option(c.name, c.id);
    target.appendChild(opt);
  });
}

async function fetchProducts(filters = {}) {
  filters.page = currentPage;
  const params = new URLSearchParams(filters);
  const res = await fetch(`/products?${params}`);
  const data = await res.json();

  renderProducts(data.data || data);
  renderPagination(data._meta?.pageCount || 1, data._meta?.currentPage || 1);
}

function renderProducts(products) {
  const tbody = document.getElementById("product-table-body");
  tbody.innerHTML = "";
  if (!products.length) {
    tbody.innerHTML =
      '<tr><td colspan="5" class="text-center">Sin resultados</td></tr>';
    return;
  }
  products.forEach((p) => {
    tbody.innerHTML += `
      <tr>
        <td>${p.name}</td>
        <td>${p.category?.name || "-"}</td>
        <td>$${parseFloat(p.price).toFixed(2)}</td>
        <td>${p.stock}</td>
        <td class="text-center">
            <button class="btn btn-sm btn-info me-1" onclick="verProducto(${
              p.id
            })">🔍</button>
            <button class="btn btn-sm btn-warning me-1" onclick="abrirFormulario(${
              p.id
            })">✏️</button>
            <button class="btn btn-sm btn-outline-danger" onclick="eliminarProducto(${
              p.id
            })" title="Eliminar">🗑️</button>
        </td>
      </tr>`;
  });
}

function renderPagination(totalPages, active) {
  const container = document.getElementById("pagination");
  container.innerHTML = "";
  for (let i = 1; i <= totalPages; i++) {
    const li = document.createElement("li");
    li.className = "page-item" + (i === active ? " active" : "");
    li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
    li.addEventListener("click", (e) => {
      e.preventDefault();
      currentPage = i;
      submitFilters();
    });
    container.appendChild(li);
  }
}

function submitFilters() {
  const fd = new FormData(document.getElementById("filter-form"));
  const filters = Object.fromEntries(fd.entries());
  fetchProducts(filters);
}

async function eliminarProducto(id) {
  if (!confirm("¿Estás seguro de eliminar este producto?")) return;

  const token = document.querySelector('meta[name="csrf-token"]').content;

  const res = await fetch(`/products/${id}`, {
    method: "DELETE",
    headers: { "Content-Type": "application/json", "X-CSRF-Token": token },
  });

  if (res.ok) {
    alert("Producto eliminado exitosamente.");
    submitFilters();
  } else {
    alert("No se pudo eliminar el producto.");
  }
}

var productoModal = null;
var detalleModal = null;

async function abrirFormulario(id = null) {
  const form = document.getElementById("form-producto");
  form.reset();
  form.id.value = id || "";
  document.getElementById("productoModalLabel").textContent = id
    ? "Editar producto"
    : "Nuevo producto";
  const select = form.category_id;
  await cargarCategoriasSelect(select);

  if (id) {
    const res = await fetch(`/products/${id}`);
    const prod = await res.json();
    for (const field of ["name", "price", "stock", "category_id"]) {
      form[field].value = prod.data[field];
    }
  }

  productoModal.show();
}

document
  .getElementById("form-producto")
  .addEventListener("submit", async function (e) {
    e.preventDefault();
    const fd = new FormData(this);
    const id = fd.get("id");
    const data = Object.fromEntries(fd.entries());

    const token = document.querySelector('meta[name="csrf-token"]').content;

    const res = await fetch(id ? `/products/${id}` : "/products", {
      method: id ? "PUT" : "POST",
      headers: { "Content-Type": "application/json", "X-CSRF-Token": token },
      body: JSON.stringify(data),
    });

    if (res.ok) {
      productoModal.hide();
      alert("Producto guardado");
      submitFilters();
    } else {
      alert("Error al guardar");
    }
  });

async function verProducto(id) {
  const res = await fetch(`/products/${id}`);
  const p = await res.json();

  document.getElementById("ver-name").textContent = p.data.name;
  document.getElementById("ver-price").textContent = `$${parseFloat(
    p.data.price
  ).toFixed(2)}`;
  document.getElementById("ver-stock").textContent = p.data.stock;
  document.getElementById("ver-category").textContent =
    p.data.category?.name || "-";

  detalleModal.show();
}

document.addEventListener("DOMContentLoaded", () => {
  productoModal = new bootstrap.Modal(document.getElementById("productoModal"));
  detalleModal = new bootstrap.Modal(document.getElementById("detalleModal"));

  const formFilter = document.getElementById("filter-form");
  cargarCategoriasSelect(formFilter.category_id);

  submitFilters();
  document.getElementById("filter-form").addEventListener("submit", (e) => {
    e.preventDefault();
    currentPage = 1;
    submitFilters();
  });
});
