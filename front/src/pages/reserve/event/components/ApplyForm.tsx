import {
  Box,
  Button,
  Checkbox,
  Radio,
  RadioGroup,
  Stack,
  Table,
  TableContainer,
  Tbody,
  Td,
  Text,
  Th,
  Tr,
} from "@chakra-ui/react";
import React from "react";
import { SubmitHandler, useFormContext } from "react-hook-form";

import { H2, H3 } from "../../../../components/ui-elements/heading/Heading";
import ButtonLink from "../../../../components/ui-elements/link/ButtonLink";
import EventClass from "../../../../feature/event/event";
import ItemOption from "../../../../feature/event/eventOption/ItemOption";
import { eventOptionKeys } from "../../../../feature/event/eventOption/eventOption";
import ExtraTimeOption from "../../../../feature/event/eventOption/extraTimeOption";
import { numberFormat } from "../../../../utils/formatter";
import { ReservationOptionValues } from "../utils/reservationOptionForm";

type ItemOptionFormRowProps = {
  option: ItemOption;
};
const ItemOptionFormRow: React.FC<ItemOptionFormRowProps> = ({ option }) => {
  const { register } = useFormContext();
  return (
    <Tr>
      <Th width="40%" px={2} py={3}>
        {option.name}
      </Th>
      <Td width="60%" px={1} py={3}>
        {option.meta.quantity ? (
          <Checkbox size="sm" {...register(option.key)}>
            利用する
            <Text as="span" display="inline-block" pl={1} color="red.400" fontSize="sm">
              (+{numberFormat(option.meta.cost)}円)
            </Text>
          </Checkbox>
        ) : (
          <Text as="span" fontSize="sm" color="gray.700">
            このオプションは売り切れました
          </Text>
        )}
      </Td>
    </Tr>
  );
};

type ItemOptionFormProps = {
  options: ItemOption[];
};
const ItemOptionForm: React.FC<ItemOptionFormProps> = ({ options }) => {
  if (!options.length) {
    return (
      <Box mb={3}>
        <H3>参加オプション</H3>
        <Box fontSize="sm" color="gray.800">
          選択可能なオプションはありません。
        </Box>
      </Box>
    );
  }

  return (
    <Box mb={3}>
      <H3>参加オプション選択</H3>
      <Table>
        <Tbody>
          {options.map((option) => (
            <ItemOptionFormRow key={option.key} option={option} />
          ))}
        </Tbody>
      </Table>
    </Box>
  );
};

type ExtraTimeOptionProps = {
  option: ExtraTimeOption;
};
const ExtraTimeOptionForm: React.FC<ExtraTimeOptionProps> = ({ option }) => {
  const { register } = useFormContext();

  return (
    <Box mb={4}>
      <H3>{option.name}</H3>
      <Text fontSize="smaller" mb={2}>
        {option.description}
      </Text>
      <RadioGroup defaultValue="0" mb={3}>
        <Stack>
          {(() => {
            const elems = [];
            for (let i = 0; i <= option.meta.quantity; i += 1) {
              elems.push(
                <Radio key={i} value={i.toString()} {...register(eventOptionKeys.ExtraTime)}>
                  {i === 0 ? "延長なし" : `${option.meta.minutes * i}分延長`}
                  <Text as="span" display="inline-block" pl={1} color="red.400" fontSize="sm">
                    (+
                    {numberFormat(option.meta.cost * i)}
                    円)
                  </Text>
                </Radio>
              );
            }
            return elems;
          })()}
        </Stack>
      </RadioGroup>
    </Box>
  );
};

type ApplyFormProps = {
  event: EventClass;
  onSubmit: SubmitHandler<ReservationOptionValues>;
};
const ApplyForm: React.FC<ApplyFormProps> = ({ event, onSubmit }) => {
  const { handleSubmit } = useFormContext<ReservationOptionValues>();

  const itemOptions = event.options.filter(
    (option) => option instanceof ItemOption
  ) as ItemOption[];
  const extraTimeOption = event.options.find(
    (option) => option instanceof ExtraTimeOption
  ) as ExtraTimeOption | null;

  return (
    <Box>
      <H2>イベント申し込み</H2>
      <form onSubmit={handleSubmit(onSubmit)}>
        <TableContainer mb={4}>
          <Table size="sm">
            <Tbody>
              <Tr>
                <Th>参加料金</Th>
                <Td>{numberFormat(event.cost)}円</Td>
              </Tr>
            </Tbody>
          </Table>
        </TableContainer>
        <ItemOptionForm options={itemOptions} />
        {extraTimeOption && <ExtraTimeOptionForm option={extraTimeOption} />}
        <Stack mt={6}>
          <Button type="submit" colorScheme="blue" mb={2}>
            申し込み内容の確認
          </Button>
          <ButtonLink to="/reservation" colorScheme="gray" mb={4}>
            イベント一覧に戻る
          </ButtonLink>
        </Stack>
      </form>
    </Box>
  );
};
export default ApplyForm;
