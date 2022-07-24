import { Box, Table, TableContainer, Tbody, Td, Th, Tr } from "@chakra-ui/react";
import React from "react";

import Event from "../../../feature/event/event";
import { H2 } from "../../ui-elements/heading/Heading";

type EventInfoProps = {
  event: Event;
};
const EventInfo: React.FC<EventInfoProps> = ({ event }) => (
  <Box>
    <H2>{event.title}</H2>
    <Box mb={2} whiteSpace="pre-wrap">
      {event.description}
    </Box>
    <TableContainer mb={4}>
      <Table size="sm" borderTop="1px solid var(--chakra-colors-gray-100)">
        <Tbody>
          <Tr>
            <Th>日程</Th>
            <Td>
              {event.startDate.format("M月D日(ddd)")}
              <br />
              {event.startDate.format("HH:mm")}〜{event.endDate.format("HH:mm")}
            </Td>
          </Tr>
          <Tr>
            <Th>開催方法</Th>
            <Td>{event.location.locationTypeStr()}</Td>
          </Tr>
        </Tbody>
      </Table>
    </TableContainer>
  </Box>
);
export default EventInfo;
