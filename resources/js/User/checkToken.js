export const CheckToken = function () {
    const token = localStorage.getItem("authTokenPassport_user");
    const expirationTime = localStorage.getItem(
        "authTokenPassport_user_expired_at"
    );
    var currentTime = new Date().getTime();
    // nếu không có token thì redirect về trang
    // if ((!token && !expirationTime) || (token && expirationTime < currentTime)) {
    //     window.location.href = "login";
    // }
    if (token && expirationTime > currentTime) {
        return true;
    } else {
        return false;
    }
};
