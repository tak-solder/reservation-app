import User from "../user";

export type UserData = {
  id: string;
  lineName: string;
  lineId: string;
};

export type GetMeResponse = {
  user: User;
};
export type GetMe = () => Promise<GetMeResponse>;
