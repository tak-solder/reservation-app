import { Box, ListItem, Text, UnorderedList } from "@chakra-ui/react";
import React from "react";

import ItemOption from "../../../../feature/event/eventOption/ItemOption";
import ExtraTimeOption from "../../../../feature/event/eventOption/extraTimeOption";
import Reservation from "../../../../feature/reservation/reservation";
import { ReservationOptions } from "../../../../feature/reservation/reservationOption";
import { numberFormat } from "../../../../utils/formatter";
import { H2, H3 } from "../../../ui-elements/heading/Heading";

type ItemOptionItemProps = {
  option: ItemOption;
};
const ItemOptionItem: React.FC<ItemOptionItemProps> = ({ option }) => (
  <ListItem>
    {option.name}
    <Text as="span" display="inline-block" pl={1} color="red.400" fontSize="sm">
      (+{numberFormat(option.meta.cost)}円)
    </Text>
  </ListItem>
);

type ItemOptionInfoProps = {
  reservationOptions: ReservationOptions;
  options: ItemOption[];
};
const ItemOptionInfo: React.FC<ItemOptionInfoProps> = ({ reservationOptions, options }) => {
  const applyOptions = options.filter(({ key }) => reservationOptions[key]?.value === true);

  return (
    <Box mb={3}>
      <H3>参加オプション</H3>
      {applyOptions.length ? (
        <UnorderedList ml={8}>
          {applyOptions.map((option) => (
            <ItemOptionItem key={option.key} option={option} />
          ))}
        </UnorderedList>
      ) : (
        <Box ml={3}>オプションなし</Box>
      )}
    </Box>
  );
};

type ExtraTimeOptionInfoProps = {
  reservationOptions: ReservationOptions;
  option: ExtraTimeOption;
};
const ExtraTimeOptionInfo: React.FC<ExtraTimeOptionInfoProps> = ({
  reservationOptions,
  option,
}) => {
  const value = reservationOptions[option.key]?.value;
  const quantity = Number.isInteger(value) ? (value as number) : 0;

  return (
    <Box mb={3}>
      <H3>{option.name}</H3>
      <Box ml={3}>
        {quantity === 0 ? (
          "延長なし"
        ) : (
          <>
            {option.meta.minutes * quantity}分延長
            <Text as="span" display="inline-block" pl={1} color="red.400" fontSize="sm">
              (+{numberFormat(option.meta.cost * quantity)}円)
            </Text>
          </>
        )}
      </Box>
    </Box>
  );
};

type ReservationOptionInfoProps = {
  reservation: Reservation;
};
const ReservationOptionInfo: React.FC<ReservationOptionInfoProps> = ({ reservation }) => {
  const { event } = reservation;
  if (!event.options.length) {
    return null;
  }

  const itemOptions = event.options.filter(
    (option) => option instanceof ItemOption
  ) as ItemOption[];
  const extraTimeOption = event.options.find(
    (option) => option instanceof ExtraTimeOption
  ) as ExtraTimeOption | null;

  return (
    <Box mb={4}>
      <H2>申し込みオプション</H2>
      {itemOptions.length && (
        <ItemOptionInfo reservationOptions={reservation.options} options={itemOptions} />
      )}
      {extraTimeOption && (
        <ExtraTimeOptionInfo reservationOptions={reservation.options} option={extraTimeOption} />
      )}
    </Box>
  );
};
export default ReservationOptionInfo;
