export interface PagerInterface {
  current: number;
  hasMore: boolean;
}

abstract class Pager {}

export default Pager;
