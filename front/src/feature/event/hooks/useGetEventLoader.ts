import { useMemo, useState } from "react";

import Loadable from "../../async/loadable";
import { getEvent } from "../api/eventApi";
import { GetEventRequest, GetEventResponse } from "../api/types";

export type GetEventLoader = Loadable<GetEventResponse>;
const useGetEventLoader = (initialRequest: GetEventRequest) => {
  const [request, setRequest] = useState<GetEventRequest>(initialRequest);

  const setId = (id: number) => {
    setRequest({ id });
  };
  const eventLoader = useMemo<GetEventLoader>(
    () => new Loadable<GetEventResponse>(getEvent(request)),
    [request]
  );

  return {
    eventLoader,
    setId,
  };
};
export default useGetEventLoader;
