<?php
while ($row = mysqli_fetch_assoc($sql)) {
   // $sql3 = "SELECT p.*
   //          FROM paciente p
   //          JOIN usuario u ON p.id_paciente = u.id_original
   //          WHERE u.id_usuario = {$row['id_usuario']};";
   // $query3 = mysqli_query($conn, $sql3);
   // $row3 = mysqli_fetch_assoc($query3);
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
   //trimming message if word are more than 28
   (strlen($result) > 28) ? $msg = substr($result, 0, 28) . "..." : $msg = $result;
   // adding you: text before msg if login id send msg
   //check ouser is online or offline
   // ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
   $output .= '<a href="chat.php?id_usuario=' . $row['id_paciente'] . '">
                  <div class="content">
                     
                     <div class="details">
                        <span>' . $row['nombre_paciente'] . " " . $row['apellidos_paciente'] . '</span>
                        <p>' . $you . $msg . '</p>
                     </div>
                  </div>
                  
               </a>';
}
