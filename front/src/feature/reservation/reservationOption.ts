import { EventOptionKey } from "../event/eventOption/eventOption";

export type ReservationOption = {
  key: EventOptionKey;
  value: string | number | boolean;
};
export type ReservationOptions = Record<EventOptionKey, ReservationOption>;
