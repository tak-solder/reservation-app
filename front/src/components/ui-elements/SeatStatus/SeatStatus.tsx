import { Center, Icon } from "@chakra-ui/react";
import React from "react";
import {
  MdChangeHistory,
  MdClear,
  MdOutlineCheck,
  MdOutlineCircle,
  MdOutlineHorizontalRule,
} from "react-icons/md";

import { seatStatus, SeatStatusValue } from "../../../constants/seatStatus";

type SeatStatusProps = {
  status: SeatStatusValue;
};

const SeatStatus: React.FC<SeatStatusProps> = ({ status }) => {
  const props = { w: "48px", h: "48px", borderRadius: 3 };
  if (status === seatStatus.AVAILABLE) {
    return (
      <Center {...props} bg="blue.500">
        <Icon as={MdOutlineCircle} w="36px" h="36px" color="white" />
      </Center>
    );
  }
  if (status === seatStatus.LIMITED) {
    return (
      <Center {...props} bg="orange.500">
        <Icon as={MdChangeHistory} w="36px" h="36px" color="white" />
      </Center>
    );
  }
  if (status === seatStatus.FULFILL) {
    return (
      <Center bg="red.500" {...props}>
        <Icon as={MdClear} w="40px" h="40px" color="white" />
      </Center>
    );
  }
  if (status === seatStatus.RESERVED) {
    return (
      <Center bg="green.500" {...props}>
        <Icon as={MdOutlineCheck} w="32px" h="32px" color="white" />
      </Center>
    );
  }
  return (
    <Center bg="gray.200" {...props}>
      <Icon as={MdOutlineHorizontalRule} w="32px" h="32px" color="gray" />
    </Center>
  );
};

export default SeatStatus;
