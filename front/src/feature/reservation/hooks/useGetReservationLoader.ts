import { useMemo, useState } from "react";

import Loadable from "../../async/loadable";
import { getReservation } from "../api/reservationApi";
import { GetReservationRequest, GetReservationResponse } from "../api/types";

export type GetReservationLoader = Loadable<GetReservationResponse>;
const useGetReservationLoader = (initialRequest: GetReservationRequest) => {
  const [request, setRequest] = useState<GetReservationRequest>(initialRequest);

  const setReservationId = (id: number) => {
    setRequest({ id });
  };
  const reservationLoader = useMemo<GetReservationLoader>(
    () => new Loadable<GetReservationResponse>(getReservation(request)),
    [request]
  );

  return {
    reservationLoader,
    setReservationId,
  };
};
export default useGetReservationLoader;
