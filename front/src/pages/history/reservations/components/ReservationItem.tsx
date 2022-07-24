import { Box, Flex, Icon } from "@chakra-ui/react";
import React from "react";
import { MdKeyboardArrowRight, MdPlace, MdQueryBuilder } from "react-icons/md";

import Link from "../../../../components/ui-elements/link/Link";
import Reservation from "../../../../feature/reservation/reservation";

type ReserveEventCardProps = {
  reservation: Reservation;
};
const ReservationItem: React.FC<ReserveEventCardProps> = ({ reservation }) => {
  const { event } = reservation;
  return (
    <Link to={`/history/reservation/${reservation.id}`} _hover={{ textDecoration: "none" }}>
      <Box
        border="1px"
        borderRadius="sm"
        mb={2}
        p={1}
        borderColor="gray.300"
        bg="gray.50"
        _hover={{ bg: "gray.200" }}
      >
        <Flex alignItems="center">
          <Box flex={1}>
            <Box fontWeight="bold">{event.title}</Box>
            <Box>
              <Icon as={MdQueryBuilder} verticalAlign="middle" />
              <Box display="inline-block" px={1}>
                {event.startDate.format("M月D日(ddd)")}
              </Box>
              <Box display="inline-block">
                {event.startDate.format("HH:mm")}〜{event.endDate.format("HH:mm")}
              </Box>
            </Box>
            <Box>
              <Icon as={MdPlace} verticalAlign="middle" />
              <Box display="inline-block" px={1}>
                {event.location.name}
              </Box>
            </Box>
          </Box>
          <Box>
            <Icon as={MdKeyboardArrowRight} />
          </Box>
        </Flex>
      </Box>
    </Link>
  );
};

export default ReservationItem;
