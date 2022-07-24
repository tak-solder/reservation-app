import { Button, Stack, useDisclosure } from "@chakra-ui/react";
import { AxiosError } from "axios";
import React from "react";
import { ErrorBoundary } from "react-error-boundary";
import { useParams } from "react-router-dom";

import Suspense from "../../../components/functional/Suspense";
import { H1 } from "../../../components/ui-elements/heading/Heading";
import ButtonLink from "../../../components/ui-elements/link/ButtonLink";
import AlertMessage from "../../../components/ui-parts/alertMessage/AlertMessage";
import CancelPolicyTable from "../../../components/ui-parts/cancelPolicyTable/CancelPolicyTable";
import ReservationSummary from "../../../components/ui-parts/reservationSummary/ReservationSummary";
import useGetReservationLoader, {
  GetReservationLoader,
} from "../../../feature/reservation/hooks/useGetReservationLoader";
import { reservationStatus } from "../../../feature/reservation/reservation";
import CancelModal from "./components/CancelModal";

type ErrorFallbackProps = {
  message: string;
};
const ErrorFallback: React.FC<ErrorFallbackProps> = ({ message }) => (
  <AlertMessage variant="error" linkTo="/history" buttonText="予約一覧に戻る">
    {message}
  </AlertMessage>
);

type ReservationPresenterProps = {
  reservationLoader: GetReservationLoader;
};
const ReservationPresenter: React.FC<ReservationPresenterProps> = ({ reservationLoader }) => {
  const { reservation } = reservationLoader.getData();
  const { isOpen, onOpen, onClose } = useDisclosure();

  if (!reservation) {
    return <ErrorFallback message="予約が見つかりませんでした" />;
  }

  return (
    <>
      <H1>予約情報</H1>
      <ReservationSummary reservation={reservation} />
      {reservation.status === reservationStatus.APPLIED && (
        <CancelPolicyTable event={reservation.event} />
      )}
      <Stack>
        {reservation.status === reservationStatus.APPLIED && (
          <Button colorScheme="red" width="full" onClick={onOpen}>
            キャンセル
          </Button>
        )}
        <ButtonLink to="/history" width="full" colorScheme="gray" bg="gray.300">
          戻る
        </ButtonLink>
      </Stack>
      <CancelModal reservationId={reservation.id} isOpen={isOpen} onClose={onClose} />
    </>
  );
};

const Fallback: React.FC<{ reservationLoader: GetReservationLoader }> = ({ reservationLoader }) => {
  const error = reservationLoader.getError();
  let message = "通信エラーが発生しました。\n一度前の画面に戻って、再度お試しください。";
  if (error instanceof AxiosError && error.response?.data?.error) {
    message = error.response?.data?.error;
  }

  return <ErrorFallback message={message} />;
};
const Reservation: React.FC = () => {
  const { id: idStr } = useParams<{ id: string }>();
  const id = parseInt(idStr as string, 10);
  const { reservationLoader } = useGetReservationLoader({ id });

  return (
    <ErrorBoundary fallback={<Fallback reservationLoader={reservationLoader} />}>
      <Suspense>
        <ReservationPresenter reservationLoader={reservationLoader} />
      </Suspense>
    </ErrorBoundary>
  );
};

export default Reservation;
