/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/products/actions.product.js":
/*!********************************************!*\
  !*** ./assets/products/actions.product.js ***!
  \********************************************/
/***/ (() => {




class Product {

    constructor() {
        this.getProductIdOnClickDelete();
        this.editProduct();
        $(document).ready(() => {
            this.getProducts();
        });
    }


    async getProductIdOnClickDelete() {

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

        $(document).on('click', '.btn-edit', async function (e) {


            const productId = e.target.dataset.id;
            const row = e.target.closest('tr');
            const title = row.children[1].textContent;
            const price = row.children[2].textContent;

            document.getElementById('editProduct').setAttribute('data-id', productId);
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-price').value = price;

            document.getElementById('editModal').style.display = 'flex';

            self.openModal();


        })

        document.getElementById('closeModal').onclick = self.closeModal;
        document.getElementById('cancelModal').onclick = self.closeModal;

    }

    closeModal() {
        const modal = document.getElementById('editModal');
        modal.classList.remove('show');


        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    openModal() {
        const modal = document.getElementById('editModal');
        modal.style.display = 'flex';

        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }

    showToast(message = 'Acción realizada') {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.classList.add('show');

        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

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
                <button class="btn-edit edit" data-id="${product.id}">Editar</button>
                <button class="btn-delete delete" data-id="${product.id}">Eliminar</button>
            </td>
        `;

            tbody.appendChild(row);
        });


    }

    editProduct() {

        const self = this;

       $('#editProduct').click(async function (e) {


           const productId = e.target.dataset.id;

           const url = productUrlEdit

           const params = {
               method: 'POST',
               headers: {
                   'Content-Type': 'application/json',
                   'X-CSRF-Token': csrfToken
               },
               body: JSON.stringify({
                   id: productId,
                   title: document.getElementById('edit-title').value,
                   price: document.getElementById('edit-price').value
               })

           };

           const response = await self.fetchData(url, params);
           self.showToast(response.message);
           await self.getProducts();
           self.closeModal();
       })

    }


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



    async fetchData(url, params) {

        const self = this;

        try {
            const response = await fetch(url, params);

            if (response.ok)
                return await response.json();
            else {
                const responseData = await response.json();
                const errorMessage = responseData.message || 'Error desconocido';
                self.showToast(errorMessage);
                throw new Error(response.status + ' ' + errorMessage);

            }

        } catch (error) {
            self.showToast(error);
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