

class Product {

    constructor() {
        this.getProductIdOnClickDelete();
    }


    async getProductIdOnClickDelete() {

        const self = this;

        $(document).on('click', '.btn-delete', async function (e) {
            console.log(e.target.dataset.id);

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


        })

    }

    showToast(message = 'Acción realizada') {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.classList.add('show');

        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
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
            console.error('Error en la consulta del producto:', error);
            throw error;
        }
    }


}

let ActionsProduct = new Product();