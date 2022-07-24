import { Stack, Tab, TabList, Tabs } from "@chakra-ui/react";
import { AxiosError } from "axios";
import React from "react";
import { ErrorBoundary } from "react-error-boundary";

import Suspense from "../../../components/functional/Suspense";
import { H1 } from "../../../components/ui-elements/heading/Heading";
import ButtonLink from "../../../components/ui-elements/link/ButtonLink";
import AlertMessage from "../../../components/ui-parts/alertMessage/AlertMessage";
import SimplePaginator from "../../../components/ui-parts/paginator/SimplePaginator";
import Loadable from "../../../feature/async/loadable";
import { GetReservationsResponse } from "../../../feature/reservation/api/types";
import useGetReservationsLoader, {
  GetReservationsLoader,
} from "../../../feature/reservation/hooks/useGetReservationsLoader";
import { reservationStatus, ReservationStatus } from "../../../feature/reservation/reservation";
import ReservationItem from "./components/ReservationItem";

const reservationStatusTabs = [
  {
    status: reservationStatus.APPLIED,
    text: "予約済",
  },
  {
    status: reservationStatus.FINISHED,
    text: "開催済",
  },
  {
    status: reservationStatus.CANCELED,
    text: "キャンセル済",
  },
] as const;

type EventListViewProps = {
  reservationsLoader: Loadable<GetReservationsResponse>;
  setPage: (page: number) => void;
};
const EventListView: React.FC<EventListViewProps> = ({ reservationsLoader, setPage }) => {
  const { reservations, pager } = reservationsLoader.getData();

  if (!reservations.length) {
    return (
      <AlertMessage variant="warning">条件に合う申し込みが見つかりませんでした。</AlertMessage>
    );
  }

  return (
    <>
      {reservations.map((reservation) => (
        <ReservationItem key={reservation.id} reservation={reservation} />
      ))}
      <SimplePaginator currentPage={pager.current} setPage={setPage} hasMore={pager.hasMore} />
    </>
  );
};

type ReservationsPresenterProps = {
  reservationsLoader: GetReservationsLoader;
  setStatus: (reservationStatus: ReservationStatus) => void;
  setPage: (page: number) => void;
};

const ReservationsPresenter: React.FC<ReservationsPresenterProps> = ({
  reservationsLoader,
  setStatus,
  setPage,
}) => {
  const handleTabChange = (index: number) => {
    const tab = reservationStatusTabs[index];
    setStatus(tab.status);
  };

  return (
    <>
      <H1>申済履歴</H1>
      <Tabs isManual onChange={handleTabChange} mb={3}>
        <TabList>
          {reservationStatusTabs.map((tab) => (
            <Tab key={tab.status}>{tab.text}</Tab>
          ))}
        </TabList>
      </Tabs>
      {reservationsLoader && (
        <Suspense>
          <EventListView reservationsLoader={reservationsLoader} setPage={setPage} />
        </Suspense>
      )}
      <Stack mt={6}>
        <ButtonLink to="/" colorScheme="gray" mb={4}>
          トップに戻る
        </ButtonLink>
      </Stack>
    </>
  );
};

const Fallback: React.FC<{ loader: GetReservationsLoader }> = ({ loader }) => {
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

const Reservations: React.FC = () => {
  const { reservationsLoader, setStatus, setPage } = useGetReservationsLoader({
    status: reservationStatus.APPLIED,
    page: 1,
  });

  return (
    <ErrorBoundary fallback={<Fallback loader={reservationsLoader} />}>
      <ReservationsPresenter
        reservationsLoader={reservationsLoader}
        setStatus={setStatus}
        setPage={setPage}
      />
    </ErrorBoundary>
  );
};

export default Reservations;
