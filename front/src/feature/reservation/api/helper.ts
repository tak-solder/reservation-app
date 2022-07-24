import eventFactory from "../../event/api/helper";
import Reservation from "../reservation";
import { ReservationData } from "./types";

const reservationFactory: (data: ReservationData) => Reservation = (data) =>
  new Reservation(
    data.id,
    data.eventId,
    data.userId,
    data.amount,
    data.refund,
    data.status,
    data.options,
    eventFactory(data.event)
  );
export default reservationFactory;
