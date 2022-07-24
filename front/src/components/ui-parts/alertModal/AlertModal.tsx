import {
  Modal,
  ModalBody,
  ModalCloseButton,
  ModalContent,
  ModalHeader,
  ModalOverlay,
} from "@chakra-ui/react";
import React from "react";

import { AlertVariant, alertVariants } from "../../../constants/alertVariants";

type AlertProps = {
  variant: AlertVariant;
  isOpen: boolean;
  onClose: () => void;
  children: React.ReactNode;
};

const AlertModal: React.FC<AlertProps> = ({ variant, isOpen, onClose, children }) => {
  const scheme = alertVariants[variant];

  return (
    <Modal isOpen={isOpen} onClose={onClose}>
      <ModalOverlay />
      <ModalContent borderTop="10px" borderColor={scheme.accentColor} borderStyle="solid" mx={2}>
        <ModalHeader px={3} py={2} fontSize="sm">
          {scheme.label}
        </ModalHeader>
        <ModalCloseButton size="sm" />
        <ModalBody>{children}</ModalBody>
      </ModalContent>
    </Modal>
  );
};
export default AlertModal;
