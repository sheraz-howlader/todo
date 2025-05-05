import Cookies from "js-cookie";

export default () => {
  return {
    user: [],
    hasToken: Cookies.get('token'),
    msg: null,
  };
};
