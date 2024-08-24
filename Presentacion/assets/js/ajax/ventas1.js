const $ = el => document.querySelector(el)


function listar() {
  fetch('/ventas/listar', { method: 'get' })
  .then(result => result.json())
  .then(data => {
    const tbody = $('#datatable > tbody')
    tbody.innerHTML = GenerarFilas(data)
  })
}


function GenerarFilas(ventas) {
  let body = ''
  ventas.forEach((venta, index) => {
    body +=
    `<tr>
      <td class="text-center col-1">${index + 1}</td>
      <td class="text-left col-3">${venta.cliente.toUpperCase()}</td>
      <td class="text-left col-2">${venta.fecha_hora}</td>
      <td class="text-center col-1">${venta.usuario.toUpperCase()}</td>
      <td class="text-center col-1">${venta.total_venta}</td>
      <td class="col-2">
        <div class="d-flex justify-content-center">
          <button class="btn btn-sm" onclick="eliminar_venta(${venta.id_venta})"
            data-bs-toggle="tooltip" data-bs-title="Eliminar">
            <span class="msr fs-5">delete</span>
          </button>
        </div>
      </td>
    </tr>`
  });
  return body
}

listar()