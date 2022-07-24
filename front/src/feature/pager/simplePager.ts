import Pager, { PagerInterface } from "./pager";

class SimplePager extends Pager implements PagerInterface {
  constructor(readonly current: number, readonly hasMore: boolean) {
    super();
  }
}

export default SimplePager;
