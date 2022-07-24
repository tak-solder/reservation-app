import { ChakraProvider } from "@chakra-ui/react";
import dayjs from "dayjs";
import "dayjs/locale/ja";
import React from "react";
import { BrowserRouter, useRoutes } from "react-router-dom";
import { RecoilRoot } from "recoil";

import ScrollToTop from "./components/functional/ScrollToTop";
import Layout from "./components/ui-parts/layout/Layout";
import HistoryReservation from "./pages/history/reservation/Reservation";
import HistoryReservations from "./pages/history/reservations/Reservations";
import Home from "./pages/home/Home";
import ReservationComplete from "./pages/reserve/complete/Complete";
import ReservationEvent from "./pages/reserve/event/Event";
import ReservationEvents from "./pages/reserve/events/Events";

dayjs.locale("ja");

const Routes: React.FC = () =>
  useRoutes([
    {
      path: "/",
      element: <Home />,
    },
    {
      path: "/reservation",
      element: <ReservationEvents />,
    },
    {
      path: "/reservation/event/:id",
      element: <ReservationEvent />,
    },
    {
      path: "/reservation/complete",
      element: <ReservationComplete />,
    },
    {
      path: "/history",
      element: <HistoryReservations />,
    },
    {
      path: "/history/reservation/:id",
      element: <HistoryReservation />,
    },
  ]);

const App: React.FC = () => (
  <ChakraProvider>
    <RecoilRoot>
      <BrowserRouter basename={import.meta.env.VITE_ROUTER_BASENAME}>
        <ScrollToTop />
        <Layout>
          <Routes />
        </Layout>
      </BrowserRouter>
    </RecoilRoot>
  </ChakraProvider>
);

export default App;
