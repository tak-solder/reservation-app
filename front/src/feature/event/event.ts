import { Dayjs } from "dayjs";

import { seatStatus } from "../../constants/seatStatus";
import EventLocation from "./eventLocation/eventLocation";
import { EventOptions } from "./eventOption/eventOption";

export const eventStatus = {
  CANCELED: 0,
  SCHEDULED: 1,
  FINISHED: 2,
  SUSPEND: 3,
} as const;
export type EventStatus = typeof eventStatus[keyof typeof eventStatus];

export const applicationStatus = {
  UNAVAILABLE: 0,
  AVAILABLE: 1,
  APPLIED: 2,
  // WAITING: 3,
} as const;
export type ApplicationStatus = typeof applicationStatus[keyof typeof applicationStatus];

class Event {
  constructor(
    readonly id: number,
    readonly title: string,
    readonly description: string,
    readonly startDate: Dayjs,
    readonly endDate: Dayjs,
    readonly location: EventLocation,
    readonly status: EventStatus,
    readonly capacity: number,
    readonly remain: number,
    readonly cost: number,
    readonly options: EventOptions,
    readonly applicationStatus?: ApplicationStatus
  ) {}

  seatStatus() {
    if (this.status !== eventStatus.SCHEDULED) {
      return seatStatus.UNAVAILABLE;
    }
    if (this.applicationStatus === applicationStatus.APPLIED) {
      return seatStatus.RESERVED;
    }
    if (this.remain === 0) {
      return seatStatus.FULFILL;
    }
    if (this.remain / this.capacity < 0.25) {
      return seatStatus.LIMITED;
    }
    return seatStatus.AVAILABLE;
  }
}

export default Event;
