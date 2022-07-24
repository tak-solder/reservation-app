import { Box } from "@chakra-ui/react";
import React from "react";
import { ErrorBoundary } from "react-error-boundary";

import Suspense from "../../../components/functional/Suspense";
import { H1 } from "../../../components/ui-elements/heading/Heading";
import ButtonLink from "../../../components/ui-elements/link/ButtonLink";
import AlertMessage from "../../../components/ui-parts/alertMessage/AlertMessage";
import ReservationSummary from "../../../components/ui-parts/reservationSummary/ReservationSummary";
import makeCompletePaymentLoader, {
  CompletePaymentLoader,
} from "../../../feature/payment/utils/makeCompletePaymentLoader";

type CompleteViewProps = {
  completePaymentLoader: CompletePaymentLoader;
};
const CompletePresenter: React.FC<CompleteViewProps> = ({ completePaymentLoader }) => {
  const { reservation } = completePaymentLoader.getData();

  if (!reservation) {
    return (
      <AlertMessage variant="error" linkTo="/" buttonText="トップに戻る">
        不正な画面遷移です。
      </AlertMessage>
    );
  }

  return (
    <Box>
      <H1>予約完了</H1>
      <ReservationSummary reservation={reservation} />
      <Box mb={3}>
        <ButtonLink to="/history" width="full" colorScheme="blue">
          予約一覧へ
        </ButtonLink>
      </Box>
      {/*
       TODO #1 LINE組み込み時に実装
      <Box mb={3}>
        <Button width="full" colorScheme="gray" bg="gray.200" onClick={handleClick}>
          LINEに戻る
        </Button>
      </Box>
      */}
    </Box>
  );
};

const Fallback: React.FC = () => (
  <AlertMessage variant="error" linkTo="/history" buttonText="予約一覧">
    通信エラーが発生しました。 申込は完了している場合もございますので、予約一覧をご確認ください。
  </AlertMessage>
);

const Complete: React.FC = () => {
  const completePaymentLoader = makeCompletePaymentLoader();

  return (
    <ErrorBoundary fallback={<Fallback />}>
      <Suspense>
        <CompletePresenter completePaymentLoader={completePaymentLoader} />
      </Suspense>
    </ErrorBoundary>
  );
};

export default Complete;
