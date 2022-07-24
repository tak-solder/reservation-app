import Event from "../event/event";
import { ReservationOptions } from "./reservationOption";

export const reservationStatus = {
  CANCELED: 0,
  APPLIED: 1,
  FINISHED: 2,
};
export type ReservationStatus = typeof reservationStatus[keyof typeof reservationStatus];

type ReservationMethods = {
  getStatusText: () => string;
};
class Reservation implements ReservationMethods {
  constructor(
    readonly id: number,
    readonly eventId: number,
    readonly userId: number,
    readonly amount: number,
    readonly refund: number,
    readonly status: ReservationStatus,
    readonly options: ReservationOptions,
    readonly event: Event
  ) {}

  getStatusText() {
    if (this.status === reservationStatus.CANCELED) {
      return "キャンセル済み";
    }
    if (this.status === reservationStatus.APPLIED) {
      return "予約済み";
    }
    if (this.status === reservationStatus.FINISHED) {
      return "開催済み";
    }
    return "不明";
  }
}

export default Reservation;
