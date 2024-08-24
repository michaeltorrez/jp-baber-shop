let contador = 1
let detalles = []
let ventaData = {}
const btnRealizarVenta = document.getElementById('btnRealizarVenta')
const MensajeModal = new bootstrap.Modal('#MensajeModal', { focus: true })

flatpickr("#fecha", {
  defaultDate: 'today',
  maxDate: 'today',
  dateFormat: "d/m/Y",
  locale: 'es'
});

document.addEventListener('DOMContentLoaded', function() {
  const select_cliente = $('#cliente');
  const agregar_item = $('#agregar_item');

  $(select_cliente).select2({
    placeholder: "Seleccione un cliente",
    allowClear: true,
    ajax: {
      url: '/clientes/listar',
      dataType: 'json',
      delay: 250,
      data: params => ({ q: params.term }),
      processResults: data => ({
        results: $.map(data, item => ({
          id: item.id_cliente,
          text: `${item.nombres} ${item.apellidos}`
        }))
      }),
      cache: true
    },
    minimumInputLength: 0
  })

  select_cliente.on('select2:select', function(e) {
    const { id } = e.params.data
    ventaData.id_cliente = id
    console.log(ventaData)
  })
  

  agregar_item.select2({
    placeholder: "Agregar un servicio o producto para agregar",
    allowClear: true,
    ajax: {
      url: '/ventas/listarItems',
      dataType: 'json',
      delay: 250,
      data: params => ({ q: params.term }),
      processResults: data => {
        const results = data.map(categoria => {
          return {
            text: categoria.nombre,
            children: categoria.items.map(producto => ({
              id: producto.id_producto ?? producto.id_servicio,
              text: producto.nombre,
              data: producto
            }))
          }
        })
        return { results }
      },
      cache: true
    },
    minimumInputLength: 0,
    templateResult: template
  });

  agregar_item.on('select2:select', function(e) {
    agregar_item.val(null).trigger('change');
    nuevo_item(e.params.data.data);
  });
});

function template(state) {
  if (!state.id) {
    return state.text;
  }

  const baseUrl = `../files/productos/${state.data.imagen}`;
  return $(`
    <div class="d-flex align-items-center">
      <img class="rounded-3 img-sm" src="${baseUrl}" alt="s">
      <div class="ms-3 flex-grow-1">
        <h5 class="mb-0">${state.data.nombre}</h5>
        <div class="d-flex justify-content-between">
          <span class="flex-grow-1">${state.data.descripcion}</span>
          ${state.data.id_producto ? `<span class="px-4">disponible: ${state.data.stock}</span>`: '<span></span>'}
          <span>Precio: ${state.data.precio}</span>
        </div>
      </div>
    </div>
  `);
}

function nuevo_item(data) {
  const { id_producto, id_servicio, imagen, nombre, precio, stock } = data;
  const tbody = document.getElementById('table-body-items');

  if (document.querySelector(`#table-body-items tr[data-id='${id_producto}']`)) {
    return;
  }

  data.cantidad = 1
  detalles.push(data)
  const fila = document.createElement('tr');
  fila.id = `item-${contador}`;
  fila.setAttribute('data-id', id_producto ?? id_servicio);

  const itemHTML = `
    <td scope="row" class="text-center">${contador}</td>
    <td>
      <div class="d-flex align-items-center">
        <img class="rounded-3 img-sm" src="../files/productos/${imagen}" alt="s">
        <div class="ms-3">
          <h5 class="mb-0">${nombre}</h5>
        </div>
      </div>
    </td>
    <td><span name="precio">${precio}</span></td>
    <td><input type="number" class="form-control" name="input-cantidad-${id_producto ?? id_servicio}" value="1" min="1" max="${stock}" /></td>
    <td><span name="sub_total">${precio}</span></td>
    <td>
      <button type="button" class="btn btn-sm" onclick="eliminarItem(this)">
        <span class="msr">delete</span>
      </button>
    </td>
  `;

  fila.innerHTML = itemHTML;
  tbody.appendChild(fila);
  actualizarNumerosDeItem();
  actualizarTotales();
  contador++;
}

document.querySelector('#table-body-items').addEventListener('change', function(e) {
  if (e.target && e.target.matches('input[name^="input-cantidad-"]')) {
    const itemSeleccionado = e.target.closest('tr')
    const id = itemSeleccionado.getAttribute('data-id')
    const cantidad = e.target.value === "" ? 0 : parseInt(e.target.value)

    // Actualizar la cantidad en el array de objetos
    detalles = detalles.map(item => {
      if (item.id_producto === id || item.id_servicio === id) {
        item.cantidad = cantidad;
      }
      return item;
    });

    debouncedUpdate(itemSeleccionado)
  }
})

function debounce(func, wait) {
  let timeout;
  return function(...args) {
    clearTimeout(timeout);
    timeout = setTimeout(() => func.apply(this, args), wait);
  };
}

const debouncedUpdate = debounce(function(fila) {
  actualizarSubtotal(fila);
  actualizarTotales();
}, 300);





function eliminarItem(boton) {
  const fila = boton.closest('tr');
  detalles = detalles.filter(item => item.id_producto !== fila.getAttribute('data-id'));
  fila.remove();
  actualizarNumerosDeItem();
  actualizarTotales();
}

function actualizarSubtotal(fila) {
  const precio = parseFloat(fila.querySelector('span[name="precio"]').textContent);
  const cantidad = parseInt(fila.querySelector('input').value);
  const subTotal = precio * cantidad;
  fila.querySelector('span[name="sub_total"]').textContent = subTotal.toFixed(2);
}

function actualizarTotales() {
  const subTotalGeneral = detalles.reduce((acumulado, item) => acumulado + (item.cantidad * item.precio), 0);
  const descuento = 0; // Aquí puedes calcular el descuento si aplica.
  const total = subTotalGeneral - descuento;

  document.getElementById('detalle-subtotal').textContent = subTotalGeneral.toFixed(2);
  document.getElementById('detalle-discount').textContent = `- ${descuento.toFixed(2)}`;
  document.getElementById('detalle-total').textContent = total.toFixed(2);
}

function actualizarNumerosDeItem() {
  const rows = document.querySelectorAll('#table-body-items tr');
  rows.forEach((row, index) => {
    const itemNumberCell = row.querySelector('td:first-child');
    itemNumberCell.textContent = index + 1;
  });
}

function AgregarVenta() {
  console.log(detalles.length,ventaData.id_cliente)
  if (detalles.length > 0 && ventaData.id_cliente) {
    // Mostrar el modal de confirmación de venta
    const ConfirmarVentaModal = new bootstrap.Modal('#ConfirmarVentaModal', { focus: true });
    ConfirmarVentaModal.show();

    // Asegurarse de que solo se asigne el evento 'click' una vez
    document.getElementById('btnRealizarVenta').removeEventListener('click', RealizarVenta);
    document.getElementById('btnRealizarVenta').addEventListener('click', () => {
      ConfirmarVentaModal.hide()
      RealizarVenta()
    })
  } else {
    // Mostrar el modal de mensaje de error
    MensajeModal.show();
    document.getElementById('title').textContent = 'Error'
    document.getElementById('content').textContent = 'Debes seleccionar un cliente y al menos 1 ítem (producto o servicio).'
  }
}





function RealizarVenta() {
  // Crear un nuevo FormData
  const formData = new FormData();
  
  // Agregar los datos de la venta al FormData
  const TotalGeneral = detalles.reduce((acumulado, item) => acumulado + (item.cantidad * item.precio), 0);
  formData.append('id_cliente', ventaData.id_cliente);
  formData.append('total_venta', TotalGeneral);
  formData.append('detalles', JSON.stringify(detalles))
  
  fetch('/ventas/nueva', { method: 'POST', body: formData })
  .then(result => result.json())
  .then(data => {
    switch (data.status) {
      case 'success':
        sessionStorage.setItem('toastMessage', data.message);
        window.location.replace('/ventas')
        break
        
      case 'error':
        MensajeModal.show();
        document.getElementById('btnOK').addEventListener('click', () => {
          MensajeModal.hide()
          window.location.href = '/ventas'
        })
        //document.getElementById("close-modal").click()
      //toastr['error'](data.message)
      break
    }
  })
  .catch(error => {
    console.error('Error:', error);
  });
}


