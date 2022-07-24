import Loadable from "../../async/loadable";
import { completePayment } from "../api/paymentApi";
import { CompletePaymentResponse } from "../api/types";

export type CompletePaymentLoader = Loadable<CompletePaymentResponse>;
const makeCompletePaymentLoader = () => new Loadable<CompletePaymentResponse>(completePayment());
export default makeCompletePaymentLoader;
