import User from "../user";
import { UserData } from "./types";

const userFactory: (data: UserData) => User = (user) =>
  new User(user.id, user.lineName, user.lineId);
export default userFactory;
