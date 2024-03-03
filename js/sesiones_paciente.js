document.addEventListener('DOMContentLoaded', function () {
  // Configuración inicial para mostrar el calendario del mes actual y cargar las citas
  let fechaActual = new Date();
  let mesMostrado = fechaActual.getMonth();
  let anoMostrado = fechaActual.getFullYear();
  dibujarCalendario(mesMostrado, anoMostrado);
  cargarCitas(mesMostrado, anoMostrado);
  cargarLista(mesMostrado, anoMostrado);

  if (document.getElementById('icono_editar')) {
    document.getElementById('icono_editar').addEventListener('click', function () {
      window.location.href = 'editar_sesiones.php';
    });
  }
  document.getElementById('mesAnterior').addEventListener('click', function () {
    if (mesMostrado === 0) {
      mesMostrado = 11;
      anoMostrado -= 1;
    } else {
      mesMostrado -= 1;
    }
    dibujarCalendario(mesMostrado, anoMostrado);
    cargarCitas(mesMostrado, anoMostrado);
  });

  document.getElementById('mesSiguiente').addEventListener('click', function () {
    if (mesMostrado === 11) {
      mesMostrado = 0;
      anoMostrado += 1;
    } else {
      mesMostrado += 1;
    }
    dibujarCalendario(mesMostrado, anoMostrado);
    cargarCitas(mesMostrado, anoMostrado);
  });

  document.querySelector('#calendario').addEventListener('click', function (event) {
    // Verifica si el elemento clickeado (event.target) coincide con lo que buscas
    if (event.target.classList.contains('etiqueta_cita')) {
      window.location.href = 'videollamada_paciente.php';
    }
  });
  document.querySelector('#list_sesiones').addEventListener('click', function (event) {
    // Verifica si el elemento clickeado (event.target) coincide con lo que buscas
    if (event.target.classList.contains('fecha_lista') || event.target.classList.contains('info_lista')) {
      window.location.href = 'videollamada_paciente.php';
    }
  });
  document.querySelector('#icono_chat').addEventListener('click', function () {
    if (this.dataset.tipo == "paciente") {
      window.location.href = 'chat_paciente.php'
    } else {
      window.location.href = 'users.php'
    }
  })
});



function cargarCitas(mes, ano) {
  // Encuentra el primer y último día del mes
  let primerDiaMes = new Date(ano, mes, 1);
  let ultimoDiaMes = new Date(ano, mes + 1, 0);

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



function pintarCitas(citas) {
  citas.forEach(cita => {
    // Extrae la fecha, hora y nombre del psicólogo de cada cita
    const { fecha, hora, nombre_psicologo } = cita;

    // Encuentra la celda del calendario que corresponde a la fecha de la cita
    const celda = document.querySelector(`.celda[data-fecha="${fecha}"]`);

    if (celda) {
      // Formatea el detalle de la cita
      const detalleCita = `<div class='etiqueta_cita'>${hora}-${nombre_psicologo}</div>`;

      // Inserta el detalle de la cita en la celda correspondiente
      celda.insertAdjacentHTML('beforeend', detalleCita);
    }
  });
}



function formatearFechaISO(fecha) {
  let dia = fecha.getDate().toString().padStart(2, '0'); // Asegura dos dígitos para el día
  let mes = (fecha.getMonth() + 1).toString().padStart(2, '0'); // Asegura dos dígitos para el mes, +1 porque getMonth() es base 0
  let ano = fecha.getFullYear();
  return `${ano}-${mes}-${dia}`; // Formato YYYY-MM-DD
}

function dibujarCalendario(mes, ano) {
  pintarTituloCal(mes, ano);
  const diasEnMes = new Date(ano, mes + 1, 0).getDate();
  let primerDia = new Date(ano, mes, 1).getDay();
  primerDia = primerDia === 0 ? 6 : primerDia - 1; // Ajusta para que la semana comience en lunes
  const ultimoDiaMesAnterior = new Date(ano, mes, 0).getDate();

  const contenedorCalendario = document.querySelector('#calendario');
  contenedorCalendario.innerHTML = ''; // Limpia el calendario

  // Agrega los días de la semana al principio
  const diasSemana = ['L', 'M', 'X', 'J', 'V', 'S', 'D'];
  diasSemana.forEach(dia => {
    contenedorCalendario.innerHTML += `<div class="celda dias_semana">${dia}</div>`;
  });

  // Añade los días del mes anterior para completar la primera semana
  for (let i = 0; i < primerDia; i++) {
    let fecha = new Date(ano, mes, -primerDia + i + 1); // Calcula la fecha correcta
    let fechaFormateada = formatearFechaISO(fecha);
    contenedorCalendario.innerHTML += `<div class="celda pasado" data-fecha="${fechaFormateada}"><span class="num_dia">${ultimoDiaMesAnterior - primerDia + i + 1}</span></div>`;
  }

  // Añade los días del mes actual
  for (let dia = 1; dia <= diasEnMes; dia++) {
    let fecha = new Date(ano, mes, dia); // Fecha actual
    let fechaFormateada = formatearFechaISO(fecha);
    contenedorCalendario.innerHTML += `<div class="celda" data-fecha="${fechaFormateada}"><span class="num_dia">${dia}</span></div>`;
  }

  // Completa la última semana con días del siguiente mes si es necesario
  const totalCeldas = 42; // Total de celdas en el calendario (6 semanas * 7 días)
  const celdasActuales = primerDia + diasEnMes;
  for (let dia = 1; celdasActuales + dia <= totalCeldas; dia++) {
    let fecha = new Date(ano, mes + 1, dia); // Calcula la fecha del siguiente mes
    let fechaFormateada = formatearFechaISO(fecha);
    contenedorCalendario.innerHTML += `<div class="celda futuro" data-fecha="${fechaFormateada}"><span class="num_dia">${dia}</span></div>`;
  }

  let hoy = new Date();
  if (mes == hoy.getMonth()) {
    document.querySelector(`.celda[data-fecha = "${formatearFechaISO(hoy)}"] > span.num_dia`).classList.add("dia_actual");
  }

}

function cargarLista(mes, ano) {
  // Fecha de inicio: día actual
  let fechaInicio = new Date();
  let fechaInicioFormateada = formatearFechaISO(fechaInicio);

  // Fecha de fin: último día del mes siguiente
  // Si mes == 11 (diciembre), el mes siguiente sería enero del próximo ano
  let anoFin = mes === 11 ? ano + 1 : ano;
  let mesFin = mes === 11 ? 0 : mes + 1;
  let fechaFin = new Date(anoFin, mesFin + 1, 0);
  let fechaFinFormateada = formatearFechaISO(fechaFin);

  // Continúa con la petición como antes, usando fechaInicioFormateada y fechaFinFormateada
  const datos = new FormData();
  datos.append('fechaInicio', fechaInicioFormateada);
  datos.append('fechaFin', fechaFinFormateada);

  fetch("./php/procesar_sesiones.php", {
    method: "POST",
    body: datos,
  })
    .then(response => response.json())
    .then(data => {
      if (data.success && data.citas.length > 0) {
        pintarLista(data.citas);
      } else {
        console.log('No hay sesiones programadas o hubo un error en la petición');
      }
    })
    .catch(error => {
      console.error('Error al cargar las sesiones:', error);
    });
}

function pintarLista(citas) {
  const lista = document.getElementById('list_sesiones');
  lista.innerHTML = ''; // Limpia la lista actual para evitar duplicados

  citas.forEach(sesion => {
    const { fecha, hora, nombre_psicologo, apellidos_psicologo } = sesion; // Asume que cada sesión tiene esta información
    const elementoLista = document.createElement('li');
    elementoLista.innerHTML = `
    <span class='fecha_lista'>
    ${fecha}
    </span>
    <span class='info_lista'>
    ${hora} - Sesión con ${nombre_psicologo} ${apellidos_psicologo}
    </span>
    `;
    lista.appendChild(elementoLista);
  });
}

function pintarTituloCal(mes, ano) {
  const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
  document.querySelector("#titulo_cal").textContent = meses[mes] + " " + ano;
}