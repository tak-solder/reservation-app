import { EventData } from "../../event/api/types";
import { EventOptionKey } from "../../event/eventOption/eventOption";
import SimplePager from "../../pager/simplePager";
import Reservation, { ReservationStatus } from "../reservation";
import { ReservationOption } from "../reservationOption";
import { CancelQuotation } from "../types";

export type ReservationData = {
  id: number;
  eventId: number;
  userId: number;
  amount: number;
  refund: number;
  status: ReservationStatus;
  options: Record<EventOptionKey, ReservationOption>;
  event: EventData;
};

export type GetReservationsRequest = {
  status: ReservationStatus;
  page?: number;
};
export type GetReservationsResponse = {
  reservations: Reservation[];
  pager: SimplePager;
};
export type GetReservations = (req: GetReservationsRequest) => Promise<GetReservationsResponse>;

export type GetReservationRequest = {
  id: number;
};
export type GetReservationResponse = {
  reservation: Reservation | undefined;
};
export type GetReservation = (req: GetReservationRequest) => Promise<GetReservationResponse>;

export type ConfirmCancelRequest = {
  reservationId: number;
};
export type ConfirmCancelResponse = {
  quotation: CancelQuotation;
};
export type ConfirmCancel = (req: ConfirmCancelRequest) => Promise<ConfirmCancelResponse>;

export type ExecuteCancelRequest = {
  reservationId: number;
  cancelRate: number;
};
export type ExecuteCancelResponse = {
  quotation: CancelQuotation;
};
export type ExecuteCancel = (req: ExecuteCancelRequest) => Promise<ExecuteCancelResponse>;
