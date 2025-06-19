import api from "./api";

export const finishCart = async (data) => {
    return await api.post("/cart/finish", data);
};
