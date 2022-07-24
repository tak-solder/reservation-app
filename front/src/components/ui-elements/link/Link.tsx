import { Link as ChakraLink, LinkProps as ChakraProps } from "@chakra-ui/react";
import React from "react";
import { Link as RouterLink, LinkProps as RouterProps } from "react-router-dom";

const Link: React.FC<ChakraProps & RouterProps> = (props) => (
  <ChakraLink as={RouterLink} {...props} />
);
export default Link;
