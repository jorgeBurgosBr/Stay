let fechaActual = new Date();
let mesMostrado = fechaActual.getMonth();
let añoMostrado = fechaActual.getFullYear();
dibujarCalendario(mesMostrado, añoMostrado);
cargarCitas(mesMostrado, añoMostrado);

document.getElementById('mesAnterior').addEventListener('click', function () {
  if (mesMostrado === 0) {
    mesMostrado = 11;
    añoMostrado -= 1;
  } else {
    mesMostrado -= 1;
  }
  dibujarCalendario(mesMostrado, añoMostrado);
  cargarCitas(mesMostrado, añoMostrado);
});

document.getElementById('mesSiguiente').addEventListener('click', function () {
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
  // Encuentra el primer y último día del mes
  let primerDiaMes = new Date(año, mes, 1);
  let ultimoDiaMes = new Date(año, mes + 1, 0);

  // Ajusta al primer día visible en el calendario
  let primerDiaVisible = new Date(primerDiaMes);
  primerDiaVisible.setDate(primerDiaVisible.getDate() - primerDiaVisible.getDay() + (primerDiaVisible.getDay() === 0 ? -6 : 1));

  // Ajusta al último día visible en el calendario
  let ultimoDiaVisible = new Date(ultimoDiaMes);
  ultimoDiaVisible.setDate(ultimoDiaVisible.getDate() + (7 - ultimoDiaVisible.getDay()));

  // Formatea las fechas para la solicitud
  let fechaInicio = formatearFechaISO(primerDiaVisible);
  let fechaFin = formatearFechaISO(ultimoDiaVisible);

  // Preparar los datos a enviar
  const datos = new FormData();
  datos.append('fechaInicio', fechaInicio);
  datos.append('fechaFin', fechaFin);

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
    // Convertimos dia a número y lo reconvertimos a string de nuevo para eliminar ceros a la izda
    dia = parseInt(dia, 10);
    dia = dia.toString();
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


function formatearFechaISO(fecha) {
  let dia = fecha.getDate().toString().padStart(2, '0'); // Asegura dos dígitos para el día
  let mes = (fecha.getMonth() + 1).toString().padStart(2, '0'); // Asegura dos dígitos para el mes, +1 porque getMonth() es base 0
  let año = fecha.getFullYear();
  return `${año}-${mes}-${dia}`; // Formato YYYY-MM-DD
}

function dibujarCalendario(mes, año) {
  const diasEnMes = new Date(año, mes + 1, 0).getDate();
  let primerDia = new Date(año, mes, 1).getDay();
  primerDia = primerDia === 0 ? 6 : primerDia - 1; // Ajusta para que la semana comience en lunes
  const ultimoDiaMesAnterior = new Date(año, mes, 0).getDate();

  const contenedorCalendario = document.querySelector('.container_cal');
  contenedorCalendario.innerHTML = ''; // Limpia el calendario

  // Agrega los días de la semana al principio
  const diasSemana = ['L', 'M', 'X', 'J', 'V', 'S', 'D'];
  diasSemana.forEach(dia => {
    contenedorCalendario.innerHTML += `<div class="celda dias_semana">${dia}</div>`;
  });

  // Añade los días del mes anterior para completar la primera semana
  for (let i = 0; i < primerDia; i++) {
    let fecha = new Date(año, mes, -primerDia + i + 1); // Calcula la fecha correcta
    let fechaFormateada = formatearFechaISO(fecha);
    contenedorCalendario.innerHTML += `<div class="celda pasado_futuro" data-fecha="${fechaFormateada}"><span class="num_dia">${ultimoDiaMesAnterior - primerDia + i + 1}</span></div>`;
  }

  // Añade los días del mes actual
  for (let dia = 1; dia <= diasEnMes; dia++) {
    let fecha = new Date(año, mes, dia); // Fecha actual
    let fechaFormateada = formatearFechaISO(fecha);
    contenedorCalendario.innerHTML += `<div class="celda" data-fecha="${fechaFormateada}"><span class="num_dia">${dia}</span></div>`;
  }

  // Completa la última semana con días del siguiente mes si es necesario
  const totalCeldas = 42; // Total de celdas en el calendario (6 semanas * 7 días)
  const celdasActuales = primerDia + diasEnMes;
  for (let dia = 1; celdasActuales + dia <= totalCeldas; dia++) {
    let fecha = new Date(año, mes + 1, dia); // Calcula la fecha del siguiente mes
    let fechaFormateada = formatearFechaISO(fecha);
    contenedorCalendario.innerHTML += `<div class="celda pasado_futuro" data-fecha="${fechaFormateada}"><span class="num_dia">${dia}</span></div>`;
  }
}

