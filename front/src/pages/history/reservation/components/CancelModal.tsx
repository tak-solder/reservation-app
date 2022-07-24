import {
  Box,
  Button,
  Modal,
  ModalBody,
  ModalCloseButton,
  ModalContent,
  ModalFooter,
  ModalHeader,
  ModalOverlay,
  Table,
  TableContainer,
  Tbody,
  Td,
  Th,
  Tr,
} from "@chakra-ui/react";
import React, { useEffect, useState } from "react";
import { ErrorBoundary } from "react-error-boundary";
import { useNavigate } from "react-router-dom";

import Loading from "../../../../components/ui-elements/loading/Loading";
import AlertModal from "../../../../components/ui-parts/alertModal/AlertModal";
import makeConfirmCancelLoader, {
  ConfirmCancelLoader,
} from "../../../../feature/reservation/utils/makeConfirmCancelLoader";
import makeExecuteCancelLoader, {
  ExecuteCancelLoader,
} from "../../../../feature/reservation/utils/makeExecuteCancelLoader";
import { numberFormat } from "../../../../utils/formatter";

type ConfirmModalProps = {
  cancelQuotationLoader: ConfirmCancelLoader;
  onClose: () => void;
  onSubmitCancel: () => void;
};
const ConfirmModal: React.FC<ConfirmModalProps> = ({
  cancelQuotationLoader,
  onClose,
  onSubmitCancel,
}) => {
  const { quotation } = cancelQuotationLoader.getData();
  return (
    <Modal isOpen onClose={onClose}>
      <ModalOverlay />
      <ModalContent borderTop="10px" borderColor="red.400" borderStyle="solid" mx={2}>
        <ModalHeader>キャンセル確認</ModalHeader>
        <ModalCloseButton />
        <ModalBody>
          <Box fontSize="sm">
            キャンセルには所定のキャンセル料金が掛かります。
            <br />
            キャンセルしてもよろしいでしょうか？
          </Box>
          <TableContainer mb={4}>
            <Table size="sm">
              <Tbody>
                <Tr>
                  <Th>支払済の金額</Th>
                  <Td>{numberFormat(quotation.paidAmount)}円</Td>
                </Tr>
                <Tr>
                  <Th>キャンセル手数料</Th>
                  <Td>
                    {numberFormat(quotation.cancelCharge)}
                    円（
                    {quotation.cancelRate}
                    %）
                  </Td>
                </Tr>
                <Tr>
                  <Th>返金額</Th>
                  <Td>{numberFormat(quotation.cancelRefund)}円</Td>
                </Tr>
              </Tbody>
            </Table>
          </TableContainer>
        </ModalBody>
        <ModalFooter>
          <Button colorScheme="gray" mr={3} onClick={onClose}>
            キャンセルしない
          </Button>
          <Button colorScheme="red" onClick={onSubmitCancel}>
            キャンセル実行
          </Button>
        </ModalFooter>
      </ModalContent>
    </Modal>
  );
};

type CanceledModalProps = {
  cancelQuotationLoader: ExecuteCancelLoader;
};
const CanceledModal: React.FC<CanceledModalProps> = ({ cancelQuotationLoader }) => {
  const navigate = useNavigate();
  cancelQuotationLoader.getData();

  const onClick = () => {
    navigate("/history");
  };

  return (
    <Modal isOpen onClose={() => undefined}>
      <ModalOverlay />
      <ModalContent borderTop="10px" borderColor="red.400" borderStyle="solid" mx={2}>
        <ModalHeader>キャンセル完了</ModalHeader>
        <ModalBody>
          <Box>キャンセルしました。</Box>
        </ModalBody>
        <ModalFooter>
          <Button colorScheme="blue" onClick={onClick}>
            予約一覧に戻る
          </Button>
        </ModalFooter>
      </ModalContent>
    </Modal>
  );
};

type CancelModalProps = {
  reservationId: number;
  isOpen: boolean;
  onClose: () => void;
};
const CancelModal: React.FC<CancelModalProps> = ({
  reservationId,
  isOpen,
  onClose: handleClose,
}) => {
  const [confirmQuotationLoader, setConfirmQuotationLoader] = useState<
    undefined | ConfirmCancelLoader
  >(undefined);
  const [executeQuotationLoader, setExecuteQuotationLoader] = useState<
    undefined | ExecuteCancelLoader
  >(undefined);

  useEffect(() => {
    if (isOpen && confirmQuotationLoader === undefined) {
      setConfirmQuotationLoader(makeConfirmCancelLoader({ reservationId }));
    }
  }, [isOpen, confirmQuotationLoader, reservationId]);

  if (!isOpen || confirmQuotationLoader === undefined) {
    return null;
  }

  const onClose = () => {
    setConfirmQuotationLoader(undefined);
    handleClose();
  };

  const onCancelSubmit = () => {
    const {
      quotation: { cancelRate },
    } = confirmQuotationLoader.getData();
    setExecuteQuotationLoader(makeExecuteCancelLoader({ reservationId, cancelRate }));
  };

  return (
    <ErrorBoundary
      fallback={
        <AlertModal variant="error" isOpen onClose={onClose}>
          エラーが発生しました。
          <br />
          もう一度キャンセルをお試しください。
        </AlertModal>
      }
    >
      <React.Suspense
        fallback={
          <Modal isOpen onClose={() => undefined}>
            <ModalOverlay />
            <ModalContent borderTop="10px" borderColor="red.400" borderStyle="solid" mx={2}>
              <ModalHeader>キャンセル確認</ModalHeader>
              <ModalBody>
                <Loading />
              </ModalBody>
            </ModalContent>
          </Modal>
        }
      >
        {executeQuotationLoader ? (
          <CanceledModal cancelQuotationLoader={executeQuotationLoader} />
        ) : (
          <ConfirmModal
            cancelQuotationLoader={confirmQuotationLoader}
            onClose={onClose}
            onSubmitCancel={onCancelSubmit}
          />
        )}
      </React.Suspense>
    </ErrorBoundary>
  );
};

export default CancelModal;
