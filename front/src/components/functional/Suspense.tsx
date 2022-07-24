import React from "react";

import Loading from "../ui-elements/loading/Loading";

type SuspenseProps = {
  children: React.ReactElement;
};
const Suspense: React.FC<SuspenseProps> = ({ children }) => (
  <React.Suspense fallback={<Loading />}>{children}</React.Suspense>
);

export default Suspense;
