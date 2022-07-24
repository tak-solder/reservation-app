import dayjs from "dayjs";

import Event from "../event";
import EventLocation from "../eventLocation/eventLocation";
import ItemOption from "../eventOption/ItemOption";
import { eventOptionCategories, EventOptions } from "../eventOption/eventOption";
import ExtraTimeOption from "../eventOption/extraTimeOption";
import { EventData } from "./types";

const eventFactory: (data: EventData) => Event = (data) => {
  const options: EventOptions = data.options.map((option) => {
    switch (option.category) {
      case eventOptionCategories.ExtraTime:
        return new ExtraTimeOption(
          option.key,
          option.category,
          option.name,
          option.description,
          option.inputType,
          option.meta
        );

      case eventOptionCategories.Item:
        return new ItemOption(
          option.key,
          option.category,
          option.name,
          option.description,
          option.inputType,
          option.meta
        );

      default:
        throw new Error("unknown option data received");
    }
  });

  const location = new EventLocation(
    data.location.locationType,
    data.location.name,
    data.location.summary,
    data.location.isPrivate,
    data.location.address || undefined,
    data.location.url || undefined
  );

  return new Event(
    data.id,
    data.title,
    data.description,
    dayjs(data.startDate).locale("ja"),
    dayjs(data.endDate).locale("ja"),
    location,
    data.status,
    data.capacity,
    data.remain,
    data.cost,
    options,
    data.applicationStatus || undefined
  );
};
export default eventFactory;
