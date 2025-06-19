export class PaymentDTO {
    constructor(method, installments, products) {
        this.method = method;
        this.installments = installments;
        this.products = products.map((product) => ({
            name: product.name,
            value: Number(product.value),
            quantity: Number(1),
        }));
    }

    toObject() {
        return {
            method: this.method,
            installments: this.installments,
            products: this.products,
        };
    }
}
