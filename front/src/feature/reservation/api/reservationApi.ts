import axios from "axios";

import { makePager } from "../../pager/hepler";
import { CancelQuotation } from "../types";
import reservationFactory from "./helper";
import { ConfirmCancel, ExecuteCancel, GetReservation, GetReservations } from "./types";

export const getReservations: GetReservations = async (req) => {
  const params = {
    status: req.status,
    page: req.page || 1,
  };

  const { data } = await axios.get(`${import.meta.env.VITE_API_URL}/reservation/get-reservations`, {
    params,
  });
  return {
    reservations: data.reservations.map(reservationFactory),
    pager: makePager(data.pager),
  };
};

export const getReservation: GetReservation = async ({ id }) => {
  const params = {
    id,
  };
  const { data } = await axios.get(`${import.meta.env.VITE_API_URL}/reservation/get-reservation`, {
    params,
  });
  if (!data.reservation) {
    return { reservation: undefined };
  }
  return { reservation: reservationFactory(data.reservation) };
};

export const confirmCancel: ConfirmCancel = async (req) => {
  const params = {
    reservationId: req.reservationId,
  };
  const { data } = await axios.get(`${import.meta.env.VITE_API_URL}/reservation/confirm-cancel`, {
    params,
  });
  return { quotation: data as CancelQuotation };
};

export const executeCancel: ExecuteCancel = async (req) => {
  const params = {
    reservationId: req.reservationId,
    cancelRate: req.cancelRate,
  };
  const { data } = await axios.get(`${import.meta.env.VITE_API_URL}/reservation/execute-cancel`, {
    params,
  });
  return { quotation: data as CancelQuotation };
};
