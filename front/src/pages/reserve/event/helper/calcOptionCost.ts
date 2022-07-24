import EventClass from "../../../../feature/event/event";
import {
  EventOption,
  eventOptionInputType,
} from "../../../../feature/event/eventOption/eventOption";
import { ReservationOptionValues } from "../utils/reservationOptionForm";

type CalcOptionCost = (event: EventClass, options: ReservationOptionValues) => number;
const calcOptionCost: CalcOptionCost = (event, options) =>
  event.options.reduce((sum: number, eventOption: EventOption) => {
    const value = options[eventOption.key];
    if (value === undefined) {
      return sum;
    }

    switch (eventOption.inputType) {
      case eventOptionInputType.QUANTITY:
        return (value as number) * eventOption.meta.cost + sum;

      default:
        throw Error(`不明なInputType: ${eventOption.inputType}`);
    }
  }, 0);

export default calcOptionCost;
