import { Box, Table, TableContainer, Tbody, Td, Th, Tr } from "@chakra-ui/react";
import React from "react";

import Reservation from "../../../../feature/reservation/reservation";
import { H2 } from "../../../ui-elements/heading/Heading";
import ReservationOptionInfo from "./ReservationOptionInfo";

type ReservationInfoProps = {
  reservation: Reservation;
};
const ReservationInfo: React.FC<ReservationInfoProps> = ({ reservation }) => (
  <Box>
    <H2>予約情報</H2>
    <TableContainer mb={4}>
      <Table size="sm" borderTop="1px solid var(--chakra-colors-gray-100)">
        <Tbody>
          <Tr>
            <Th>予約状態</Th>
            <Td>{reservation.getStatusText()}</Td>
          </Tr>
        </Tbody>
      </Table>
    </TableContainer>
    <ReservationOptionInfo reservation={reservation} />
  </Box>
);
export default ReservationInfo;
