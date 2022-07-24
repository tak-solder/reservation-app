import { Center, Spinner } from "@chakra-ui/react";
import React from "react";

const Loading: React.FC = () => (
  <Center width="100%" mt={4}>
    <Spinner size="xl" speed="0.5s" color="blue.500" />
  </Center>
);

export default Loading;
