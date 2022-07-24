import { Box, Select, Stack } from "@chakra-ui/react";
import { AxiosError } from "axios";
import dayjs from "dayjs";
import React, { ChangeEventHandler } from "react";
import { ErrorBoundary } from "react-error-boundary";

import Suspense from "../../../components/functional/Suspense";
import { H1 } from "../../../components/ui-elements/heading/Heading";
import ButtonLink from "../../../components/ui-elements/link/ButtonLink";
import AlertMessage from "../../../components/ui-parts/alertMessage/AlertMessage";
import { ApplicationStatus, applicationStatus } from "../../../feature/event/event";
import { locationType } from "../../../feature/event/eventLocation/eventLocation";
import useGetEventsLoader, {
  GetEventsLoader,
} from "../../../feature/event/hooks/useGetEventsLoader";
import EventList from "./components/EventList";
import useEventFilter from "./hooks/useEventFilter";

type EventsPresenterProps = {
  eventsLoader: GetEventsLoader;
};
const EventsPresenter: React.FC<EventsPresenterProps> = ({ eventsLoader }) => {
  const { events } = eventsLoader.getData();
  const { filteredEvents, eventFilter, setLocationType, setApplicationStatus } =
    useEventFilter(events);

  const onLocationTypeChange: ChangeEventHandler<HTMLSelectElement> = (e) => {
    const value: number | undefined = parseInt(e.target.value, 10) || undefined;
    if (value && value < 0) {
      setLocationType(undefined);
    } else {
      setLocationType(value);
    }
  };
  const onApplicationStatusChange: ChangeEventHandler<HTMLSelectElement> = (e) => {
    const value: number | undefined = parseInt(e.target.value, 10) || undefined;
    if (value && value < 0) {
      setApplicationStatus(undefined);
    } else {
      setApplicationStatus(value as ApplicationStatus);
    }
  };

  return (
    <>
      <H1>開催予定のイベント一覧</H1>
      <Box mb={4}>
        <Box fontSize="sm" fontWeight="bold">
          開催方法で絞り込み
        </Box>
        <Select
          size="sm"
          mb={2}
          onChange={onLocationTypeChange}
          value={eventFilter.locationType || -1}
        >
          <option value={-1}>すべての開催方法</option>
          <option value={locationType.REAL}>現地開催のみ</option>
          <option value={locationType.ONLINE}>オンライン開催のみ</option>
        </Select>
        <Box fontSize="sm" fontWeight="bold">
          状態で絞り込み
        </Box>
        <Select
          size="sm"
          mb={2}
          onChange={onApplicationStatusChange}
          value={eventFilter.applicationStatus || -1}
        >
          <option value={-1}>すべてのイベントを表示</option>
          <option value={applicationStatus.AVAILABLE}>申し込み可能なイベントのみ</option>
        </Select>
      </Box>
      <EventList events={filteredEvents} />
      <Stack mt={6}>
        <ButtonLink to="/" colorScheme="gray" mb={4}>
          トップに戻る
        </ButtonLink>
      </Stack>
    </>
  );
};

const Fallback: React.FC<{ loader: GetEventsLoader }> = ({ loader }) => {
  const error = loader.getError();
  let message = "通信エラーが発生しました。\n一度前の画面に戻って、再度お試しください。";
  if (error instanceof AxiosError && error.response?.data?.error) {
    message = error.response?.data?.error;
  }

  return (
    <AlertMessage variant="error" linkTo="/" buttonText="トップへ戻る">
      {message}
    </AlertMessage>
  );
};

const Events: React.FC = () => {
  const { eventsLoader } = useGetEventsLoader({ fromDate: dayjs() });

  return (
    <ErrorBoundary fallback={<Fallback loader={eventsLoader} />}>
      <Suspense>
        <EventsPresenter eventsLoader={eventsLoader} />
      </Suspense>
    </ErrorBoundary>
  );
};

export default Events;
