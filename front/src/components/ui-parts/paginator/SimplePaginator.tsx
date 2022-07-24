import { Box, Center, Flex, Icon, Spacer } from "@chakra-ui/react";
import React from "react";
import { MdOutlineChevronLeft, MdOutlineChevronRight } from "react-icons/all";

type PaginatorItemProps = {
  onClick?: () => void;
  active?: boolean;
  children: React.ReactNode;
};
const PaginatorItem: React.FC<PaginatorItemProps> = ({
  onClick = undefined,
  active = false,
  children,
}) => {
  const props = { w: "32px", h: "32px", borderRadius: 3 };
  if (active) {
    return (
      <Center {...props} bg="blue.500" color="white">
        {children}
      </Center>
    );
  }

  return (
    <Center
      {...props}
      as="button"
      color="blue.500"
      border="1px"
      borderColor="blue.500"
      onClick={onClick}
    >
      {children}
    </Center>
  );
};

type PrevProps = {
  toPrevPage: () => void;
  hasLess?: boolean;
};
const Prev: React.FC<PrevProps> = ({ toPrevPage, hasLess }) => {
  if (!hasLess) {
    return <Box />;
  }

  return (
    <PaginatorItem onClick={toPrevPage}>
      <Icon as={MdOutlineChevronLeft} w="20px" h="20px" />
    </PaginatorItem>
  );
};

type NextProps = {
  toNextPage: () => void;
  hasMore?: boolean;
};
const Next: React.FC<NextProps> = ({ toNextPage, hasMore }) => {
  if (!hasMore) {
    return <Box />;
  }

  return (
    <PaginatorItem onClick={toNextPage}>
      <Icon as={MdOutlineChevronRight} w="20px" h="20px" />
    </PaginatorItem>
  );
};

type SimplePaginatorProps = {
  currentPage: number;
  setPage: (page: number) => void;
  hasMore: boolean;
};
const SimplePaginator: React.FC<SimplePaginatorProps> = ({ currentPage, setPage, hasMore }) => {
  const toPrevPage = () => setPage(currentPage - 1);
  const toNextPage = () => setPage(currentPage + 1);

  return (
    <Flex>
      <Prev toPrevPage={toPrevPage} hasLess={currentPage > 1} />
      <Spacer />
      <PaginatorItem active>{currentPage}</PaginatorItem>
      <Spacer />
      <Next toNextPage={toNextPage} hasMore={hasMore} />
    </Flex>
  );
};
export default SimplePaginator;
