import Loadable from "../../async/loadable";
import { confirmCancel } from "../api/reservationApi";
import { ConfirmCancelRequest, ConfirmCancelResponse } from "../api/types";

export type ConfirmCancelLoader = Loadable<ConfirmCancelResponse>;
const makeConfirmCancelLoader = (request: ConfirmCancelRequest) =>
  new Loadable<ConfirmCancelResponse>(confirmCancel(request));
export default makeConfirmCancelLoader;
