<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iTECH 2025 - Inscripción</title>
    <base href="/Parcial2_DSVII/public/">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* ===== RESET Y BASE ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }
        
        /* ===== CONTENEDOR PRINCIPAL ===== */
        .container {
            background: #ffffff;
            border-radius: 24px;
            max-width: 900px;
            width: 100%;
            padding: 50px 60px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08), 0 8px 24px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }
        
        /* ===== HEADER ===== */
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 2px solid #f0f2f5;
        }
        
        .header .logo {
            display: inline-block;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: white;
            width: 70px;
            height: 70px;
            border-radius: 18px;
            line-height: 70px;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 16px;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.25);
        }
        
        .header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.5px;
        }
        
        .header h1 span {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .header p {
            color: #6b7280;
            font-size: 16px;
            font-weight: 400;
            margin-top: 6px;
        }
        
        /* ===== FORMULARIO ===== */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px 28px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        
        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .form-group label .required {
            color: #ef4444;
            font-weight: 700;
        }
        
        .form-group label .hint {
            font-weight: 400;
            color: #9ca3af;
            font-size: 11px;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            font-family: 'Inter', sans-serif;
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            color: #111827;
            background: #fafbfc;
            transition: all 0.2s ease;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #2563eb;
            background: #ffffff;
            outline: none;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.08);
        }
        
        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #9ca3af;
        }
        
        .form-group input.error,
        .form-group select.error,
        .form-group textarea.error {
            border-color: #ef4444;
            background: #fef2f2;
        }
        
        .error-text {
            color: #ef4444;
            font-size: 12px;
            font-weight: 500;
            margin-top: 4px;
        }
        
        /* ===== CHECKBOXES ===== */
        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 8px 16px;
            padding: 8px 0;
        }
        
        .checkbox-group label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 400;
            color: #374151;
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 8px;
            transition: all 0.15s ease;
        }
        
        .checkbox-group label:hover {
            background: #f3f4f6;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #2563eb;
            border-radius: 4px;
            cursor: pointer;
            flex-shrink: 0;
        }
        
        /* ===== ALERTAS ===== */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 14px;
        }
        
        .alert i {
            font-size: 18px;
            margin-top: 1px;
            flex-shrink: 0;
        }
        
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        
        .alert-error i { color: #ef4444; }
        
        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
        }
        
        .alert-success i { color: #22c55e; }
        
        .alert ul {
            list-style: none;
            padding: 0;
            margin: 4px 0 0 0;
        }
        
        .alert ul li {
            padding: 2px 0;
        }
        
        /* ===== BOTÓN ===== */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.25);
            margin-top: 8px;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(37, 99, 235, 0.35);
        }
        
        .btn-submit:active {
            transform: translateY(0);
        }
        
        .btn-submit i {
            font-size: 18px;
        }
        
        /* ===== FOOTER ===== */
        .footer {
            text-align: center;
            padding-top: 28px;
            margin-top: 32px;
            border-top: 2px solid #f0f2f5;
        }
        
        .footer p {
            color: #6b7280;
            font-size: 14px;
            font-weight: 400;
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
        
        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .container { padding: 30px 24px; }
            .form-grid { grid-template-columns: 1fr; gap: 16px; }
            .header h1 { font-size: 22px; }
            .checkbox-group { grid-template-columns: 1fr 1fr; }
        }
        
        @media (max-width: 480px) {
            .container { padding: 20px 16px; }
            .checkbox-group { grid-template-columns: 1fr; }
            .header .logo { width: 56px; height: 56px; line-height: 56px; font-size: 24px; }
        }
    </style>
</head>
<body>
    <?php
    // Cargar datos automáticamente
    if (!isset($temas) || !is_array($temas) || empty($temas)) {
        try {
            $pdo = new PDO('mysql:host=127.0.0.1;dbname=parcial_itech;charset=utf8', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $temas = $pdo->query("SELECT id, nombre FROM areas_interes ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $temas = [];
        }
    }
    
    if (!isset($paises) || !is_array($paises) || empty($paises)) {
        try {
            $pdo = new PDO('mysql:host=127.0.0.1;dbname=parcial_itech;charset=utf8', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $paises = $pdo->query("SELECT id, nombre FROM paises ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $paises = [];
        }
    }
    ?>
    
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <div class="logo">iT</div>
            <h1>iTECH <span>2025</span></h1>
            <p>Formulario de inscripción al Congreso de Tecnología</p>
        </div>
        
        <!-- ALERTAS -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <i class="fas fa-circle-exclamation"></i>
                <div>
                    <strong>Por favor, corrige los siguientes errores:</strong>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li>• <?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- FORMULARIO -->
        <form action="/Parcial2_DSVII/public/guardar" method="POST">
            <div class="form-grid">
                <!-- Identidad -->
                <div class="form-group">
                    <label>Identidad <span class="required">*</span></label>
                    <input type="text" name="identidad" placeholder="Ej: 1234-5678" 
                           value="<?= $_POST['identidad'] ?? '' ?>" 
                           class="<?= isset($errors['identidad']) ? 'error' : '' ?>">
                    <?php if (isset($errors['identidad'])): ?>
                        <div class="error-text"><?= $errors['identidad'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Nombre -->
                <div class="form-group">
                    <label>Nombre <span class="required">*</span></label>
                    <input type="text" name="nombre" placeholder="Tu nombre"
                           value="<?= $_POST['nombre'] ?? '' ?>"
                           class="<?= isset($errors['nombre']) ? 'error' : '' ?>">
                    <?php if (isset($errors['nombre'])): ?>
                        <div class="error-text"><?= $errors['nombre'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Apellido -->
                <div class="form-group">
                    <label>Apellido <span class="required">*</span></label>
                    <input type="text" name="apellido" placeholder="Tu apellido"
                           value="<?= $_POST['apellido'] ?? '' ?>"
                           class="<?= isset($errors['apellido']) ? 'error' : '' ?>">
                    <?php if (isset($errors['apellido'])): ?>
                        <div class="error-text"><?= $errors['apellido'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Edad -->
                <div class="form-group">
                    <label>Edad <span class="required">*</span></label>
                    <input type="number" name="edad" placeholder="18 - 120"
                           value="<?= $_POST['edad'] ?? '' ?>"
                           class="<?= isset($errors['edad']) ? 'error' : '' ?>">
                    <?php if (isset($errors['edad'])): ?>
                        <div class="error-text"><?= $errors['edad'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Sexo -->
                <div class="form-group">
                    <label>Sexo <span class="required">*</span></label>
                    <select name="sexo" class="<?= isset($errors['sexo']) ? 'error' : '' ?>">
                        <option value="">Selecciona</option>
                        <option value="Masculino" <?= ($_POST['sexo'] ?? '') === 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                        <option value="Femenino" <?= ($_POST['sexo'] ?? '') === 'Femenino' ? 'selected' : '' ?>>Femenino</option>
                        <option value="Otro" <?= ($_POST['sexo'] ?? '') === 'Otro' ? 'selected' : '' ?>>Otro</option>
                    </select>
                    <?php if (isset($errors['sexo'])): ?>
                        <div class="error-text"><?= $errors['sexo'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- País -->
                <div class="form-group">
                    <label>País de Residencia <span class="required">*</span></label>
                    <select name="pais_id" class="<?= isset($errors['pais_id']) ? 'error' : '' ?>">
                        <option value="">Selecciona</option>
                        <?php if (isset($paises) && is_array($paises) && count($paises) > 0): ?>
                            <?php foreach ($paises as $pais): ?>
                                <option value="<?= $pais['id'] ?>" 
                                    <?= ($_POST['pais_id'] ?? '') == $pais['id'] ? 'selected' : '' ?>>
                                    <?= $pais['nombre'] ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <?php if (isset($errors['pais_id'])): ?>
                        <div class="error-text"><?= $errors['pais_id'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Nacionalidad -->
                <div class="form-group full-width">
                    <label>Nacionalidad <span class="required">*</span></label>
                    <input type="text" name="nacionalidad" placeholder="Ej: Panameña, Colombiana, Mexicana..."
                           value="<?= $_POST['nacionalidad'] ?? '' ?>">
                </div>
                
                <!-- Correo -->
                <div class="form-group">
                    <label>Correo Electrónico <span class="required">*</span></label>
                    <input type="email" name="correo" placeholder="correo@ejemplo.com"
                           value="<?= $_POST['correo'] ?? '' ?>"
                           class="<?= isset($errors['correo']) ? 'error' : '' ?>">
                    <?php if (isset($errors['correo'])): ?>
                        <div class="error-text"><?= $errors['correo'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Celular -->
                <div class="form-group">
                    <label>Celular <span class="required">*</span></label>
                    <input type="text" name="celular" placeholder="8 dígitos"
                           value="<?= $_POST['celular'] ?? '' ?>"
                           class="<?= isset($errors['celular']) ? 'error' : '' ?>">
                    <?php if (isset($errors['celular'])): ?>
                        <div class="error-text"><?= $errors['celular'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Temas -->
                <div class="form-group full-width">
                    <label>Temas Tecnológicos de interés <span class="required">*</span></label>
                    <div class="checkbox-group">
                        <?php if (isset($temas) && is_array($temas) && count($temas) > 0): ?>
                            <?php foreach ($temas as $tema): ?>
                                <label>
                                    <input type="checkbox" name="temas[]" value="<?= $tema['id'] ?>"
                                        <?= (isset($_POST['temas']) && in_array($tema['id'], $_POST['temas'])) ? 'checked' : '' ?>>
                                    <?= $tema['nombre'] ?>
                                </label>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="color: #ef4444; font-size: 14px;"> No se cargaron los temas.</p>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($errors['temas'])): ?>
                        <div class="error-text"><?= $errors['temas'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Observaciones -->
                <div class="form-group full-width">
                    <label>Observaciones o Consulta</label>
                    <textarea name="observaciones" rows="3" placeholder="¿Algo más que quieras contarnos?"><?= $_POST['observaciones'] ?? '' ?></textarea>
                </div>
            </div>
            
            <!-- Botón -->
            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i> Enviar inscripción
            </button>
        </form>
        
        <!-- FOOTER -->
        <div class="footer">
            <p>
                <i class="fas fa-copyright"></i> 2025 iTECH. Todos los derechos reservados.
            </p>
            <p style="font-size: 13px; color: #9ca3af; margin-top: 4px;">
                <i class="fas fa-envelope"></i> info@itech.com &nbsp;|&nbsp; 
                <i class="fas fa-phone"></i> +507 1234-5678
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