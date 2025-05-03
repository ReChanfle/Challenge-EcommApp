<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos - Home</title>
    <link rel="stylesheet" href="<?= base_url('css/indexProduct.css') ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<header>
    <div id="toast" class="toast">Producto eliminado</div>
    <div class="menu">
        <h2>Productos</h2>
        <button class="btn-add" id="add_products">Añadir productos</button>
    </div>

    <div class="filters">
        <input type="text" placeholder="ID">
        <input type="text" placeholder="Precio">
        <input type="text" placeholder="Titulo">
        <button class="btn">Limpiar</button>
        <button class="btn">Buscar</button>
    </div>
</header>

<section>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Precio</th>
            <th>Fecha de creación</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= esc($product->id) ?></td>
                    <td><?= esc($product->title) ?></td>
                    <td><?= esc($product->price) ?></td>
                    <td><?= esc($product->created_at) ?></td>
                    <td>
                        <button class="btn-edit delete"  data-id="<?= esc($product->id) ?>">Editar</button>
                        <button class="btn-delete edit"  data-id="<?= esc($product->id) ?>">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No hay productos disponibles.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</section>

<script src="<?= base_url('build/bundle.js') ?>"></script>
<script>
    const csrfToken = '<?= csrf_hash() ?>';
    const csrfName = '<?= csrf_token() ?>';
    const productUrlEdit = '<?= base_url('products/edit') ?>';
    const productUrlDelete = '<?= base_url('products/delete') ?>';
</script>
</body>
</html>
