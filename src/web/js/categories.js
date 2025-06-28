let categoriaModal = null;
let detalleCategoriaModal = null;

async function cargarCategorias() {
  const res = await fetch("/categories");
  const data = await res.json();
  const tbody = document.getElementById("category-table-body");
  tbody.innerHTML = "";

  data.data.forEach((cat) => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${cat.name}</td>
      <td class="text-center">
        <button class="btn btn-sm btn-info me-1" onclick="verCategoria(${cat.id})">🔍</button>
        <button class="btn btn-sm btn-warning me-1" onclick="abrirFormularioCategoria(${cat.id})">✏️</button>
        <button class="btn btn-sm btn-danger" onclick="eliminarCategoria(${cat.id})">🗑️</button>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

function abrirFormularioCategoria(id = null) {
  const form = document.getElementById("form-categoria");
  form.reset();
  form.id.value = id || "";
  document.querySelector("#categoriaModal .modal-title").textContent = id
    ? "Editar categoría"
    : "Nueva categoría";

  if (id) {
    fetch(`/categories/${id}`)
      .then((res) => res.json())
      .then((cat) => {
        form.name.value = cat.data.name;
        categoriaModal.show();
      });
  } else {
    categoriaModal.show();
  }
}

document
  .getElementById("form-categoria")
  .addEventListener("submit", async function (e) {
    e.preventDefault();
    const fd = new FormData(this);
    const data = Object.fromEntries(fd.entries());
    const id = data.id;
    const token = document.querySelector('meta[name="csrf-token"]').content;

    const res = await fetch(id ? `/categories/${id}` : "/categories", {
      method: id ? "PUT" : "POST",
      headers: { "Content-Type": "application/json", "X-CSRF-Token": token },
      body: JSON.stringify(data),
    });

    if (res.ok) {
      categoriaModal.hide();
      alert("Categoría guardada");
      cargarCategorias();
    } else {
      alert("Error al guardar");
    }
  });

async function verCategoria(id) {
  const res = await fetch(`/categories/${id}`);
  const cat = await res.json();
  document.getElementById("ver-cat-id").textContent = cat.data.id;
  document.getElementById("ver-cat-name").textContent = cat.data.name;
  detalleCategoriaModal.show();
}

async function eliminarCategoria(id) {
  if (!confirm("¿Eliminar esta categoría?")) return;
  const token = document.querySelector('meta[name="csrf-token"]').content;

  const res = await fetch(`/categories/${id}`, {
    method: "DELETE",
    headers: { "X-CSRF-Token": token },
  });

  if (res.ok) {
    alert("Categoría eliminada");
    cargarCategorias();
  } else {
    alert("Error al eliminar");
  }
}

document.addEventListener("DOMContentLoaded", () => {
  categoriaModal = new bootstrap.Modal(
    document.getElementById("categoriaModal")
  );
  detalleCategoriaModal = new bootstrap.Modal(
    document.getElementById("detalleCategoriaModal")
  );
  cargarCategorias();
});
