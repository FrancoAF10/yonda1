<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <style>


body { 
    font-family: Helvetica, Arial, sans-serif; 
    font-size: 12px; 
    margin: 25px; 
    color: #2c3e50; 
    background-color: #fff; 
    line-height: 1.6; 
}

/* CABECERA */

.cabecera h1 {
    margin: 0;
    font-size: 20px;
    font-weight: bold;
    letter-spacing: 1px;
}

/* TÍTULOS DE SECCIÓN */
h2 { 
    font-size: 13px; 
    font-weight: bold; 
    margin: 18px 0 10px; 
    color: #ff5f00; 
    border-left: 5px solid #ff5f00;
    padding-left: 8px;
}

/* TABLAS */
table { 
    border-collapse: collapse; 
    width: 100%; 
    margin-bottom: 18px; 
    border: 1px solid #ddd; 
    border-radius: 6px;
    overflow: hidden;
}
th, td { 
    padding: 9px 11px; 
    text-align: left; 
    vertical-align: top; 
    font-size: 11px;
    border: 1px solid #ddd;
}
th { 
    background-color: #fff2ec;  
    color: #ff5f00; 
    font-weight: bold; 
    width: 35%; 
}
td { 
    background-color: #fff;  
}
tr:nth-child(even) td { 
    background-color: #f9f9f9;  
}

/* TABLA DE SUELDO DESTACADA */
.remuneracion th {
    background-color: #ffeadd;
    color: #ff5f00;
    border-color: #ff5f00;
}
.remuneracion td {
    background-color: #fff9f6;
    font-weight: bold;
    color: #ff5f00;
    border-color: #ff5f00;
}

/* PIE Y FIRMA */
.footer { 
    text-align: right; 
    margin-top: 25px; 
    font-size: 10px; 
    color: #555; 
    border-top: 1px solid #ccc;
    padding-top: 6px;
}
.firma { 
    text-align: center; 
    margin-top: 30px; 
    font-size: 11px; 
    color: #ff5f00;
    padding-top: 15px;
    border-top: 2px solid #ff5f00;
}
.firma::after {
    content: " ___________________________   Fecha: _______________";
    display: block;
    margin-top: 10px;
    font-weight: bold;
    color: #ff5f00;
}




    body {
      font-family: 'Montserrat', Arial, sans-serif;
      font-size: 12px;
      color: #2c3e50;
      margin: 0;
      padding: 0;
      background: #fff;
    }

    .pagina {
      width: 21cm;
      height: 29.7cm;
      margin: auto;
      padding: 2cm 2.5cm;
      position: relative;
      box-sizing: border-box;
    }

    /* Cabecera */
    .cabecera {
      display: flex;
      align-items: center;
      margin-bottom: 40px;
    }
    .cabecera img {
      height: 35px;
      margin-right: 10px;
    }
    .linea-naranja {
      flex: 1;
      height: 2px;
      background-color: #ff5f00;
    }

    /* Contenido central */
    .contenido {
      min-height: 70%;
      margin-bottom: 80px;
    }

    /* Pie de página */
    .pie {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      font-size: 10px;
      text-align: right;
      padding: 5px 20px;
      box-sizing: border-box;
    }
    .pie::before {
      content: "";
      display: block;
      height: 6px;
      background-color: #ff5f00;
      margin-bottom: 5px;
    }
  </style>
</head>
<body>
  <div class="pagina">
    <!-- CABECERA -->
    <div class="cabecera">
      <img src="assets/images/LogoYondaPeru.jpg" alt="Yonda">
      <div class="linea-naranja"></div>
    </div>

    <!-- CONTENIDO -->
    <div class="contenido">
    <h2>1. DATOS PERSONALES</h2><div>
        <table>
            <tr><th>Nombres:</th><td><?= $personas['nombres'] ?></td></tr>
            <tr><th>Apellidos:</th><td><?= $personas['apepaterno'] ?> <?= $personas['apematerno'] ?></td></tr>
            <tr><th>Fecha de Nacimiento:</th><td><?= $personas['fechanac'] ?></td></tr>
            <tr><th>Teléfono:</th><td>+51 <?= $personas['telefono'] ?></td></tr>
            <tr><th>Correo Electrónico:</th><td><?= $personas['email'] ?></td></tr>
        </table>
    </div>

    <h2>2. UBICACIÓN</h2>
    <table>
        <tr><th>Ubicación:</th><td><?= $personas['referencia'] ?></td></tr>
        <tr><th>Departamento:</th><td><?= $personas['DepartamentoP'] ?></td></tr>
        <tr><th>Provincia:</th><td><?= $personas['ProvinciaP'] ?></td></tr>
        <tr><th>Distrito:</th><td><?= $personas['DistritoP'] ?></td></tr>
    </table>

    <h2>3. ÁREA Y CARGO</h2>
    <table>
        <tr><th>Área:</th><td><?= $personas['area'] ?></td></tr>
        <tr><th>Cargo:</th><td><?= $personas['cargo'] ?></td></tr>
    </table>

    <h2>4. DETALLES DEL CONTRATO</h2>
    <table>
        <tr><th>Inicio de Contrato:</th><td><?= $personas['fechainicio'] ?></td></tr>
        <tr><th>Fin de Contrato:</th><td><?= $personas['fechafin'] ?></td></tr>
        <tr><th>Tipo de Contrato:</th><td>NULL</td></tr>
    </table>

    <h2>5. REMUNERACIÓN</h2>
    <table>
        <tr><th>Sueldo Asignado:</th><td>S/ <?= $personas['sueldobase'] ?> (Soles peruanos)</td></tr>
    </table>    

</div>
    <!-- PIE -->
    <div class="pie">
      <p><strong>CONTACTO</strong><br>
      +51 987 654 300<br>
      yonda_comunicacion@gmail.com</p>
    </div>

  </div>
</body>
</html>
