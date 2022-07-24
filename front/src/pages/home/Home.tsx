import { Box, Img, Stack } from "@chakra-ui/react";
import React from "react";

import topImg from "../../../assets/top.png";
import ButtonLink from "../../components/ui-elements/link/ButtonLink";

const Home: React.FC = () => (
  <>
    <Box pb={4}>
      <Img src={topImg} alt="tak's Salon" />
    </Box>
    <Stack>
      <ButtonLink to="/reservation" colorScheme="blue" width="full" mb={4}>
        予約にすすむ
      </ButtonLink>
      <ButtonLink to="/history" colorScheme="blue" width="full" mb={4}>
        予約確認
      </ButtonLink>
    </Stack>
  </>
);

export default Home;
