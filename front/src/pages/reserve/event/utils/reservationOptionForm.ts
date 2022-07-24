import { yupResolver } from "@hookform/resolvers/yup/dist/yup";
import { useForm } from "react-hook-form";
import * as yup from "yup";

import Event from "../../../../feature/event/event";
import { EventOptionKey, eventOptionKeys } from "../../../../feature/event/eventOption/eventOption";
import { ReservationOptions } from "../../../../feature/reservation/reservationOption";

export const defaultReservationOptionValue = {
  [eventOptionKeys.MusicStand]: false,
  [eventOptionKeys.DuetChair]: false,
  [eventOptionKeys.Mic]: false,
  [eventOptionKeys.MicStand]: false,
  [eventOptionKeys.VideoData]: false,
  [eventOptionKeys.ExtraTime]: 0,
} as const;

const reservationOptionSchema = yup
  .object({
    [eventOptionKeys.MusicStand]: yup.boolean(),
    [eventOptionKeys.DuetChair]: yup.boolean(),
    [eventOptionKeys.Mic]: yup.boolean(),
    [eventOptionKeys.MicStand]: yup.boolean(),
    [eventOptionKeys.VideoData]: yup.boolean(),
    [eventOptionKeys.ExtraTime]: yup.number().integer(),
  })
  .required();

export type ReservationOptionValues = Record<EventOptionKey, number | boolean>;

export const useReservationOptionForm = (event: Event | undefined) => {
  const defaultValues = {} as ReservationOptionValues;
  event?.options.forEach(({ key }) => {
    defaultValues[key] = defaultReservationOptionValue[key];
  });

  return useForm<ReservationOptionValues>({
    resolver: yupResolver(reservationOptionSchema),
    defaultValues,
  });
};

export const convertReservationOptionValuesFromForm: (
  formData: ReservationOptionValues
) => ReservationOptions = (formData) => {
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  const result: any = {};
  Object.entries<number | boolean>(formData).forEach(([k, value]) => {
    const key = k as EventOptionKey;
    result[key] = { key, value };
  });

  return result;
};
