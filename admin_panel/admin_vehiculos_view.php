<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Administrador de Vehículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4 text-center">Panel de Administrador</h1>

        <div class="card shadow mb-5">
            <div class="card-header bg-primary text-white">
                Agregar nuevo vehículo
            </div>
            <div class="card-body">
                <?php if (!empty($mensaje)) echo "<div class='alert alert-info'>$mensaje</div>"; ?>

                <form method="POST" action="admin_vehiculos.php" enctype="multipart/form-data" novalidate>
                    <div class="mb-3">
                        <label for="patente" class="form-label">Patente</label>
                        <input type="text" class="form-control" id="patente" name="patente" required>
                    </div>

                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" required>
                    </div>

                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" required>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado del vehículo</label>
                        <textarea class="form-control" id="estado" name="estado" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="imagen" class="form-label">Foto del vehículo (opcional)</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-success">Agregar vehículo</button>
                </form>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                Vehículos registrados
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Patente</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Estado</th>
                            <th>Foto</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vehiculos as $vehiculo): ?>
                            <tr>
                                <td><?= htmlspecialchars($vehiculo['id']) ?></td>
                                <td><?= htmlspecialchars($vehiculo['patente']) ?></td>
                                <td><?= htmlspecialchars($vehiculo['marca']) ?></td>
                                <td><?= htmlspecialchars($vehiculo['modelo']) ?></td>
                                <td><?= htmlspecialchars($vehiculo['estado']) ?></td>
                                <td class="text-center">
                                    <?php if (!empty($vehiculo['imagen'])): ?>
                                        <img src="<?= htmlspecialchars($vehiculo['imagen']) ?>" alt="Foto vehículo" style="max-height:60px; max-width:100px;" class="img-thumbnail" />
                                    <?php else: ?>
                                        <span class="text-muted">Sin foto</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="admin_vehiculos.php?eliminar=<?= $vehiculo['id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('¿Eliminar este vehículo?');">
                                       Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if ($mostrarModalDuplicado): ?>
    <div class="modal fade" id="modalDuplicado" tabindex="-1" aria-labelledby="modalDuplicadoLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="modalDuplicadoLabel">❗ Vehículo ya registrado</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            Los datos ingresados ya existen en la base de datos. Por favor verifica la información.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Entendido</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      const modal = new bootstrap.Modal(document.getElementById('modalDuplicado'));
      window.addEventListener('load', () => {
        modal.show();
      });
    </script>
    <?php else: ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php endif; ?>
</body>
</html>
