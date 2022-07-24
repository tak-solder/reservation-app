import { useEffect, useState } from "react";

import { getMe } from "../api/userApi";
import User from "../user";

const useLoginUser = () => {
  const [user, setUser] = useState<User | undefined>();
  useEffect(() => {
    (async () => {
      const res = await getMe().catch(() => undefined);
      if (res) {
        setUser(res.user);
      }
    })();
  }, []);

  return user;
};
export default useLoginUser;
