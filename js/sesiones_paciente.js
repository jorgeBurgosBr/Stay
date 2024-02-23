let fechaActual = new Date();
let mesMostrado = fechaActual.getMonth();
let añoMostrado = fechaActual.getFullYear();
dibujarCalendario(mesMostrado, añoMostrado);
cargarCitas(mesMostrado, añoMostrado);

document.getElementById('mesAnterior').addEventListener('click', function() {
  if (mesMostrado === 0) {
    mesMostrado = 11;
    añoMostrado -= 1;
  } else {
    mesMostrado -= 1;
  }
  dibujarCalendario(mesMostrado, añoMostrado);
  cargarCitas(mesMostrado, añoMostrado);
});

document.getElementById('mesSiguiente').addEventListener('click', function() {
  if (mesMostrado === 11) {
    mesMostrado = 0;
    añoMostrado += 1;
  } else {
    mesMostrado += 1;
  }
  dibujarCalendario(mesMostrado, añoMostrado);
  cargarCitas(mesMostrado, añoMostrado);
});

function cargarCitas(mes, año) {
  // Preparar los datos a enviar
  const datos = new FormData();
  datos.append('mes', mes + 1); // Ajustar porque JavaScript cuenta meses desde 0
  datos.append('anio', año);

  fetch("./php/procesar_sesiones.php", {
    method: "POST",
    body: datos,
  })
  .then(response => response.json())
  .then(data => {
    console.log('Datos obtenidos:', data);
    pintarCitas(data.citas);
  })
  .catch(error => {
    console.error('Error:', error);
  });
}

function pintarCitas(array) {
  array.forEach(element => {
    let dia = element.dia;
    let hora = element.hora;
    let doctor = element.nombre_psicologo;
    var spans = document.querySelectorAll('.celda:not(.pasado_futuro) > .num_dia');
    for (let span of spans) {
      if (span.textContent.trim() === dia) {
        spanConDiaEspecifico = span;
        break; // Detiene el bucle una vez encontrado el elemento
      }
    }
    let sesion = `<div class='etiqueta_cita'>${hora}-Sesión con ${doctor}</div>`;
    spanConDiaEspecifico.insertAdjacentHTML('afterend', sesion);
  });
}

// 
function dibujarCalendario(mes, año) {
  const diasEnMes = new Date(año, mes + 1, 0).getDate(); // Días en el mes
  let primerDia = new Date(año, mes, 1).getDay(); // Día de la semana del primer día
  primerDia = primerDia === 0 ? 6 : primerDia - 1; // Ajusta para que la semana comience en lunes
  const ultimoDiaMesAnterior = new Date(año, mes, 0).getDate(); // Último día del mes anterior

  // Selecciona el contenedor del calendario y limpia su contenido anterior
  const contenedorCalendario = document.querySelector('.container_cal');
  contenedorCalendario.innerHTML = ''; // Limpia el calendario

  // Agrega los días de la semana al principio
  const diasSemana = ['L', 'M', 'X', 'J', 'V', 'S', 'D'];
  diasSemana.forEach(dia => {
    contenedorCalendario.innerHTML += `<div class="celda dias_semana">${dia}</div>`;
  });

  // Añade los días del mes anterior para completar la primera semana
  for (let i = 0; i < primerDia; i++) {
    contenedorCalendario.innerHTML += `<div class="celda pasado_futuro"><span class="num_dia">${ultimoDiaMesAnterior - primerDia + i + 1}</span></div>`;
  }

  // Añade los días del mes actual
  for (let dia = 1; dia <= diasEnMes; dia++) {
    contenedorCalendario.innerHTML += `<div class="celda"><span class="num_dia">${dia}</span></div>`;
  }

  // Completa la última semana con días del siguiente mes si es necesario
  const totalCeldas = 42; // Total de celdas en el calendario (6 semanas * 7 días)
  const celdasActuales = primerDia + diasEnMes;
  for (let dia = 1; celdasActuales + dia <= totalCeldas; dia++) {
    contenedorCalendario.innerHTML += `<div class="celda pasado_futuro"><span class="num_dia">${dia}</span></div>`;
  }
}
