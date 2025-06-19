import "../css/componets/product-card.css";
import { FaBox } from "react-icons/fa6";
const ProductCard = (params) => {
    const formatCurrency = (value) => {
        return value.toLocaleString("pt-BR", {
            style: "currency",
            currency: "BRL",
        });
    };
    return (
        <div className="card-product" key={params.id}>
            <div className="card-img">
                <FaBox />
            </div>
            <div className="card-info">
                <span className="text-title">{params.title} </span>
                <span className="text-body">{params.description}</span>
            </div>
            <div className="card-footer">
                <span className="text-title">
                    {formatCurrency(params.value)}
                </span>
            </div>
        </div>
    );
};

export default ProductCard;
