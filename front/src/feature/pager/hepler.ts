import SimplePager from "./simplePager";

export type SimplePagerData = {
  current: number;
  hasMore: boolean;
};

export const makePager = (data: SimplePagerData) => new SimplePager(data.current, data.hasMore);
