import {
  Accordion,
  AccordionButton,
  AccordionIcon,
  AccordionItem,
  AccordionPanel,
  Box,
  Link,
} from "@chakra-ui/react";
import React from "react";

import EventLocation, { locationType } from "../../../feature/event/eventLocation/eventLocation";
import { H2 } from "../../ui-elements/heading/Heading";

const RealLocationInfo: React.FC<LocationInfoProps> = ({ location }) => {
  const mapSrc = `https://maps.google.co.jp/maps?q=${location.address}&output=embed&t=m&z=14&hl=ja`;

  return (
    <Box mb={3}>
      <H2>会場アクセス</H2>
      <Box>
        {location.url ? (
          <Link href={location.url} target="_blank" color="blue" textDecoration="underline">
            {location.name}
          </Link>
        ) : (
          location.name
        )}
      </Box>
      <Box>{location.address}</Box>
      <Box fontSize="sm" whiteSpace="pre-wrap" mb={2}>
        {location.summary}
      </Box>
      <Accordion allowToggle mb={4}>
        <AccordionItem borderBottom="none">
          <AccordionButton bg="gray.100">
            <Box flex="1" textAlign="left">
              地図を確認
            </Box>
            <AccordionIcon />
          </AccordionButton>
          <AccordionPanel py={2} px={3}>
            <iframe
              title="会場地図"
              src={mapSrc}
              style={{
                width: "100%",
                height: "350px",
              }}
            />
          </AccordionPanel>
        </AccordionItem>
      </Accordion>
    </Box>
  );
};

const OnlineLocationInfo: React.FC<LocationInfoProps> = ({ location }) => {
  if (location.address) {
    return (
      <Box mb={3}>
        <H2>参加方法</H2>
        <Box>開始時間に下記URLからZoomを開始してください。</Box>
        <Box fontSize="sm" color="gray.800">
          {location.summary}
        </Box>
        <Box>
          <Link href={location.address} target="_blank" color="blue" textDecoration="underline">
            {location.address}
          </Link>
        </Box>
      </Box>
    );
  }

  return (
    <Box mb={3}>
      <H2>参加方法</H2>
      <Box>お申し込み後、参加に必要なZoomのURLをご連絡いたします。</Box>
      <Box fontSize="sm" color="gray.800">
        {location.summary}
      </Box>
    </Box>
  );
};

type LocationInfoProps = {
  location: EventLocation;
};
const LocationInfo: React.FC<LocationInfoProps> = ({ location }) => {
  switch (location.locationType) {
    case locationType.REAL:
      return <RealLocationInfo location={location} />;

    case locationType.ONLINE:
      return <OnlineLocationInfo location={location} />;

    default:
      throw new Error("不明なロケーション");
  }
};

export default LocationInfo;
