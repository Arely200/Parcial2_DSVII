<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inscriptores - iTECH 2025</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            padding: 40px 20px;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 10px; }
        .subtitle { text-align: center; color: #7f8c8d; margin-bottom: 30px; }
        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .btn {
            padding: 10px 25px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.2s;
        }
        .btn:hover { transform: scale(1.05); }
        .btn-excel { background: #27ae60; color: white; }
        .btn-volver { background: #3498db; color: white; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }
        th {
            background: #2c3e50;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #ecf0f1;
        }
        tr:hover { background: #f8f9fa; }
        
        .integro { background: #d4edda !important; }
        .integro td:first-child::before { content: "✅ "; font-size: 16px; }
        .corrompido { background: #f8d7da !important; }
        .corrompido td:first-child::before { content: "❌ "; font-size: 16px; }
        
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-verde { background: #28a745; color: white; }
        .badge-rojo { background: #dc3545; color: white; }
        
        footer {
            text-align: center;
            padding: 20px 0 0 0;
            color: #888;
            border-top: 2px solid #eee;
            margin-top: 30px;
        }
        .firma-box {
            margin-top: 20px;
            padding: 15px 20px;
            background: #f8f9fa;
            border-radius: 10px;
            text-align: center;
            font-family: monospace;
            border: 1px dashed #999;
            font-size: 12px;
            word-break: break-all;
        }
        .firma-box strong { color: #2c3e50; }
        .sin-registros { text-align: center; padding: 40px; color: #7f8c8d; font-size: 18px; }
        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .stats .stat {
            background: #f8f9fa;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
        }
        .stats .stat span { font-weight: 700; color: #2c3e50; }
        .firma-textarea {
            width: 100%;
            font-family: monospace;
            font-size: 12px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #fff;
            resize: vertical;
            min-height: 60px;
        }
        @media (max-width: 768px) {
            table { font-size: 12px; }
            th, td { padding: 6px 8px; }
            .container { padding: 15px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 Reporte de Inscriptores</h1>
        <p class="subtitle">Congreso iTECH 2025 - Lista de participantes</p>
        
        <div class="actions">
            <a href="exportar-excel" class="btn btn-excel">📥 Exportar Excel</a>
            <a href="." class="btn btn-volver">← Volver al formulario</a>
        </div>
        
        <?php if (empty($inscriptores)): ?>
            <div class="sin-registros">🗂️ No hay inscriptores registrados aún.</div>
        <?php else: ?>
            
            <?php 
                $total = count($inscriptores);
                $integridadCompleta = 0;
                $camposRequeridos = ['nombre', 'apellido', 'identidad', 'correo', 'celular', 'sexo'];
                foreach ($inscriptores as $row) {
                    $ok = true;
                    foreach ($camposRequeridos as $c) {
                        if (empty($row[$c]) || strlen(trim($row[$c])) < 2) { $ok = false; break; }
                    }
                    if ($ok) $integridadCompleta++;
                }
                $porcentaje = $total > 0 ? round(($integridadCompleta / $total) * 100) : 0;
            ?>
            <div class="stats">
                <div class="stat">📌 Total registros: <span><?= $total ?></span></div>
                <div class="stat">✅ Integridad completa: <span><?= $integridadCompleta ?></span></div>
                <div class="stat">❌ Registros con alertas: <span><?= $total - $integridadCompleta ?></span></div>
                <div class="stat">📊 Porcentaje: <span><?= $porcentaje ?>%</span></div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Identidad</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Edad</th>
                        <th>Sexo</th>
                        <th>País</th>
                        <th>Nacionalidad</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Temas</th>
                        <th>Fecha</th>
                        <th>Integridad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $contador = 0;
                    $nombresCampos = [
                        'nombre' => 'Nombre',
                        'apellido' => 'Apellido',
                        'identidad' => 'Identidad',
                        'correo' => 'Correo',
                        'celular' => 'Celular',
                        'sexo' => 'Sexo'
                    ];
                    foreach ($inscriptores as $row):
                        $contador++;
                        $camposFaltantes = [];
                        $esIntegro = true;
                        foreach ($camposRequeridos as $campo) {
                            if (empty($row[$campo]) || strlen(trim($row[$campo])) < 2) {
                                $esIntegro = false;
                                $camposFaltantes[] = $nombresCampos[$campo];
                            }
                        }
                        $claseFila = $esIntegro ? 'integro' : 'corrompido';
                        $badge = $esIntegro 
                            ? '<span class="badge badge-verde">✅ Íntegro</span>' 
                            : '<span class="badge badge-rojo">⚠️ ' . implode(', ', $camposFaltantes) . '</span>';
                        
                        $sexoMostrar = '-';
                        if (($row['sexo'] ?? '') === 'Masculino') $sexoMostrar = '♂ Masculino';
                        elseif (($row['sexo'] ?? '') === 'Femenino') $sexoMostrar = '♀ Femenino';
                        elseif (($row['sexo'] ?? '') === 'Otro') $sexoMostrar = '⚧ Otro';
                    ?>
                        <tr class="<?= $claseFila ?>">
                            <td><?= $contador ?></td>
                            <td><?= $row['identidad'] ?? '-' ?></td>
                            <td><?= $row['nombre'] ?? '-' ?></td>
                            <td><?= $row['apellido'] ?? '-' ?></td>
                            <td><?= $row['edad'] ?? '-' ?></td>
                            <td><?= $sexoMostrar ?></td>
                            <td><?= $row['pais_nombre'] ?? '-' ?></td>
                            <td><?= $row['nacionalidad'] ?? '-' ?></td>
                            <td><?= $row['correo'] ?? '-' ?></td>
                            <td><?= $row['celular'] ?? '-' ?></td>
                            <td><?= $row['temas'] ?? '-' ?></td>
                            <td><?= $row['fecha_registro'] ?? '-' ?></td>
                            <td><?= $badge ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <?php 
            $controller = new App\Controllers\InscriptorController();
            $firmaResult = $controller->firmarReporte($inscriptores);
            ?>
            
            <div class="firma-box">
                <strong>🔐 Firma Digital (OpenSSL SHA-256)</strong><br><br>
                
                <?php if ($firmaResult['success']): ?>
                    <strong style="color: #28a745;">✅ Firma generada correctamente</strong><br>
                    <strong>Hash SHA-256:</strong> <?= $firmaResult['hash'] ?><br>
                    <strong>Fecha de firma:</strong> <?= $firmaResult['fecha'] ?><br>
                    <strong>Firma (Base64):</strong><br>
                    <textarea class="firma-textarea" rows="4" readonly><?= $firmaResult['firma'] ?></textarea>
                    <br>
                    <span style="color: <?= $firmaResult['verificada'] ? '#28a745' : '#dc3545' ?>; font-weight: bold; font-size: 14px;">
                        <?= $firmaResult['verificada'] ? '✅ Firma verificada correctamente' : '❌ La firma NO coincide' ?>
                    </span>
                <?php else: ?>
                    <strong style="color: #dc3545;">⚠️ <?= $firmaResult['error'] ?></strong><br>
                    <p style="font-family: sans-serif; font-size:14px; color: #666;">
                        Para generar las claves, ejecuta en la terminal:<br>
                        <code style="background:#eee; padding:5px 10px; border-radius:5px; display:inline-block; margin:5px 0;">php generar_claves.php</code>
                    </p>
                <?php endif; ?>
            </div>
            
        <?php endif; ?>
        
        <footer>
            <p>© 2025 iTECH. All rights reserved. | Reporte generado el <?= date('d/m/Y H:i:s') ?></p>
        </footer>
    </div>
</body>
</html>