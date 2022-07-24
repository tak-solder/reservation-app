import axios from "axios";

import userFactory from "./helper";
import { GetMe } from "./types";

// eslint-disable-next-line import/prefer-default-export
export const getMe: GetMe = async () => {
  const { data } = await axios.get(`${import.meta.env.VITE_API_URL}/user/me`);
  return { user: userFactory(data.user) };
};
