import { Dayjs } from "dayjs";
import { useMemo, useState } from "react";

import Loadable from "../../async/loadable";
import { getEvents } from "../api/eventApi";
import { GetEventsRequest, GetEventsResponse } from "../api/types";

export type GetEventsLoader = Loadable<GetEventsResponse>;
const useGetEventsLoader = (initialRequest: GetEventsRequest) => {
  const [request, setRequest] = useState<GetEventsRequest>(initialRequest);

  const setFromDate = (fromDate: Dayjs) => {
    setRequest({ ...request, fromDate });
  };
  const setToDate = (toDate: Dayjs) => {
    setRequest({ ...request, toDate });
  };
  const eventsLoader = useMemo<GetEventsLoader>(
    () => new Loadable<GetEventsResponse>(getEvents(request)),
    [request]
  );

  return {
    eventsLoader,
    setFromDate,
    setToDate,
  };
};
export default useGetEventsLoader;
