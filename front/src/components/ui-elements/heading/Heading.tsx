import { Heading } from "@chakra-ui/react";
import React from "react";

type HeadingProps = {
  children: React.ReactElement | string;
};

export const H1: React.FC<HeadingProps> = ({ children }) => (
  <Heading fontSize={24} mb={3}>
    {children}
  </Heading>
);

export const H2: React.FC<HeadingProps> = ({ children }) => (
  <Heading fontSize={18} mb={2}>
    {children}
  </Heading>
);

export const H3: React.FC<HeadingProps> = ({ children }) => (
  <Heading fontSize={16} mb={1}>
    {children}
  </Heading>
);
