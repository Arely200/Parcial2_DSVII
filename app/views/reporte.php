<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iTECH 2025 - Reporte de Inscriptores</title>
    <base href="/Parcial2_DSVII/public/">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f0f2f5;
            padding: 40px 24px;
            color: #111827;
        }
        
        .container {
            max-width: 1300px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 24px;
            padding: 40px 48px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.06);
        }
        
        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            padding-bottom: 24px;
            border-bottom: 2px solid #f0f2f5;
            margin-bottom: 28px;
        }
        
        .header-left h1 {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .header-left h1 span {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .header-left p {
            color: #6b7280;
            font-size: 14px;
            margin-top: 2px;
        }
        
        .header-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .btn i { font-size: 16px; }
        
        .btn-excel {
            background: #16a34a;
            color: white;
        }
        .btn-excel:hover {
            background: #15803d;
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(22, 163, 74, 0.3);
        }
        
        .btn-volver {
            background: #2563eb;
            color: white;
        }
        .btn-volver:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.3);
        }
        
        /* ESTADÍSTICAS */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }
        
        .stat-card {
            background: #f8fafc;
            padding: 16px 20px;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
        }
        
        .stat-card .stat-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
        }
        
        .stat-card .stat-value {
            font-size: 22px;
            font-weight: 700;
            color: #111827;
            margin-top: 2px;
        }
        
        .stat-card .stat-value.green { color: #16a34a; }
        .stat-card .stat-value.red { color: #dc2626; }
        .stat-card .stat-value.blue { color: #2563eb; }
        
        /* TABLA */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        
        thead {
            background: #f8fafc;
        }
        
        thead th {
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }
        
        tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid #f0f2f5;
            color: #374151;
            vertical-align: middle;
        }
        
        tbody tr:hover {
            background: #fafbfc;
        }
        
        tbody tr:last-child td {
            border-bottom: none;
        }
        
        /* INTEGRIDAD */
        .integro {
            background: #f0fdf4 !important;
        }
        
        .corrompido {
            background: #fef2f2 !important;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }
        
        .badge-success {
            background: #dcfce7;
            color: #166534;
        }
        
        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }
        
        /* VACÍO */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state i {
            font-size: 48px;
            color: #d1d5db;
            margin-bottom: 16px;
        }
        
        .empty-state h3 {
            font-size: 20px;
            color: #374151;
            font-weight: 600;
        }
        
        .empty-state p {
            color: #6b7280;
            font-size: 16px;
            margin-top: 4px;
        }
        
        /* FOOTER */
        .footer {
            text-align: center;
            padding-top: 28px;
            margin-top: 32px;
            border-top: 2px solid #f0f2f5;
        }
        
        .footer p {
            color: #6b7280;
            font-size: 14px;
        }
        
        .footer p i {
            color: #ef4444;
        }
        
        .footer .social {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            gap: 16px;
        }
        
        .footer .social a {
            color: #9ca3af;
            font-size: 18px;
            transition: color 0.2s ease;
        }
        
        .footer .social a:hover {
            color: #2563eb;
        }
        
        /* RESPONSIVE */
        @media (max-width: 768px) {
            .container { padding: 24px 16px; }
            .header { flex-direction: column; align-items: stretch; }
            .header-actions { justify-content: stretch; }
            .header-actions .btn { justify-content: center; }
            .stats { grid-template-columns: 1fr 1fr; }
            thead th, tbody td { padding: 8px 10px; font-size: 12px; }
        }
        
        @media (max-width: 480px) {
            .stats { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <div class="header-left">
                <h1>Reporte de <span>Inscriptores</span></h1>
                <p>Congreso iTECH 2025 · Lista de participantes</p>
            </div>
            <div class="header-actions">
                <a href="/Parcial2_DSVII/public/exportar-excel" class="btn btn-excel">
                    <i class="fas fa-file-excel"></i> Exportar Excel
                </a>
                <a href="/Parcial2_DSVII/public/" class="btn btn-volver">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
        
        <?php if (empty($inscriptores)): ?>
            <!-- ESTADO VACÍO -->
            <div class="empty-state">
                <i class="fas fa-user-plus"></i>
                <h3>No hay inscriptores registrados</h3>
                <p>Comienza registrando participantes desde el formulario.</p>
            </div>
        <?php else: ?>
            
            <!-- ESTADÍSTICAS (usando la verificación REAL con OpenSSL) -->
            <?php 
                $total = count($inscriptores);
                $integridadCompleta = 0;
                foreach ($inscriptores as $row) {
                    if (\App\Utils\Firmador::esIntegro($row)) {
                        $integridadCompleta++;
                    }
                }
                $porcentaje = $total > 0 ? round(($integridadCompleta / $total) * 100) : 0;
            ?>
            
            <div class="stats">
                <div class="stat-card">
                    <div class="stat-label"> Total registros</div>
                    <div class="stat-value"><?= $total ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label"> Integridad completa</div>
                    <div class="stat-value green"><?= $integridadCompleta ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label"> Con alertas</div>
                    <div class="stat-value red"><?= $total - $integridadCompleta ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label"> Porcentaje de integridad</div>
                    <div class="stat-value blue"><?= $porcentaje ?>%</div>
                </div>
            </div>
            
            <!-- TABLA -->
            <div class="table-wrapper">
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
                        foreach ($inscriptores as $row):
                            $contador++;
                            $esIntegro = \App\Utils\Firmador::esIntegro($row);
                            $claseFila = $esIntegro ? 'integro' : 'corrompido';
                            $badge = $esIntegro 
                                ? '<span class="badge badge-success"> Íntegro</span>' 
                                : '<span class="badge badge-danger"> Corrompido</span>';
                        
                            $sexoMostrar = '-';
                            if (($row['sexo'] ?? '') === 'Masculino') $sexoMostrar = 'Masculino';
                            elseif (($row['sexo'] ?? '') === 'Femenino') $sexoMostrar = 'Femenino';
                            elseif (($row['sexo'] ?? '') === 'Otro') $sexoMostrar = 'Otro';
                        ?>
                            <tr class="<?= $claseFila ?>">
                                <td><?= $contador ?></td>
                                <td><?= $row['identidad'] ?? '-' ?></td>
                                <td><strong><?= $row['nombre'] ?? '-' ?></strong></td>
                                <td><?= $row['apellido'] ?? '-' ?></td>
                                <td><?= $row['edad'] ?? '-' ?></td>
                                <td><?= $sexoMostrar ?></td>
                                <td><?= $row['pais_nombre'] ?? '-' ?></td>
                                <td><?= $row['nacionalidad'] ?? '-' ?></td>
                                <td><?= $row['correo'] ?? '-' ?></td>
                                <td><?= $row['celular'] ?? '-' ?></td>
                                <td><span style="font-size: 12px;"><?= $row['temas'] ?? '-' ?></span></td>
                                <td style="font-size: 12px;"><?= $row['fecha_registro'] ?? '-' ?></td>
                                <td><?= $badge ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
        <?php endif; ?>
        
        <!-- FOOTER -->
        <div class="footer">
            <p>
                <i class="fas fa-copyright"></i> <?= date('Y') ?> iTECH. Todos los derechos reservados.
                &nbsp;|&nbsp; <i class="fas fa-envelope"></i> info@itech.com
                &nbsp;|&nbsp; <i class="fas fa-phone"></i> +507 1234-5678
            </p>
            <p style="font-size: 12px; color: #9ca3af; margin-top: 4px;">
                Reporte generado el <?= date('d/m/Y \a \l\a\s H:i:s') ?>
            </p>
            <div class="social">
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
</body>
</html>