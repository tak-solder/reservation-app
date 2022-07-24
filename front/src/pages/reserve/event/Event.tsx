import { Box, Button, Icon, Stack, useBoolean, useDisclosure } from "@chakra-ui/react";
import React, { useEffect, useState } from "react";
import { ErrorBoundary } from "react-error-boundary";
import { FormProvider, useFormContext, SubmitHandler } from "react-hook-form";
import { MdCreditCard } from "react-icons/all";
import { useParams } from "react-router-dom";

import Suspense from "../../../components/functional/Suspense";
import { H1 } from "../../../components/ui-elements/heading/Heading";
import AlertMessage from "../../../components/ui-parts/alertMessage/AlertMessage";
import AlertModal from "../../../components/ui-parts/alertModal/AlertModal";
import CancelPolicyTable from "../../../components/ui-parts/cancelPolicyTable/CancelPolicyTable";
import EventInfo from "../../../components/ui-parts/eventInfo/EventInfo";
import LocationInfo from "../../../components/ui-parts/locationInfo/LocationInfo";
import PaymentInfo from "../../../components/ui-parts/paymentInfo/PaymentInfo";
import EventClass, { applicationStatus } from "../../../feature/event/event";
import useGetEventLoader, { GetEventLoader } from "../../../feature/event/hooks/useGetEventLoader";
import { createCheckoutUrl } from "../../../feature/payment/api/paymentApi";
import { PaymentProvider, paymentProvider } from "../../../feature/payment/api/types";
import ApplyForm from "./components/ApplyForm";
import ConfirmDetail from "./components/ConfirmDetail";
import {
  convertReservationOptionValuesFromForm,
  ReservationOptionValues,
  useReservationOptionForm,
} from "./utils/reservationOptionForm";

type FormProps = {
  event: EventClass;
  onSubmit: SubmitHandler<ReservationOptionValues>;
};
const Form: React.FC<FormProps> = ({ event, onSubmit }) => (
  <Box>
    <H1>イベント概要</H1>
    <EventInfo event={event} />
    <LocationInfo location={event.location} />
    <ApplyForm event={event} onSubmit={onSubmit} />
  </Box>
);

type ConfirmProps = {
  event: EventClass;
  back: () => void;
  apply: (method: PaymentProvider) => void;
};
const Confirm: React.FC<ConfirmProps> = ({ event, back, apply }) => {
  const { getValues } = useFormContext<ReservationOptionValues>();
  const reservedOptions = convertReservationOptionValuesFromForm(getValues());

  return (
    <>
      <H1>予約確認</H1>
      <EventInfo event={event} />
      <ConfirmDetail event={event} />
      <PaymentInfo event={event} reservationOptions={reservedOptions} />
      <Box>
        <CancelPolicyTable event={event} />
        <Stack>
          <Button colorScheme="blue" onClick={() => apply(paymentProvider.STRIPE)}>
            <Icon as={MdCreditCard} pr={1} />
            クレジットカードで支払い
          </Button>
          {/*
          TODO #2 Paypay決済の追加
          <Button colorScheme="red" onClick={() => apply(paymentProvider.PAYPAY)}>
            <Icon as={MdQrCode2} pr={1} />
            PayPayで支払い
          </Button>
          */}
          <Button colorScheme="gray" onClick={back}>
            オプション選択に戻る
          </Button>
        </Stack>
      </Box>
    </>
  );
};

type ErrorFallbackProps = {
  message: string;
};
const ErrorFallback: React.FC<ErrorFallbackProps> = ({ message }) => (
  <AlertMessage variant="error" linkTo="/reservation" buttonText="イベント一覧に戻る">
    {message}
  </AlertMessage>
);

type EventPresenterProps = {
  eventLoader: GetEventLoader;
};
const EventPresenter: React.FC<EventPresenterProps> = ({ eventLoader }) => {
  const { event } = eventLoader.getData();
  const [isConfirm, setIsConfirm] = useState<boolean>(false);
  const methods = useReservationOptionForm(event);
  const [optionValues, setOptionValues] = useState<ReservationOptionValues>(methods.getValues());
  const { isOpen, onOpen, onClose } = useDisclosure();
  const [applying, { on: setApplying, off: unsetApplying }] = useBoolean(false);

  useEffect(() => {
    window.scrollTo(0, 0);
  }, [isConfirm]);

  if (!event) {
    return <ErrorFallback message="イベントが存在しません" />;
  }

  if (event.applicationStatus !== applicationStatus.AVAILABLE) {
    return <ErrorFallback message="このイベントは予約できません" />;
  }

  const onSubmit = (data: ReservationOptionValues) => {
    setOptionValues(data);
    setIsConfirm(true);
  };

  const onApply = (provider: PaymentProvider) => {
    if (applying) {
      return;
    }

    setApplying();
    (async () => {
      const { url } = await createCheckoutUrl({
        provider,
        order: { eventId: event.id, optionValues },
      }).catch(() => ({ url: undefined }));
      if (url) {
        window.location.href = url;
      } else {
        onOpen();
        unsetApplying();
      }
    })();
  };

  return (
    <FormProvider {...methods}>
      {isConfirm ? (
        <Confirm event={event} back={() => setIsConfirm(false)} apply={onApply} />
      ) : (
        <Form event={event} onSubmit={onSubmit} />
      )}
      <AlertModal variant="error" isOpen={isOpen} onClose={onClose}>
        エラーが発生しました。
        <br />
        申し込み内容をご確認の上、再度お試しください。
      </AlertModal>
    </FormProvider>
  );
};

const Event: React.FC = () => {
  const { id: idStr } = useParams<{ id: string }>();
  const id = parseInt(idStr as string, 10);
  const { eventLoader } = useGetEventLoader({ id });

  return (
    <ErrorBoundary
      fallback={
        <ErrorFallback
          message={"通信エラーが発生しました。\n一度前の画面に戻って、再度お試しください。"}
        />
      }
    >
      <Suspense>
        <EventPresenter eventLoader={eventLoader} />
      </Suspense>
    </ErrorBoundary>
  );
};
export default Event;
