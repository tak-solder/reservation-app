import { useMemo, useState } from "react";

import Event, { applicationStatus, ApplicationStatus } from "../../../../feature/event/event";
import { LocationType } from "../../../../feature/event/eventLocation/eventLocation";

export type EventFilter = {
  locationType: LocationType | undefined;
  applicationStatus: ApplicationStatus | undefined;
};

// TODO #23 フィルタ処理をサーバサイドに移動して、ページネーションできるようにする
const useEventFilter = (initialEvents: Event[] = []) => {
  const [events, setEvents] = useState<Event[]>(initialEvents);
  const [eventFilter, setEventFilter] = useState<EventFilter>({
    locationType: undefined,
    applicationStatus: applicationStatus.AVAILABLE,
  });

  const filteredEvents = useMemo<Event[]>(() => {
    const locationTypeFilter = eventFilter.locationType
      ? ({ location }: Event) => location.locationType === eventFilter.locationType
      : () => true;
    const applicationStatusFilter = eventFilter.applicationStatus
      ? ({ applicationStatus }: Event) => applicationStatus === eventFilter.applicationStatus
      : () => true;
    return events.filter(locationTypeFilter).filter(applicationStatusFilter);
  }, [eventFilter.applicationStatus, eventFilter.locationType, events]);

  const setLocationType = (newLocationType: LocationType | undefined) =>
    setEventFilter({
      ...eventFilter,
      locationType: newLocationType,
    });
  const setApplicationStatus = (newApplicationStatus: ApplicationStatus | undefined) =>
    setEventFilter({
      ...eventFilter,
      applicationStatus: newApplicationStatus,
    });

  return {
    filteredEvents,
    eventFilter,
    setEvents,
    setLocationType,
    setApplicationStatus,
  };
};
export default useEventFilter;
