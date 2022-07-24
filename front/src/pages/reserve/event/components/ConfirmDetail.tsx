import { Box, ListItem, Text, UnorderedList } from "@chakra-ui/react";
import React from "react";
import { useFormContext } from "react-hook-form";

import { H2, H3 } from "../../../../components/ui-elements/heading/Heading";
import EventClass from "../../../../feature/event/event";
import ItemOption from "../../../../feature/event/eventOption/ItemOption";
import ExtraTimeOption from "../../../../feature/event/eventOption/extraTimeOption";
import { numberFormat } from "../../../../utils/formatter";
import { ReservationOptionValues } from "../utils/reservationOptionForm";

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

type ItemOptionConfirmProps = {
  options: ItemOption[];
};
const ItemOptionConfirm: React.FC<ItemOptionConfirmProps> = ({ options }) => {
  const { getValues } = useFormContext<ReservationOptionValues>();
  const applyOptions = options.filter((option) => getValues(option.key) === true);
  if (!applyOptions.length) {
    return null;
  }

  return (
    <Box mb={3}>
      <H3>参加オプション</H3>
      <UnorderedList ml={8}>
        {applyOptions.map((option) => (
          <ItemOptionItem key={option.key} option={option} />
        ))}
      </UnorderedList>
    </Box>
  );
};

type ExtraTimeOptionConfirmProps = {
  option: ExtraTimeOption;
};
const ExtraTimeOptionConfirm: React.FC<ExtraTimeOptionConfirmProps> = ({ option }) => {
  const { getValues } = useFormContext();
  const quantity = getValues(option.key);

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

type ConfirmDetailProps = {
  event: EventClass;
};
const ConfirmDetail: React.FC<ConfirmDetailProps> = ({ event }) => {
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
      <H2>オプション確認</H2>
      {itemOptions.length && <ItemOptionConfirm options={itemOptions} />}
      {extraTimeOption && <ExtraTimeOptionConfirm option={extraTimeOption} />}
    </Box>
  );
};
export default ConfirmDetail;
