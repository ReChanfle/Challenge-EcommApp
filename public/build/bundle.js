/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/products/actions.product.js":
/*!********************************************!*\
  !*** ./assets/products/actions.product.js ***!
  \********************************************/
/***/ (() => {

user = null;


/**
 * Manages product-related operations in the application, including rendering,
 * editing, deleting, and filtering products, as well as user session handling.
 */
class Product {


    /**
     * Initializes the Product class, binds event listeners, and triggers data fetching.
     */
    constructor() {
        this.manageProductActions();
        this.editProduct();
        this.filters();
        $(document).ready(() => {
            this.getProducts();
            this.getUser();

        });
    }


    /**
     * Retrieves the user from localStorage and updates the UI accordingly.
     */
    getUser() {

        const self = this;

        self.user = localStorage.getItem('user');
        const userElement = $('#user');

        if (!self.user || self.user === 'null') {
            userElement.text('Ingresar');
        } else {
            try {
                const user = JSON.parse(self.user);
                userElement.text(`👤 ${user}`);
            } catch (e) {
                userElement.text('Usuario inválido');
            }
        }

        userElement.click(function () {

            if (!self.user || self.user === 'null') {
                window.location.href = landingUrl;
            } else {
              self.openModal('sessionModal');

              $('#logout').click(function () {
                  localStorage.removeItem('user');
                  window.location.href = landingUrl;
              })
            }
        });

    }


    /**
     * Sets up event listeners for adding, editing, and deleting products,
     * as well as handling modal interactions.
     */
    async manageProductActions() {

        const self = this;

        $(document).on('click', '.btn-delete', async function (e) {


            const productId = e.target.dataset.id;

            const url = productUrlDelete + '/' + productId;

            const params = {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrfToken
                }
            };

            const response = await self.fetchData(url, params);
            self.showToast(response.message);

            await self.getProducts();


        });

        $(document).on('click', '.btn-edit', function (e) {


            const productId = e.target.dataset.id;
            const row = e.target.closest('tr');
            const title = row.children[1].textContent;
            const price = row.children[2].textContent;

            document.getElementById('submitProduct').setAttribute('data-id', productId);
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-price').value = price;

            document.getElementById('manageProductModal').style.display = 'flex';

            self.openModal('manageProductModal');
            document.getElementById('modal-title').textContent = 'Editar producto';


        });

        $(document).on('click', '.btn-add', function (e) {


            document.getElementById('submitProduct').removeAttribute('data-id');
            document.getElementById('edit-title').value = '';
            document.getElementById('edit-price').value = '';

            document.getElementById('manageProductModal').style.display = 'flex';
            self.openModal('manageProductModal');

            document.getElementById('modal-title').textContent = 'Agregar producto';


        })

        document.getElementById('closeModalProduct').onclick = () => self.closeModal('manageProductModal');
        document.getElementById('cancelModalProduct').onclick = () => self.closeModal('manageProductModal');
        document.getElementById('closeModalUser').onclick = () => self.closeModal('sessionModal');
        document.getElementById('cancelModalUser').onclick = () => self.closeModal('sessionModal');

    }

    /**
     * Closes the specified modal by removing the display and transition classes.
     * @param {string} modalName - The ID of the modal to close.
     */
    closeModal(modalName) {
        const modal = document.getElementById(modalName);
        modal.classList.remove('show');


        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    /**
     * Opens the specified modal by adding display and transition classes.
     * @param {string} modalName - The ID of the modal to open.
     */
    openModal(modalName) {
        const modal = document.getElementById(modalName);
        modal.style.display = 'flex';

        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }

    /**
     * Displays a toast notification with a given message.
     * @param {string} message - The message to display in the toast.
     */
    showToast(message) {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.classList.add('toast');


        toast.textContent = message;

        container.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('show');
        }, 10);


        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
            }, 500);
        }, 3000);
    }


    /**
     * Displays toast messages based on validation error responses.
     * @param {Object} errors - The error response object containing validation messages.
     */
    toastValidation(errors) {

        const self = this;

        if (errors && errors.message && typeof errors.message === 'object') {
            for (let field in errors.message) {
                if (errors.message.hasOwnProperty(field)) {
                    self.showToast(errors.message[field].toString());
                }
            }
        } else {

            self.showToast('Ha ocurrido un error desconocido.');
        }
    }

    /**
     * Renders the list of products in the table body.
     * @param {Object} data - The response data containing a product payload.
     */
    renderProducts(data) {

        const self = this;

        const tbody = document.getElementById('product-table-body');
        tbody.innerHTML = '';

        if (data.length === 0) {
            self.showToast('No hay productos registrados');
            return;
        }

        data.payload.forEach(product => {
            const row = document.createElement('tr');

            row.innerHTML = `
        <td>${product.id}</td>
        <td>${product.title}</td>
        <td>${product.price}</td>
        <td>${product.created_at}</td>
        <td>
            ${self.user ? `
                <button class="btn-edit edit" data-id="${product.id}">Editar</button>
                <button class="btn-delete delete" data-id="${product.id}">Eliminar</button>
            ` : 'Sin permisos'}
        </td>
    `;

            tbody.appendChild(row);
        });


    }

    /**
     * Binds search and clear filter events to filter products dynamically.
     */
    filters() {

        const self =this;

        $('.search-filtered').click(async function () {

            const id = $('#search-id').val();
            const title = $('#search-title').val();
            const price = $('#search-price').val();

            const query = new URLSearchParams({
                id,
                title,
                price
            }).toString();

            const url = `${getFilteredProductsUrl}?${query}`;

            const response = await self.fetchData(url, null);

            self.renderProducts(response);



        })

        $('.clean-filters').click(function () {

           $('#search-id').val('');
           $('#search-title').val('');
           $('#search-price').val('');

           self.getProducts();

        })

    }

    /**
     * Handles submission of new or edited product data and updates the product list.
     */
    editProduct() {

        const self = this;

        $('#submitProduct').click(async function (e) {

            const productId = e.target.dataset.id;
            let url = null;
            let body = {}

            if (!productId) {
                url = productUrlCreate;
                body.title = document.getElementById('edit-title').value;
                body.price = document.getElementById('edit-price').value;
            }

            else {
                url = productUrlUpdate;
                body.title = document.getElementById('edit-title').value;
                body.price = document.getElementById('edit-price').value;
                body.id = productId;
            }

            const params = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrfToken
                },
                body: JSON.stringify(body)

            };

            const response = await self.fetchData(url, params);
            self.showToast(response.message);
            await self.getProducts();
            self.closeModal('manageProductModal');
        })

    }


    /**
     * Fetches all products from the backend and renders them in the UI.
     */
    async getProducts() {

        const self = this;

        const url = getProductsUrl;

        const params = {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrfToken
            }
        };

        const response = await self.fetchData(url, params);

        self.renderProducts(response);


    }


    /**
     * Sends a fetch request with the given parameters and handles success/error.
     * @param {string} url - The URL to send the request to.
     * @param {Object|null} params - The fetch options such as method, headers, and body.
     * @returns {Promise<Object>} - The parsed JSON response from the server.
     * @throws {Error} - If the response status is not OK or fetch fails.
     */
    async fetchData(url, params) {

        const self = this;

        try {
            const response = await fetch(url, params);

            if (response.ok)
                return await response.json();
            else {
                const responseData = await response.json();
                const errorMessage = responseData.message || 'Error desconocido';
                self.toastValidation(responseData);
                throw new Error(response.status + ' ' + errorMessage);

            }

        } catch (error) {
            console.error('Error en la consulta del producto:', error);
            throw error;
        }
    }


}

let ActionsProduct = new Product();

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be in strict mode.
(() => {
"use strict";
/*!****************************!*\
  !*** ./assets/js/index.js ***!
  \****************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _products_actions_product__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../products/actions.product */ "./assets/products/actions.product.js");
/* harmony import */ var _products_actions_product__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_products_actions_product__WEBPACK_IMPORTED_MODULE_0__);

})();

/******/ })()
;
//# sourceMappingURL=bundle.js.map