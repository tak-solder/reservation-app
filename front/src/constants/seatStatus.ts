export const seatStatus = {
  AVAILABLE: 1,
  LIMITED: 2,
  FULFILL: 3,
  RESERVED: 4,
  UNAVAILABLE: 5,
} as const;

export type SeatStatusValue = typeof seatStatus[keyof typeof seatStatus];
