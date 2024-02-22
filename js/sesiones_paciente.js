// Petición al servidor que devuelva un json los los datos de las citas de este mes
fetch("./php/procesar_sesiones.php", {
  method: "GET",
})
  .then(response => {
    // Verificamos si la respuesta fue exitosa
    if (!response.ok) {
      throw new Error('Ocurrió un error al realizar la solicitud.');
    }
    // Convertimos la respuesta a formato JSON
    return response.json();
  })
  .then(data => {
    // Hacemos algo con los datos obtenidos
    console.log('Datos obtenidos:', data);
    pintarCitas(data.citas);
  })
  .catch(error => {
    // Capturamos y manejamos cualquier error que pueda ocurrir
    console.error('Error:', error);
  });

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
