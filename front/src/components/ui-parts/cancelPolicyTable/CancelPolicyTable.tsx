import {
  Accordion,
  AccordionButton,
  AccordionIcon,
  AccordionItem,
  AccordionPanel,
  Box,
  Table,
  TableContainer,
  Tbody,
  Td,
  Th,
  Thead,
  Tr,
} from "@chakra-ui/react";
import React from "react";

import EventClass from "../../../feature/event/event";

type CancelPolicyTableProps = {
  event: EventClass;
};
const CancelPolicyTable: React.FC<CancelPolicyTableProps> = ({ event }) => (
  <Accordion allowToggle mb={4}>
    <AccordionItem borderBottom="none">
      <AccordionButton bg="gray.100">
        <Box flex="1" textAlign="left">
          キャンセルポリシー
        </Box>
        <AccordionIcon />
      </AccordionButton>
      <AccordionPanel pt={1} px={0}>
        <TableContainer>
          <Table size="sm">
            <Thead>
              <Tr>
                <Th>キャンセル日時</Th>
                <Th>キャンセル料</Th>
              </Tr>
            </Thead>
            <Tbody>
              <Tr>
                <Td>
                  {event.startDate.subtract(7, "days").format("M月D日(ddd) HH:mm")}
                  まで
                </Td>
                <Td>無料</Td>
              </Tr>
              <Tr>
                <Td>
                  {event.startDate.subtract(3, "days").format("M月D日(ddd) HH:mm")}
                  まで
                </Td>
                <Td>支払い金額の75%</Td>
              </Tr>
              <Tr>
                <Td>
                  {event.startDate.subtract(3, "days").format("M月D日(ddd) HH:mm")}
                  以降
                </Td>
                <Td>支払い金額の100%</Td>
              </Tr>
            </Tbody>
          </Table>
        </TableContainer>
      </AccordionPanel>
    </AccordionItem>
  </Accordion>
);
export default CancelPolicyTable;
