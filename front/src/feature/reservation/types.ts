export type CancelQuotation = {
  reservationId: number;
  eventId: number;
  paidAmount: number;
  cancelRate: number;
  cancelCharge: number;
  cancelRefund: number;
};
