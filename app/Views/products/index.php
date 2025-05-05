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

    <div class="user-info">
        <button id="user" class="btn user-button"></button>
    </div>

    <div id="toast-container"></div>

    <div class="menu">
        <h2>Productos</h2>
        <button class="btn-add" id="add_products">Añadir productos</button>
    </div>

    <div class="filters">
        <input type="number" placeholder="ID" id="search-id">
        <input type="number" placeholder="Precio" id="search-price">
        <input type="text" placeholder="Titulo" id="search-title">
        <button class="btn clean-filters">Limpiar</button>
        <button class="btn search-filtered">Buscar</button>
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
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody id="product-table-body">
        </tbody>
    </table>
</section>

<div id="manageProductModal" style="display:none;" class="modal-container">
    <div class="modal-box">
        <div class="modal-header">
            <h3 id="modal-title">Editar producto</h3>
            <button class="modal-close" id="closeModalProduct">X</button>
        </div>

            <label for="edit-title">Título:</label>
            <input type="text" id="edit-title" placeholder="Titulo" required>

            <label for="edit-price">Precio:</label>
            <input type="number" id="edit-price" placeholder="Precio" required>

            <div class="modal-actions">
                <button class="btn-save" id="submitProduct" data-id="">Guardar</button>
                <button type="button" class="btn-cancel" id="cancelModalProduct">Cancelar</button>
            </div>
    </div>
</div>


<div id="sessionModal" style="display:none;" class="modal-container">
    <div class="modal-box">
        <div class="modal-header">
            <h3 id="modal-title">Cerrar sesion</h3>
            <button class="modal-close" id="closeModalUser">X</button>
        </div>
        <div class="modal-actions">
            <button class="btn-save" id="logout" data-id="">Cerrar</button>
            <button type="button" class="btn-cancel" id="cancelModalUser">Cancelar</button>
        </div>
    </div>
</div>



<script src="<?= base_url('build/bundle.js') ?>"></script>
<script>
    const csrfToken = '<?= csrf_hash() ?>';
    const csrfName = '<?= csrf_token() ?>';
    const productUrlCreate = '<?= base_url('products/create') ?>';
    const productUrlUpdate = '<?= base_url('products/update') ?>';
    const productUrlDelete = '<?= base_url('products/delete') ?>';
    const getProductsUrl = '<?= base_url('getProducts') ?>';
    const getFilteredProductsUrl = '<?= base_url('getProducts/') ?>';
    const landingUrl = '<?= base_url() ?>';
</script>
</body>
</html>
