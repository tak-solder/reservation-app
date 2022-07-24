import {
  EventOptionCategory,
  EventOptionInputType,
  EventOptionInterface,
  EventOptionKey,
} from "./eventOption";

type ExtraTimeOptionMeta = {
  minutes: number;
  cost: number;
  quantity: number;
};

class ExtraTimeOption implements EventOptionInterface<ExtraTimeOptionMeta> {
  constructor(
    readonly key: EventOptionKey,
    readonly category: EventOptionCategory,
    readonly name: string,
    readonly description: string,
    readonly inputType: EventOptionInputType,
    readonly meta: ExtraTimeOptionMeta
  ) {}
}

export default ExtraTimeOption;
