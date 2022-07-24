import { useMemo, useState } from "react";

import Loadable from "../../async/loadable";
import { getReservations } from "../api/reservationApi";
import { GetReservationsRequest, GetReservationsResponse } from "../api/types";
import { ReservationStatus } from "../reservation";

export type GetReservationsLoader = Loadable<GetReservationsResponse>;
const useGetReservationsLoader = (initialRequest: GetReservationsRequest) => {
  const [request, setRequest] = useState<GetReservationsRequest>({
    status: initialRequest.status,
    page: initialRequest.page || 1,
  });

  const setStatus = (status: ReservationStatus) => {
    if (status === request.status) {
      return;
    }
    setRequest({
      status,
      page: 1,
    });
  };
  const setPage = (page: number) => {
    if (page === request.page) {
      return;
    }
    if (!Number.isInteger(page)) {
      throw Error(`page required int: page=${page}`);
    }
    setRequest({ ...request, page });
  };

  const reservationsLoader = useMemo<GetReservationsLoader>(
    () => new Loadable<GetReservationsResponse>(getReservations(request)),
    [request]
  );

  return {
    reservationsLoader,
    setStatus,
    setPage,
  };
};

export default useGetReservationsLoader;
