type LoadableState<T> =
  | {
      status: "pending";
      promise: Promise<T>;
    }
  | {
      status: "fulfilled";
      data: T;
    }
  | {
      status: "rejected";
      error: unknown;
    };

export default class Loadable<T, S = Error> {
  state: LoadableState<T>;

  constructor(promise: Promise<T>) {
    this.state = {
      status: "pending",
      promise: promise.then(
        (data) => {
          this.state = {
            status: "fulfilled",
            data,
          };
          return data;
        },
        (error) => {
          this.state = {
            status: "rejected",
            error,
          };
          throw error;
        }
      ),
    };
  }

  getData(): T {
    switch (this.state.status) {
      case "pending":
        throw this.state.promise;
      case "fulfilled":
        return this.state.data;
      case "rejected":
        throw this.state.error;
      default:
        throw Error();
    }
  }

  getError(): S | undefined {
    if (this.state.status !== "rejected") {
      return undefined;
    }

    return this.state.error as S;
  }
}
