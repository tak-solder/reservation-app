import { EventOptionKey } from "../../event/eventOption/eventOption";
import Reservation from "../../reservation/reservation";

export type ReservationOrderData = {
  eventId: number;
  optionValues: Record<EventOptionKey, number | boolean>;
};

export const paymentProvider = {
  STRIPE: 1,
  PAYPAY: 2,
};
export type PaymentProvider = typeof paymentProvider[keyof typeof paymentProvider];

export type CreateCheckoutUrlRequest = {
  provider: PaymentProvider;
  order: ReservationOrderData;
};
export type CreateCheckoutResponse = {
  url: string;
};
export type CreateCheckoutUrl = (req: CreateCheckoutUrlRequest) => Promise<CreateCheckoutResponse>;

export type CompletePaymentResponse = {
  reservation: Reservation | undefined;
};
export type CompletePayment = () => Promise<CompletePaymentResponse>;
