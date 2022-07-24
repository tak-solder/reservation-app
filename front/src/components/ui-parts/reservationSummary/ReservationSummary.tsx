import { Box } from "@chakra-ui/react";
import React from "react";

import Reservation, { reservationStatus } from "../../../feature/reservation/reservation";
import EventInfo from "../eventInfo/EventInfo";
import LocationInfo from "../locationInfo/LocationInfo";
import PaymentInfo from "../paymentInfo/PaymentInfo";
import ReservationInfo from "./components/ReservationInfo";

type ReservationTableProps = {
  reservation: Reservation;
};
const ReservationSummary: React.FC<ReservationTableProps> = ({ reservation }) => {
  const { event } = reservation;
  return (
    <Box>
      <EventInfo event={event} />
      {reservation.status === reservationStatus.APPLIED && (
        <LocationInfo location={event.location} />
      )}
      <ReservationInfo reservation={reservation} />
      <PaymentInfo
        event={reservation.event}
        reservationOptions={reservation.options}
        totalCost={reservation.amount}
        refund={reservation.status === reservationStatus.CANCELED ? reservation.refund : undefined}
      />
    </Box>
  );
};

export default ReservationSummary;
