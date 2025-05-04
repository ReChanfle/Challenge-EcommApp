<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos - Home</title>
    <link rel="stylesheet" href="<?= base_url('css/indexProduct.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/modal.css') ?>">
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
        <tbody id="product-table-body">
        </tbody>
    </table>
</section>

<div id="editModal" style="display:none;" class="modal-container">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Editar producto</h3>
            <button class="modal-close" id="closeModal">X</button>
        </div>

            <label for="edit-title">Título:</label>
            <input type="text" id="edit-title" required>

            <label for="edit-price">Precio:</label>
            <input type="number" id="edit-price" required>

            <div class="modal-actions">
                <button class="btn-save" id="editProduct" data-id="">Guardar</button>
                <button type="button" class="btn-cancel" id="cancelModal">Cancelar</button>
            </div>
    </div>
</div>

<script src="<?= base_url('build/bundle.js') ?>"></script>
<script>
    const csrfToken = '<?= csrf_hash() ?>';
    const csrfName = '<?= csrf_token() ?>';
    const productUrlEdit = '<?= base_url('products/edit') ?>';
    const productUrlDelete = '<?= base_url('products/delete') ?>';
    const getProductsUrl = '<?= base_url('getProducts') ?>';
</script>
</body>
</html>
