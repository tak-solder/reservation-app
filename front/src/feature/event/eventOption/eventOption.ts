import ItemOption from "./ItemOption";
import ExtraTimeOption from "./extraTimeOption";

export const eventOptionKeys = {
  ExtraTime: "extraTime",
  MusicStand: "musicStand",
  DuetChair: "duetChair",
  Mic: "mic",
  MicStand: "micStand",
  VideoData: "videoData",
} as const;
export type EventOptionKey = typeof eventOptionKeys[keyof typeof eventOptionKeys];

export const eventOptionCategories = {
  ExtraTime: "extraTime",
  Item: "item",
} as const;
export type EventOptionCategory = typeof eventOptionCategories[keyof typeof eventOptionCategories];

export const eventOptionInputType = {
  QUANTITY: 1,
} as const;
export type EventOptionInputType = typeof eventOptionInputType[keyof typeof eventOptionInputType];

export interface EventOptionInterface<T> {
  readonly key: EventOptionKey;
  readonly category: EventOptionCategory;
  readonly name: string;
  readonly description: string;
  readonly inputType: EventOptionInputType;
  readonly meta: T;
}

export type EventOption = ExtraTimeOption | ItemOption;

export type EventOptions = EventOption[];
