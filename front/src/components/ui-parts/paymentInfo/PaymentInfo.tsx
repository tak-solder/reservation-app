import { Box, Table, TableContainer, Tbody, Td, Th, Tr } from "@chakra-ui/react";
import React from "react";

import Event from "../../../feature/event/event";
import { eventOptionInputType } from "../../../feature/event/eventOption/eventOption";
import { ReservationOptions } from "../../../feature/reservation/reservationOption";
import { numberFormat } from "../../../utils/formatter";
import { H2 } from "../../ui-elements/heading/Heading";

const calcOptionCost: (event: Event, reservationOptions: ReservationOptions) => number = (
  event,
  reservationOptions
) =>
  event.options.reduce((sum, eventOption) => {
    const reservationOption = reservationOptions[eventOption.key];
    if (!reservationOption) {
      return sum;
    }

    switch (eventOption.inputType) {
      case eventOptionInputType.QUANTITY:
        return (reservationOption.value as number) * eventOption.meta.cost + sum;

      default:
        throw Error(`不明なInputType: ${eventOption.inputType}`);
    }
  }, 0);

type PaymentInfoProps = {
  event: Event;
  reservationOptions: ReservationOptions;
  totalCost?: number | undefined;
  refund?: number | undefined;
};
const PaymentInfo: React.FC<PaymentInfoProps> = ({
  event,
  reservationOptions,
  totalCost = undefined,
  refund = undefined,
}) => {
  const optionCost = calcOptionCost(event, reservationOptions);
  const displayTotalCost = totalCost === undefined ? event.cost + optionCost : totalCost;

  return (
    <Box>
      <H2>支払い金額</H2>
      <TableContainer mb={4}>
        <Table size="sm" borderTop="1px solid var(--chakra-colors-gray-100)">
          <Tbody>
            <Tr>
              <Th>参加費用</Th>
              <Td>{numberFormat(event.cost)}円</Td>
            </Tr>
            <Tr>
              <Th>オプション費用</Th>
              <Td>{numberFormat(optionCost)}円</Td>
            </Tr>
            <Tr>
              <Th>合計</Th>
              <Td>{numberFormat(displayTotalCost)}円</Td>
            </Tr>
            {refund !== undefined && (
              <Tr>
                <Th>返金額</Th>
                <Td>{numberFormat(refund)}円</Td>
              </Tr>
            )}
          </Tbody>
        </Table>
      </TableContainer>
    </Box>
  );
};
export default PaymentInfo;
