import { Box } from "@chakra-ui/react";
import React from "react";

import Header from "../header/Header";

type LayoutProps = {
  children: React.ReactElement;
};
const Layout: React.FC<LayoutProps> = ({ children }) => (
  <Box maxW="480px" minH="100vh" marginX="auto" bg="white">
    <Header />
    <Box px={4} py={4}>
      {children}
    </Box>
  </Box>
);

export default Layout;
