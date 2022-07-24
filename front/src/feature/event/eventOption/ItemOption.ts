import {
  EventOptionCategory,
  EventOptionInputType,
  EventOptionInterface,
  EventOptionKey,
} from "./eventOption";

type ItemOptionMeta = {
  key: string;
  cost: number;
  quantity: number;
};

class ItemOption implements EventOptionInterface<ItemOptionMeta> {
  constructor(
    readonly key: EventOptionKey,
    readonly category: EventOptionCategory,
    readonly name: string,
    readonly description: string,
    readonly inputType: EventOptionInputType,
    readonly meta: ItemOptionMeta
  ) {}
}

export default ItemOption;
