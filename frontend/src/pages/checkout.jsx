import { useState } from "react";
import "../css/styles-global.css";
import ProductCard from "../components/ProductCard.jsx";
import { finishCart } from "../service/cartService.js";
import { PaymentDTO } from "../DTO/cartDTO.js";

const CheckoutScreen = () => {
    const [method, setMethod] = useState("PIX");
    const [installments, setInstallments] = useState(1);

    const renderInstallmentOptions = () => {
        const options = [];
        for (let i = 2; i <= 12; i++) {
            const finalValue = total * Math.pow(1.01, i);
            const perInstallment = finalValue / i;

            options.push(
                <option key={i} value={i}>
                    {i}x de R${perInstallment.toFixed(2)} (Total: R$
                    {finalValue.toFixed(2)})
                </option>
            );
        }
        return options;
    };

    const products = [
        {
            id: 1,
            name: "Smartphone Galaxy A54",
            description: "Tela AMOLED 6.5”, 128GB, Câmera Tripla, 5G",
            value: 1799.9,
        },
        {
            id: 2,
            name: "Notebook Lenovo IdeaPad 3",
            description: "Ryzen 5, 8GB RAM, SSD 256GB, Windows 11",
            value: 2699.0,
        },
        {
            id: 3,
            name: "Smart TV LG 50'' 4K",
            description: "webOS, HDR, Alexa integrada, Wi-Fi",
            value: 2499.99,
        },
        {
            id: 4,
            name: "Fone de Ouvido Bluetooth JBL",
            description: "TWS, Bateria até 20h, Estojo carregador",
            value: 349.9,
        },
        {
            id: 5,
            name: "Cadeira Gamer ThunderX3",
            description: "Ergonômica, Couro PU, Reclinável até 180º",
            value: 1199.0,
        },
    ];

    const calculateTotal = (products) => {
        return products.reduce((total, product) => total + product.value, 0);
    };

    const [total] = useState(calculateTotal(products));
    const handlePayment = async () => {
        const data = new PaymentDTO(method, installments, products);
        const response = await finishCart(data);

        if (response.status === 200) {
            alert(
                response.data.message +
                    "\n" +
                    "Total do pedido: R$ " +
                    response.data.data.total_value
            );
        } else {
            alert("Erro ao realizar o pagamento");
        }
    };
    return (
        <div className="container">
            <div className="card card-left">
                <h2>Detalhes do Pedido</h2>
                {products.map((product) => (
                    <ProductCard
                        key={product.id}
                        title={product.name}
                        description={product.description}
                        value={product.value}
                    />
                ))}
            </div>

            <div className="card card-right">
                <h2>Checkout</h2>
                <hr />

                <h3>Total: R${total.toFixed(2)}</h3>

                <div className="container-payament">
                    <span
                        className="select-installments-text"
                        style={{ marginBottom: "1rem" }}
                    >
                        Selecione a forma de pagamento
                    </span>
                    <div className="tabs">
                        <input
                            name="tabs"
                            id="radio-1"
                            type="radio"
                            onChange={() => setMethod("PIX")}
                        />
                        <label htmlFor="radio-1" className="tab">
                            PIX
                        </label>

                        <input
                            name="tabs"
                            id="radio-2"
                            type="radio"
                            onChange={() => setMethod("CREDIT_CARD_ONE_TIME")}
                        />
                        <label htmlFor="radio-2" className="tab">
                            Crédito à vista
                        </label>

                        <input
                            name="tabs"
                            id="radio-3"
                            type="radio"
                            onChange={() =>
                                setMethod("CREDIT_CARD_INSTALLMENTS")
                            }
                        />
                        <label htmlFor="radio-3" className="tab">
                            Crédito parcelado
                        </label>

                        <span className="glider"></span>
                    </div>

                    {method === "CREDIT_CARD_INSTALLMENTS" && (
                        <div
                            style={{ marginTop: "20px", "text-align": "left" }}
                        >
                            <label
                                htmlFor="parcelas"
                                className="select-installments-text"
                            >
                                Escolha o número de parcelas:
                            </label>
                            <select
                                id="parcelas"
                                value={installments}
                                onChange={(e) =>
                                    setInstallments(parseInt(e.target.value))
                                }
                                className="select-installments"
                            >
                                {renderInstallmentOptions()}
                            </select>
                        </div>
                    )}
                </div>

                <button type="submit" onClick={handlePayment}>
                    Finalizar
                </button>
            </div>
        </div>
    );
};

export default CheckoutScreen;
