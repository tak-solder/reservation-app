import { Alert, Box, Stack } from "@chakra-ui/react";
import { ThemeTypings } from "@chakra-ui/styled-system";
import React, { MouseEventHandler } from "react";

import { AlertVariant } from "../../../constants/alertVariants";
import ButtonLink from "../../ui-elements/link/ButtonLink";

type AlertMessageProps = {
  variant: AlertVariant;
  children: React.ReactNode;
  linkTo?: string;
  buttonText?: string;
  onButtonClick?: MouseEventHandler<HTMLElement>;
  buttonScheme?: ThemeTypings["colorSchemes"];
};

const AlertMessage: React.FC<AlertMessageProps> = ({
  variant,
  children,
  linkTo = undefined,
  buttonText = "戻る",
  onButtonClick = undefined,
  buttonScheme = "gray",
}) => (
  <>
    <Alert status={variant} variant="left-accent" mb={4}>
      {typeof children === "string" ? <Box whiteSpace="pre-wrap">{children}</Box> : children}
    </Alert>
    {(linkTo || onButtonClick) && (
      <Stack mt={6}>
        <ButtonLink to={linkTo || "#"} colorScheme={buttonScheme} mb={4} onClick={onButtonClick}>
          {buttonText}
        </ButtonLink>
      </Stack>
    )}
  </>
);
export default AlertMessage;
