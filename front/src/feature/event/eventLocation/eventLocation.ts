export const locationType = {
  REAL: 1,
  ONLINE: 2,
};
export type LocationType = typeof locationType[keyof typeof locationType];

class EventLocation {
  constructor(
    readonly locationType: LocationType,
    readonly name: string,
    readonly summary: string,
    readonly isPrivate: boolean,
    readonly address: string | undefined,
    readonly url: string | undefined
  ) {}

  locationTypeStr(): string {
    switch (this.locationType) {
      case locationType.REAL:
        return "現地開催";

      case locationType.ONLINE:
        return "オンライン開催";

      default:
        throw new Error("不明なロケーション");
    }
  }
}

export default EventLocation;
