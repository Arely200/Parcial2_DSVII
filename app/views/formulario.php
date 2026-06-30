<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción iTECH 2025</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 { text-align: center; color: #333; margin-bottom: 10px; font-size: 2em; }
        .subtitle { text-align: center; color: #666; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: 600; color: #444; margin-bottom: 5px; }
        label .required { color: #e74c3c; }
        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }
        input.error, select.error, textarea.error { border-color: #e74c3c; }
        .error-text { color: #e74c3c; font-size: 14px; margin-top: 5px; }
        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 10px;
            padding: 10px 0;
        }
        .checkbox-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: normal;
            cursor: pointer;
        }
        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: #667eea;
        }
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .btn-submit:hover { transform: scale(1.02); }
        footer {
            text-align: center;
            padding: 20px 0 0 0;
            color: #888;
            border-top: 2px solid #eee;
            margin-top: 30px;
        }
        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        @media (max-width: 600px) {
            .row { grid-template-columns: 1fr; }
            .container { padding: 20px; }
        }
        /* Mensajes de éxito/error */
        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <?php
    // ============================================================
    // SI NO HAY TEMAS O PAÍSES, CARGARLOS AUTOMÁTICAMENTE
    // ============================================================
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
    
    // Verificar si hay mensaje de éxito
    $mensaje = $_GET['mensaje'] ?? '';
    ?>
    
    <div class="container">
        <h1>🚀 iTECH 2025</h1>
        <p class="subtitle">Formulario de Inscripción - Congreso de Tecnología</p>
        
        <?php if ($mensaje === 'exito'): ?>
            <div class="alert-success">
                ✅ ¡Inscripción exitosa! Gracias por registrarte.
            </div>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
            <div class="alert-error">
                <strong>❌ Errores en el formulario:</strong><br>
                <?php foreach ($errors as $campo => $error): ?>
                    • <?= $error ?><br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form action="/Parcial2_DSVII/guardar" method="POST">
            <div class="row">
                <div class="form-group">
                    <label>Identidad <span class="required">*</span></label>
                    <input type="text" name="identidad" placeholder="Ej: 1234-5678" 
                           value="<?= $_POST['identidad'] ?? '' ?>" 
                           class="<?= isset($errors['identidad']) ? 'error' : '' ?>">
                    <?php if (isset($errors['identidad'])): ?>
                        <div class="error-text"><?= $errors['identidad'] ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Nombre <span class="required">*</span></label>
                    <input type="text" name="nombre" placeholder="Tu nombre"
                           value="<?= $_POST['nombre'] ?? '' ?>"
                           class="<?= isset($errors['nombre']) ? 'error' : '' ?>">
                    <?php if (isset($errors['nombre'])): ?>
                        <div class="error-text"><?= $errors['nombre'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label>Apellido <span class="required">*</span></label>
                    <input type="text" name="apellido" placeholder="Tu apellido"
                           value="<?= $_POST['apellido'] ?? '' ?>"
                           class="<?= isset($errors['apellido']) ? 'error' : '' ?>">
                    <?php if (isset($errors['apellido'])): ?>
                        <div class="error-text"><?= $errors['apellido'] ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Edad <span class="required">*</span></label>
                    <input type="number" name="edad" placeholder="18-120"
                           value="<?= $_POST['edad'] ?? '' ?>"
                           class="<?= isset($errors['edad']) ? 'error' : '' ?>">
                    <?php if (isset($errors['edad'])): ?>
                        <div class="error-text"><?= $errors['edad'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="row">
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
                        <?php else: ?>
                            <option value="">⚠️ No hay países disponibles</option>
                        <?php endif; ?>
                    </select>
                    <?php if (isset($errors['pais_id'])): ?>
                        <div class="error-text"><?= $errors['pais_id'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="form-group">
                <label>Nacionalidad <span class="required">*</span></label>
                <input type="text" name="nacionalidad" placeholder="Tu nacionalidad"
                       value="<?= $_POST['nacionalidad'] ?? '' ?>">
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label>Correo Electrónico <span class="required">*</span></label>
                    <input type="email" name="correo" placeholder="correo@ejemplo.com"
                           value="<?= $_POST['correo'] ?? '' ?>"
                           class="<?= isset($errors['correo']) ? 'error' : '' ?>">
                    <?php if (isset($errors['correo'])): ?>
                        <div class="error-text"><?= $errors['correo'] ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Celular <span class="required">*</span></label>
                    <input type="text" name="celular" placeholder="8 dígitos"
                           value="<?= $_POST['celular'] ?? '' ?>"
                           class="<?= isset($errors['celular']) ? 'error' : '' ?>">
                    <?php if (isset($errors['celular'])): ?>
                        <div class="error-text"><?= $errors['celular'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="form-group">
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
                        <p style="color: #e74c3c;">⚠️ Error: No se cargaron los temas. Verifica la base de datos.</p>
                    <?php endif; ?>
                </div>
                <?php if (isset($errors['temas'])): ?>
                    <div class="error-text"><?= $errors['temas'] ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label>Observaciones o Consulta</label>
                <textarea name="observaciones" rows="3" placeholder="Escribe aquí tus consultas..."><?= $_POST['observaciones'] ?? '' ?></textarea>
            </div>
            
            <button type="submit" class="btn-submit">📝 Inscribirme</button>
        </form>
        
        <footer>
            <p>© 2025 iTECH. All rights reserved. | info@itech.com | +507 1234-5678</p>
        </footer>
    </div>
</body>
</html>