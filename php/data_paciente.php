<?php
while ($row = mysqli_fetch_assoc($sql)) {
   $sql2 = "SELECT * FROM mensajes WHERE (msg_entrada_id = {$row['id_paciente']}
            OR msg_salida_id = {$row['id_paciente']}) AND (msg_salida_id = {$outgoing_id}
            OR msg_entrada_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
   $query2 = mysqli_query($conn, $sql2);
   $row2 = mysqli_fetch_assoc($query2);
   $you = "";
   if (mysqli_num_rows($query2) > 0) {
      $result = $row2['msg'];
      ($outgoing_id == $row2['msg_salida_id']) ? $you = "Tú: " : $you = "";
   } else {
      $result = "No hay mensajes disponibles";
   }
   //cortamos el mensaje en caso de que sea demasiado largo
   (strlen($result) > 28) ? $msg = substr($result, 0, 28) . "..." : $msg = $result;
   $output .= '<a href="chat.php?id_usuario=' . $row['id_paciente'] . '">
                  <div class="content">
                     <img src="' . $row['foto_paciente'] . '" alt="" />
                     <div class="details">
                        <span>' . $row['nombre_paciente'] . " " . $row['apellidos_paciente'] . '</span>
                        <p>' . $you . $msg . '</p>
                     </div>
                  </div>
               </a>';
}
