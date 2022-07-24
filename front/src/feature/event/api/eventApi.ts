import axios from "axios";

import eventFactory from "./helper";
import { GetEvent, GetEvents } from "./types";

export const getEvents: GetEvents = async (req) => {
  const params = {
    fromDate: req.fromDate?.format("YYYY-MM-DD HH:mm:ss"),
    toDate: req.toDate?.format("YYYY-MM-DD HH:mm:ss"),
  };

  const { data } = await axios.get(`${import.meta.env.VITE_API_URL}/event/get-events`, { params });
  return { events: data.events.map(eventFactory) };
};

export const getEvent: GetEvent = async ({ id }) => {
  const params = {
    id,
  };
  const { data } = await axios.get(`${import.meta.env.VITE_API_URL}/event/get-event`, { params });
  if (!data.event) {
    return { event: undefined };
  }
  return { event: eventFactory(data.event) };
};
