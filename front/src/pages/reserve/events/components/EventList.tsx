import { Box, Flex, Icon } from "@chakra-ui/react";
import React, { MouseEventHandler, useState } from "react";
import { MdKeyboardArrowRight, MdPlace, MdQueryBuilder } from "react-icons/md";

import SeatStatus from "../../../../components/ui-elements/SeatStatus/SeatStatus";
import Link from "../../../../components/ui-elements/link/Link";
import AlertModal from "../../../../components/ui-parts/alertModal/AlertModal";
import Event, { applicationStatus } from "../../../../feature/event/event";

type EventItemProps = {
  event: Event;
};
const EventItem: React.FC<EventItemProps> = ({ event }) => {
  const [message, setMessage] = useState<string | undefined>();
  const confirmReserved: MouseEventHandler = (e) => {
    if (event.applicationStatus === applicationStatus.APPLIED) {
      e.preventDefault();
      setMessage("既に予約済みのイベントです");
    } else if (event.remain < 1) {
      e.preventDefault();
      setMessage("ご予約が満席のためお申し込み出来ません");
    } else if (event.applicationStatus !== applicationStatus.AVAILABLE) {
      e.preventDefault();
      setMessage("このイベントは現在ご予約を受け付けておりません");
    }
  };

  const clearMessage = () => setMessage(undefined);

  return (
    <>
      <Link
        to={`/reservation/event/${event.id}`}
        onClick={confirmReserved}
        _hover={{ textDecoration: "none" }}
      >
        <Box
          border="1px"
          borderRadius="sm"
          borderColor="gray.300"
          bg="gray.50"
          mb={2}
          p={1}
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
            <Box px={1}>
              <SeatStatus status={event.seatStatus()} />
            </Box>
            <Box>
              <Icon as={MdKeyboardArrowRight} />
            </Box>
          </Flex>
        </Box>
      </Link>
      <AlertModal variant="error" isOpen={message !== undefined} onClose={clearMessage}>
        {message}
      </AlertModal>
    </>
  );
};

type EventListProps = {
  events: Event[];
};
const EventList: React.FC<EventListProps> = ({ events }) => {
  if (!events.length) {
    return (
      <Box border="1px" borderColor="gray.300" backgroundColor="gray.100" p={3} borderRadius={2}>
        該当するイベントが見つかりませんでした。
        <br />
        絞り込み条件を変えて検索してください。
      </Box>
    );
  }

  return (
    <>
      {events.map((event) => (
        <EventItem key={event.id} event={event} />
      ))}
    </>
  );
};

export default EventList;
