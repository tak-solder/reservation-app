import { Button, ButtonProps } from "@chakra-ui/react";
import React from "react";
import { Link as RouterLink, LinkProps as RouterProps } from "react-router-dom";

const ButtonLink: React.FC<ButtonProps & RouterProps> = (props) => (
  <Button as={RouterLink} {...props} />
);
export default ButtonLink;
