<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }
        h1 {
            font-size: 16px;
            margin-bottom: 5px;
        }
        h2 {
            font-size: 14px;
            margin-bottom: 10px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 6px 10px;
            border: 1px solid #ccc;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: left;
        }
        .resaltado {
            font-weight: bold;
            color: #ff5f00; /* color de la empresa */
        }
        .detalle {
            margin: 15px 0;
            padding: 10px;
            border: 1px solid #888;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <h1>Planilla Mensual — Septiembre 2025</h1>
    <h2>Registro de remuneración y descuentos por trabajador</h2>

    <div class="detalle">
        <p><span class="resaltado">Empresa</span><br>
        RUC: 12345678901 <br>
        Razón social: Empresa Ejemplo S.A.C.<br>
        Periodo: Septiembre 2025</p>

        <p><span class="resaltado">Trabajador</span><br>
        Código: EMP-001 <br>
        Apellidos y Nombres: Pérez López, Juan <br>
        DNI: 12345678 <br>
        Área / Cargo: Sistemas / Desarrollador</p>

        <p><span class="resaltado">Contrato</span><br>
        Tipo: Indefinido <br>
        Fecha de ingreso: 2022-03-15 <br>
        Remuneración mensual: S/ 3,200.00</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Concepto</th>
                <th>Detalle</th>
                <th>Monto (S/)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><b>Remuneración básica</b></td>
                <td>Sueldo mensual acordado</td>
                <td>3,200.00</td>
            </tr>
            <tr>
                <td><b>Asignación familiar</b></td>
                <td>Si aplica</td>
                <td>0.00</td>
            </tr>
            <tr>
                <td><b>Bonificaciones / Horas extra</b></td>
                <td>Bonos y extras del periodo</td>
                <td>250.00</td>
            </tr>
            <tr>
                <td><b>Descuento AFP/ONP</b></td>
                <td>Aporte previsional (ej. AFP)</td>
                <td>320.00</td>
            </tr>
            <tr>
                <td><b>Retención 5ta categoría</b></td>
                <td>Impuesto a la renta</td>
                <td>80.00</td>
            </tr>
            <tr>
                <td><b>Préstamos / Anticipos</b></td>
                <td>Descuento por préstamo</td>
                <td>150.00</td>
            </tr>
            <tr>
                <td><b>Aportes empresa (ESSALUD / Seguro)</b></td>
                <td>Contribuciones patronales</td>
                <td>200.00</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
