import { Td, Th, Tr } from "@chakra-ui/react";
import React from "react";

import { eventOptionKeys } from "../../../../feature/event/eventOption/eventOption";
import ExtraTimeOption from "../../../../feature/event/eventOption/extraTimeOption";
import Reservation from "../../../../feature/reservation/reservation";
import { ReservationOption } from "../../../../feature/reservation/reservationOption";

type OptionRowProps = {
  reservation: Reservation;
  option: ReservationOption;
};
const ExtraTimeRow: React.FC<OptionRowProps> = ({ reservation, option }) => {
  const quantity = option.value as number;
  const eventOption = reservation.event.options.find(
    ({ key }) => key === eventOptionKeys.ExtraTime
  ) as ExtraTimeOption;

  if (!eventOption) {
    throw Error(`undefined event option: ${eventOptionKeys.ExtraTime}`);
  }

  return (
    <Tr>
      <Th>{eventOption.name}</Th>
      <Td>{quantity === 0 ? "延長なし" : `${eventOption.meta.minutes * quantity}分延長`}</Td>
    </Tr>
  );
};

const OptionRow: React.FC<OptionRowProps> = (props) => {
  const { option } = props;
  if (option.key === eventOptionKeys.ExtraTime) {
    return <ExtraTimeRow {...props} />;
  }

  throw Error("unknown event option");
};
export default OptionRow;
