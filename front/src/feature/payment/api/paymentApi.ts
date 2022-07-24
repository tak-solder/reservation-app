import axios from "axios";

import reservationFactory from "../../reservation/api/helper";
import { CompletePayment, CreateCheckoutUrl } from "./types";

export const createCheckoutUrl: CreateCheckoutUrl = async (req) => {
  const params = {
    provider: req.provider,
    order: req.order,
  };

  const { data } = await axios.post(`${import.meta.env.VITE_API_URL}/payment/checkout`, params);
  return { url: data.url };
};

export const completePayment: CompletePayment = async () => {
  const { data } = await axios.post(`${import.meta.env.VITE_API_URL}/payment/complete`);
  if (!data.reservation) {
    return { reservation: undefined };
  }
  return { reservation: reservationFactory(data.reservation) };
};
