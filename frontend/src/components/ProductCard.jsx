import "../css/componets/product-card.css";
const ProductCard = (params) => {
    const formatCurrency = (value) => {
        return value.toLocaleString("pt-BR", {
            style: "currency",
            currency: "BRL",
        });
    };
    return (
        <div class="card-product" key={params.id}>
            <div class="card-img"></div>
            <div class="card-info">
                <span class="text-title">{params.title} </span>
                <span class="text-body">{params.description}</span>
            </div>
            <div class="card-footer">
                <span class="text-title">{formatCurrency(params.value)}</span>
            </div>
        </div>
    );
};

export default ProductCard;
