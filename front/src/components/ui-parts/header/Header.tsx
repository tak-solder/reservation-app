import {
  Link as ChakraLink,
  Avatar,
  Flex,
  Img,
  Menu,
  MenuButton,
  MenuItem,
  MenuList,
  Spacer,
} from "@chakra-ui/react";
import React from "react";

import LogoImg from "../../../../assets/logo.png";
import useLoginUser from "../../../feature/user/hooks/useLoginUser";
import Link from "../../ui-elements/link/Link";

const Header: React.FC = () => {
  const user = useLoginUser();

  return (
    <Flex as="header" width="full" shadow="sm" px={4} py={2} bg="gray.100">
      <Link to="/">
        <Img src={LogoImg} alt="tak's Salon" height="48px" />
      </Link>
      <Spacer />
      <Menu isLazy>
        <MenuButton>{user ? <Avatar name={user.lineName} /> : <Avatar />}</MenuButton>
        <MenuList>
          {user?.id !== 1 && (
            <MenuItem>
              <ChakraLink href={`${import.meta.env.VITE_API_URL}/user/switch?userId=1`}>
                ユーザー1に切り替え
              </ChakraLink>
            </MenuItem>
          )}
          {user?.id !== 2 && (
            <MenuItem>
              <ChakraLink href={`${import.meta.env.VITE_API_URL}/user/switch?userId=2`}>
                ユーザー2に切り替え
              </ChakraLink>
            </MenuItem>
          )}
          {user && (
            <MenuItem>
              <ChakraLink href={`${import.meta.env.VITE_API_URL}/user/switch?userId=0`}>
                ゲストに切り替え
              </ChakraLink>
            </MenuItem>
          )}
        </MenuList>
      </Menu>
    </Flex>
  );
};

export default Header;
