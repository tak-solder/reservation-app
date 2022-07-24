import Loadable from "../../async/loadable";
import { executeCancel } from "../api/reservationApi";
import { ExecuteCancelRequest, ExecuteCancelResponse } from "../api/types";

export type ExecuteCancelLoader = Loadable<ExecuteCancelResponse>;
const makeExecuteCancelLoader = (request: ExecuteCancelRequest) =>
  new Loadable<ExecuteCancelResponse>(executeCancel(request));
export default makeExecuteCancelLoader;
