import { Dayjs } from "dayjs";

import Event, { EventStatus, ApplicationStatus } from "../event";
import { LocationType } from "../eventLocation/eventLocation";
import {
  EventOptionCategory,
  EventOptionInputType,
  EventOptionKey,
} from "../eventOption/eventOption";

type EventOptionData = {
  key: EventOptionKey;
  name: string;
  category: EventOptionCategory;
  description: string;
  inputType: EventOptionInputType;
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  meta: any;
};

type EventLocationData = {
  locationType: LocationType;
  name: string;
  summary: string;
  isPrivate: boolean;
  address: string;
  url: string | null;
};

export type EventData = {
  id: number;
  title: string;
  description: string;
  startDate: Dayjs;
  endDate: Dayjs;
  location: EventLocationData;
  status: EventStatus;
  capacity: number;
  remain: number;
  cost: number;
  options: EventOptionData[];
  applicationStatus?: ApplicationStatus;
};

export type GetEventsRequest = {
  fromDate?: Dayjs;
  toDate?: Dayjs;
};
export type GetEventsResponse = {
  events: Event[];
};
export type GetEvents = (params: GetEventsRequest) => Promise<GetEventsResponse>;

export type GetEventRequest = {
  id: number;
};
export type GetEventResponse = {
  event: Event | undefined;
};
export type GetEvent = (params: GetEventRequest) => Promise<GetEventResponse>;
