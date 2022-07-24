// import { Dayjs } from "dayjs";

class User {
  constructor(
    readonly id: number | string,
    readonly lineName: string,
    readonly lineId: string // readonly createdAt: Dayjs
  ) {}
}

export default User;
